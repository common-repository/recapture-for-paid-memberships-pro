<?php

class RecapturePaidMembershipsPro extends RecaptureBasePlatform {
    function get_name() {
        return 'pmpro';
    }

    public function add_actions() {
        add_action('recapture_run_export', [$this, 'run_export']);

        if (get_option('recapture_is_exporting') == true) {
            add_action('admin_notices', [$this, 'exporting_message']);
        }

        add_action('wp', [$this, 'site_loaded']);
        add_action('pmpro_checkout_after_form', [$this, 'checkout_after_form']);
        add_action('pmpro_added_order', [$this, 'order_added_or_updated']);
        add_action('pmpro_updated_order', [$this, 'order_added_or_updated']);

        if (isset($_GET['recapture-export-memberships']) && current_user_can('administrator')) {
            check_admin_referer('export_recapture_memberships');
            $this->run_export(true);
            die();
        }
    }

    public function remove_actions() {
        remove_action('wp', [$this, 'site_loaded']);
    }

    public function site_loaded() {
    }

    public function regenerate_cart_from_url($cart, $contents) {
    }

    protected function convert_order($order) {
        $billing = $order->billing;
        $level = new PMPro_Membership_Level($order->membership_id);
        $discount_code = $order->getDiscountCode(true);

        $data = (object) [
            'externalId' => null, //  backend gets the cart from the email address
            'orderId' => $order->code,
            'shippingCountry' => $billing
                ? $billing->country
                : null,
            'billingCountry' => $billing
                ? $billing->country
                : null,
            'email' => $order->Email,
            'firstName' => $order->FirstName,
            'lastName' => $order->LastName,
            'phone' => $order->PhoneNumber,
            'cart' => [
                'checkoutUrl' => pmpro_url('checkout', '?level=' . $level->id),
                'products' => [
                    [
                        'externalId' => $level->id,
                        'sku' => $level->id,
                        'name' => $level->name,
                        'price' => floatval($order->total),
                        'imageUrl' => '',
                        'quantity' => 1
                    ]
                ],
                'tax' => 0,
                'shipping' => 0,
                'discountCodes' => $discount_code ? [$discount_code] : []
            ]
        ];

        // convert the cart
        RecaptureUtils::convert_cart($data);

        // set a new cart id
        RecaptureUtils::set_new_cart_id();
    }

    public function order_added_or_updated($order) {
        // Stripe payments are set to 'success' before they are completed, then to 'token', we should ignore 'success'
        // payments if we don't have a transaction id
        if ($order->gateway === 'stripe' &&
            $order->status === 'success' &&
            empty($order->payment_transaction_id)) {
            return;
        }

        if ($order->status === 'success') {
            $this->convert_order($order);
        }
    }

    public function checkout_after_form() {
        // output Recapture JS to log the cart
        global $pmpro_level, $discount_code;

        // don't send the cart if the user already has this level
        $user_has_level = pmpro_hasMembershipLevel($pmpro_level->id);

        // let the user override this in their own theme/plugin so that they can disable sending carts
        // to Recapture for specific user subscriptions or levels
        $should_ignore = apply_filters('recapture_should_ignore_cart', $user_has_level, $pmpro_level);

        if (!$should_ignore) {
            ?>
            <script>
                __recaptureCart = {
                    checkoutUrl: '<?php echo esc_url(pmpro_url("checkout", "?level=" . $pmpro_level->id)) ?>',
                    products: [
                        <?php echo json_encode([
                            'externalId' => $pmpro_level->id,
                            'sku' => $pmpro_level->id,
                            'name' => $pmpro_level->name,
                            'price' => floatval($pmpro_level->initial_payment),
                            'imageUrl' => '',
                            'quantity' => 1
                        ]) ?>
                    ],
                    tax: 0,
                    shipping: 0,
                    discountCodes: <?php echo json_encode($discount_code ? [$discount_code] : []) ?>
                };
            </script>
            <?php
        }

        // Add the user's email address for recovery
        $current_user = wp_get_current_user();

        $email = $current_user
            ? $current_user->user_email
            : null;

        if ($email && !empty($email)) {
            ?>
            <input type="hidden" value="<?php esc_attr_e($email); ?>"/>
            <?php
        }
    }

    public static function is_ready() {
        return defined('PMPRO_VERSION');
    }

    public function enqueue_scripts() {
        if (!pmpro_is_checkout()) {
            return;
        }

        // include js cookie
        wp_enqueue_script(
            'jquery-deparam',
            self::get_base_path().'/js/jquery-dparam.js',
            ['jquery'],
            RECAPTURE_VERSION
        );

        wp_enqueue_script(
            'js-cookie',
            self::get_base_path().'/js/js.cookie-2.2.1.min.js',
            ['jquery'],
            '2.2.1'
        );

        wp_enqueue_script(
            'recapture',
            self::get_base_path().'/js/recapture-pmp.js',
            ['jquery'],
            RECAPTURE_VERSION
        );
    }

    public function add_hidden_email_input() {

        $current_user = wp_get_current_user();

        $email = $current_user
            ? $current_user->user_email
            : null;

        if (!$email || empty($email)) {
            return;
        }

        ?>
        <input type="hidden" value="<?php esc_attr_e($email); ?>"/>
        <?php
    }

    public function run_export($forced = false) {
        echo 'Starting export'.PHP_EOL;
        global $wpdb;

        $offset = get_option('recapture_export_offset');
        $offset = $offset == false
            ? 0
            : $offset;

        $page_size = 20;

        $users = get_users([
            'number' => $page_size,
            'offset' => $offset,
        ]);

        // no more to process
        if (count($users) == 0) {
            echo 'Nothing to export, exiting.'.PHP_EOL;
            delete_option('recapture_is_exporting');
            return;
        }

        echo 'Found '.count($users).' users to export'.PHP_EOL;

        // update the offset
        update_option('recapture_export_offset', $offset + count($users));

        // send to Recapture
        foreach ($users as $user) {
            $order = new MemberOrder();
            $order_id = $order->getLastMemberOrder($user->ID, 'success');

            if ($order_id == false) {
                continue;
            }

            $order_count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) total FROM $wpdb->pmpro_membership_orders WHERE user_id = %d AND status='success';",
                    $user->ID
                )
            );

            if ($order == false) {
                echo 'Ignoring '.esc_html($user->user_email).' because there are no orders'.PHP_EOL;
                continue;
            }

            $data = (object) [
                'email' => $user->user_email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'order_count' => $order_count,
                'last_ordered_at' => gmdate("Y-m-d\TH:i:s\Z", $order->timestamp)
            ];

            echo 'Exporting: '.json_encode($data).PHP_EOL;

            // convert the cart in Recapture
            RecaptureUtils::create_or_update_unique_customer($data);
        }

        // schedule
        if ($forced == false) {
            wp_schedule_single_event(time(), 'recapture_run_export');
        }
    }

    public function exporting_message() {
        $message = sprintf(
            __('Recapture is exporting memberships, this message will disappear when the process is finished', RECAPTURE_TEXT_DOMAIN));

        ?>
            <div class="notice notice-info">
                <p>
                    <?php esc_html_e($message) ?>
                </p>
            </div> 
        <?php
    }
}
