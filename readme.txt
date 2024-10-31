=== WordPress abandoned cart recovery and email marketing for Paid Memberships Pro by Recapture ===
Contributors: recaptureio
Tags: Tags: abandoned carts, email marketing, paid memberships pro, cart abandonment, membership plugins
Requires at least: 3.8.0
Requires PHP: 5.6
Tested up to: 6.6
Last Updated: 2024-Aug-07
Stable tag: 1.0.12
License: GPLv2 or later

Recapture is the easiest and most effective way to recover abandoned carts and do email marketing for your Paid Memberships Pro site in WordPress.

== Description ==

[Main Site](https://recapture.io/) | [Support](https://recapture.io/contact) | [Docs](https://docs.recapture.io/)

Recapture is the easiest and most effective way to recover abandoned carts and do email marketing for your Paid Memberships Pro site.  We also support [Easy Digital Downloads abandoned cart recovery](https://wordpress.org/plugins/recapture-for-edd/) as well!

**NOTE:**
> **Requires: Paid Memberships Pro 2.5.7** or newer and a free Recapture account

Recapture helps your site increase sales.  This plugin connects Recapture to Paid Memberships Pro to send triggered emails to your customers to recover abandoned carts (membership signups that didn't happen) for Paid Memberships Pro, win back old customers, or request reviews.

= ** Recapture has a long history of success with Abandoned Carts ** =

_Recapture has already helped merchants generate **over $280,000,000** in additional revenue since 2015._  We're recovering on average $1,000,000+ a week for sites like yours.

Recapture's [abandoned cart recovery for Paid Memberships Pro](https://recapture.io/abandoned-carts-pmpro) helps your ecommerce site **recover lost revenue** from abandoned carts/signups for Paid Memberships Pro.  Recapture tracks when signups are abandoned on your site, then lets you send recovery emails to encourage the customers who abandoned these carts to complete the purchase.

You can set up as many campaigns and recovery emails as you'd like, and customize the text and design of every email sent.

Recapture has best-in-class email capture capabilities--using email popups, or our new "Add to Cart" email popup, where users enter an email before they add the item to the cart, ensuring easier recovery.

= ** Emails are Ready-to-go on Install, but easily customized ** =

_You don't need to spend a lot of time setting up Recapture before you can benefit from it._  

Recapture's emails are setup using best practices out-of-the-box so you can turn them on immediately.  Or you can change them using our friendly drag and drop based editor, or even completely customize the content using full HTML.  The choice is yours!

Campaigns come configured with ideal timings, but you're free to set them as you'd like (e.g., send 3 recovery emails per abandoned cart, or a series of 4 emails in a winback campaign), customize their send timing, and use a drag-and-drop editor to change the content.  **Very friendly for non-technical users.**  Setting up recovery for abandoned carts on Paid Memberships Pro has never been easier.

= ** Winbacks, Review Reminders, and Email Collectors, oh my! ** =

_Installing Recapture gives you the features of 4 separate plugins with less hassle_  

Besides **abandoned carts for Paid Memberships Pro**, we support **email popups** to encourage list building, we support **review reminder emails** to get customers to provide a review after purchase (social proof increases sales!), and **winback emails** to encourage customers to be repeat buyers.  All of these increase your average order value, making your site more profitable.

= ** Won't drag your site down ** =

_Average load time for Recapture's JavaScript library is between 30-600 milliseconds, so your site won't suffer_

Tracking for orders and carts is done and stored in Recapture, not your site's database.  We send emails from our robust cloud infrastructure using best practices (SPF, DKIM, etc) to ensure maximum delivery and open rates.  This means your site **stays FAST** for buyers while we track analytics and carts for you, allowing you see everything you need in a click or two.

Recapture is backed by a team with a long history of ecommerce success.  Recapture Abandoned Carts for Paid Memberships Pro works on any site and scales automatically with our AWS load-balanced, multi-server infrastructure.  We handle sites of all sizes.  No need to worry as you grow!

= ** Friendly, responsive support ** =

_We (heart) our merchants and ecommerce_

Our #1 goal is to make your site more successful, and we love to do it!  [Contact us for support](http://recapture.io/contact/) and find out what sets us apart from so many other WordPress plugins.  Live chat available in the Recapture dashboard.

= More Details =

**Translators:** the plugin text domain is: `recapture-for-pmpro`

 - Visit [Recapture.io](https://recapture.io) for more details on Recapture, and to see how our average merchant can boost revenue 10% or more in just 5 minutes.
 - Browse the [documentation](http://docs.recapture.io) for questions, FAQs and more.
 - [Contact us for support](http://recapture.io/contact/) on our site

== Installation ==

1.  Be sure you're running Paid Memberships Pro 2.5 or newer in your shop.

2.  To install the plugin, you can do one of the following:

    - (Recommended) Search for "Recapture Abandoned Carts for Paid Memberships Pro" under Plugins &gt; Add New
    - Upload the entire `recapture-for-pmpro` folder to the `/wp-content/plugins/` directory.
    - Upload the .zip file with the plugin under **Plugins &gt; Add New &gt; Upload**

3.  Activate the plugin through the 'Plugins' menu in WordPress

4.  Click the "Configure" plugin link or go to **Recapture** from the main menu to connect your site to Recapture quickly.

5.  Save your settings!

== Frequently Asked Questions ==

= Do I need anything else to use this plugin? =

Yes, a free Recapture account is required to recover abandoned carts/signups for your Paid Memberships Pro site (we'll create one for you on install, automatically!).  You can recover up to $500 completely free, You can [learn more about Recapture pricing here](https://recapture.io/pricing/) for our paid accounts.

= When do you consider a cart "abandoned" and how do you get emails from my customers? =

A cart is considered abandoned if a customer has added items to the cart, but has not checked out or shown any cart activity for at least 30 minutes.  At this point, Recapture starts the timers for your recovery emails.

= How do you get emails from my customers? =

Recapture can get an email in a few different ways--First, any logged in customer who abandons a cart will receive recovery emails because of their WP profile.  Any guest customer who has entered a full, valid email address somewhere in the site (e.g.  email popup, our Add to Cart popup, even OTHER plugins that collect emails--Recapture can track that, easily) will receive recovery emails too.  Our success here comes from a few secrets in our JavaScript library that makes Recapture so powerful.

= Are you GDPR compliant? =

Completely.  As of May 25, 2018, we are fully GDPR compliant.  Details [here](https://recapture.io/gdpr/).

== Screenshots ==

1.  Experience the famous 5-minute install with Recapture
2.  Configure your site settings once you're connected
3.  Activate your campaigns in Recapture to start increasing sales!

== Changelog ==

= 1.0.12 =
* Fix an issue adding a Recapture admin sub-menu

= 1.0.11 =
* Ignore orders with a status of 'success' of they are from Stripe and do not have a transaction ID because they have not yet completed.

= 1.0.10 =
* Add recapture_should_ignore_cart WordPress action to support ignoring carts based on custom logic

= 1.0.9 =
* Disable create an abandoned cart in Recapture if the user already has the selected level.

= 1.0.8 =
* Send user agent with all requests to Recapture so that we can exclude requests made from crawlers/bots
* Tested against WP 6.5

= 1.0.7 =
* Correctly handle failed payments

= 1.0.6 =
* Tested against WP 6.3

= 1.0.5 =
* Capture phone number in checkout process to use with order update notifications

= 1.0.4 =
* WordPress 6.0 support

= 1.0.3 =
* Update Recapture API url

= 1.0.2 =
* WordPress 5.9 support

= 1.0.1 =
* Fix recurring order amount

= 1.0.0 =
* Initial release
