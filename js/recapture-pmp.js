(function () {
  function sendCartToRecapture(onFinished = null) {
    const cartId = Cookies.get("racart");

    // Save for later..
    window.__recaptureOriginalProducts = __recaptureCart.products;

    const cart = {
      externalId: cartId,
      checkoutUrl: __recaptureCart.checkoutUrl,
      customerId: Cookies.get("ra_customer_id"),
      products: __recaptureCart.products,
      shipping: 0,
      tax: 0,
      discountCodes: __recaptureCart.discountCodes || [],
    };

    const email = jQuery("#bemail").val();

    if (email) {
      cart.email = email;
    }

    const phone = jQuery("#bphone").val();

    if (phone) {
      cart.phone = phone;
    }

    ra("setCart", [cart, onFinished]);
  }

  function onLoad() {
    // make sure we have valid data from WP
    if (!__recaptureCart) {
      return;
    }

    sendCartToRecapture();

    jQuery("#discount_code").change(function () {
      setTimeout(function () {
        const discountCode = jQuery("#discount_code_message").hasClass(
          "pmpro_success"
        )
          ? jQuery("#discount_code").val()
          : "";

        // Update the checkout URL
        if ("URLSearchParams" in window) {
          const searchParams = new URLSearchParams(window.location.search);
          searchParams.set("discount_code", discountCode);
          __recaptureCart.checkoutUrl =
            location.protocol +
            "//" +
            location.host +
            location.pathname +
            "?" +
            searchParams.toString();
        }

        // We have a discount code!
        if (discountCode) {
          __recaptureCart.discountCodes = [discountCode];
          __recaptureCart.products = [
            {
              externalId: code_level.id,
              sku: code_level.id,
              name: code_level.name,
              price: Number(code_level.initial_payment),
              imageUrl: "",
              quantity: 1,
            },
          ];
        } else {
          __recaptureCart.discountCodes = [];
          __recaptureCart.products = __recaptureOriginalProducts;
        }

        // update the cart
        sendCartToRecapture();
      }, 1000);
    });

    const submit = jQuery(".pmpro_btn-submit-checkout");

    submit.on("click.recapture", (e) => {
      const event = jQuery.Event(e);

      event.preventDefault();
      event.stopPropagation();

      sendCartToRecapture(() => {
        submit.off("click.recapture");
        submit.trigger("click");
      });

      return false;
    });
  }

  jQuery(document).ready(onLoad);
})();
