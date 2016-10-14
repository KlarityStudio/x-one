2.6.10 *October 14, 2016*
---
* Feature - Added rule 'User Purchased Products'
* Feature - Added order_item data to the 'User Purchases Product' trigger
* Feature - Added variable order_item.meta 
* Feature - Improvements to queue report
* Fix - Potential encoding issue with email click tracking URLs
* Fix - Typo in unsubscribe form template
* Tweak - Refactored how log data was stored and retrieved
* A number of other minor fixes and internal improvements


2.6.9 *October 7, 2016*
---
* Fix - Compatibility issues with older versions of WordPress and WooCommerce


2.6.8 *September 30, 2016*
---
* Feature - Added support for subscription variations to all subscription triggers
* Tweak - Added action 'automatewoo/email/before_send'


2.6.7 *September 22, 2016*
---
* Feature - Allow custom email templates to have a custom email 'from name' and 'from email'
* Tweak - Rules admin box text
* Fix - Compatibility issue with older WooCommerce versions (only affected Refer A Friend add-on)


2.6.6 *September 15, 2016*
---
* Feature - Added constant AW_PREVENT_WORKFLOWS which, if true, prevents all workflows from running and instead adds a WooCommerce log entry for each run
* Tweak - Improve auto fixing of URLs in email content


2.6.5 *September 8, 2016*
---
* Tweak - Avoid conflict with YITH email customizer plugin
* Fix - Compatibility issue with older WooCommerce versions


2.6.4 *September 5, 2016*
---
* Fix - Missing settings field type for the Refer A Friend add-on
* Minor admin text tweaks and fixes


2.6.3 *September 2, 2016*
---
* Feature - Added variables order.billing_address and order.shipping_address
* Tweak - When sending a test email coupons will now be generated and labeled as test coupons, previously coupons did not persist
* Fix - Issue with user first and last name's not found for queued workflows based on guest orders 
* Fix - Degradation issue with unsupported PHP versions


2.6.2.2 *August 31, 2016*
---
* Fix - Issue with the 'Order Is Customer's First' rule


2.6.2.1 *August 31, 2016*
---
* Fix - Config issue with 'Abandoned Cart (Users)' trigger


2.6.2 *August 29, 2016*
---
* Feature - New Trigger 'Subscription Before Renewal'
* Feature - Support added for the plugin [Email Customizer for WooCommerce](https://codecanyon.net/item/email-customizer-for-woocommerce/8654473)
* Tweak - Improvements to 'User Has Not Purchased For a Set Period' trigger. 
It now checks for inactive users once a day rather than once a week and the queries are far more efficient.
* Tweak - Refactored admin settings code and abandoned cart triggers
* Fix - Issue where the order count and total spent for the user was not correct due to event ordering
* Fix - Rare issue where AW admin menu did not appear
* Fix - Admin list table issue with older WP versions


2.6.1 *August 23, 2016*
---
* Feature - Improve workflow statuses - now they are either Active/Disabled rather than the standard WordPress post statuses. 
Also there is a new UI that gives admins a nice way to manage which workflows are active. Please note there is a database migration for the new statuses.
* Feature - New Rule: Order Coupons
* Feature - New Rule: Cart Coupons
* Feature - New Rule: Cart Items
* Feature - New Variable: order.date
* Feature - Abandoned carts now support coupons
* Tweak - Internal improvements to ActiveCampaign integration
* Fix - Issue with sending test emails


2.6 *August 18, 2016*
---
* Feature - [Rules](https://automatewoo.com/version-2-6/) - Workflow trigger options have been completely rebuilt into rules with a better UI and more flexibility. 
If you are developing custom triggers please note that a number of methods have been deprecated more info can be found in the [release post](https://automatewoo.com/version-2-6/)
* Feature - Add multi status support to 'Order Status Changes' trigger
* Fix - Better tax support for the Cart Table product display template


2.5.2 *August 9, 2016*
---
* Feature - Add 'Top Selling' option for the shop.products variable


2.5.1 *August 2, 2016*
---
* Fix - Issue with saving settings from v2.5


2.5 *August 1, 2016*
---
* Feature - Manual Order Trigger Tool - Can be used to run a workflow on existing orders
* Feature - Bulk deletion is now supported on logs, guests, conversions, carts and queued event
* Tweak - Logs list view has been moved to its own menu item (one less click to get to)
* Tweak - Tools also moved from settings to its own menu item
* Tweak - Dropped support for WP shortcodes in the email body because the markup outputted by shortcodes is generally not intended for use in HTML emails
* Fix - Issue where empty carts could stored if capturing emails from non checkout pages
* Fix - {{ order_item.attribute }} variable was not loading correctly


2.4.14 *July 28, 2016*
---
* Feature - Add variables user.order_count user.total_spent
* Tweak - Add filter for guest capture selectors 'automatewoo/guest_capture_fields'


2.4.13 *July 27, 2016*
---
* Feature - Add limit parameter to product display templates
* Fix - Issue with the loading of admin wysiwyg editors
* Fix - Issue where abandoned carts could be restored multiple times if all items were removed and the restore token was still present in the URL
* Tweak - Tidy up admin page URLs


2.4.12 *July 20, 2016*
---
* Fix - Issue where the 'Cart Table' product template could display zero as the line total
* Fix - Validation issue on subscription products field
* Tweak - Minor improvement to abandoned cart tracking
* Tweak - Internal changes for better add-on integration


2.4.11 *July 18, 2016*
---
* Feature - Add support for multiple categories/tags when using the {{ shop.products }} variable
* Feature - Automatically add country codes for SMS recipients when using the {{ order.billing_phone }} variable
* Tweak - Refactor how trigger options should be accessed to improve efficiency. Two methods have been deprecated


2.4.10 *July 14, 2016*
---
* Tweak - Add guests support for MailChimp actions


2.4.9 *July 12, 2016*
---
* Feature - New Trigger - New Guest Captured
* Feature - New Report - Guests
* Tweak - Add setting to enable/disable abandoned cart tracking (default is enabled)
* Tweak - Add filter for session tracking cart cookie name
* Tweak - Make dates inclusive for the manual subscription trigger tool


2.4.8 *July 7, 2016*
---
* Fix - Issue where conversion tracking logic could miss a newly registered customer's conversion
* Fix - Issue with guest abandoned carts caused by the variable refactoring in v2.4.7


2.4.7 *July 5, 2016*
---
* Feature - User type select boxes on triggers now allow multiple selections
* Tweak - Refactor variable filters to allow for easier integration from 3rd party developers
* Tweak - Improve session tracking to better support varnish caching
* Tweak - Remove short descriptions from the product grid templates 


2.4.6 *June 30, 2016*
---
* Tweak - Improve performance by loading some classes with dependency injection
* Tweak - Improvements to session tracking logic
* Tweak - Automatically close variable modal after copy to clipboard action
* Tweak - Code refactoring around variables and data types
* Tweak - Add filters **automatewoo/mailer/from_address**, **automatewoo/mailer/from_name**


2.4.5 *June 24, 2016*
---
* Feature - Improve tools UI and add a new tool 'Manual Subscriptions Trigger'
* Tweak - On order triggers the 'Is Users First Order?' also checks for any guest orders that match a users email
* Tweak - Added support product variation images in product display templates
* Tweak - Internal improvements and code refactoring


2.4.4 *June 20, 2016*
---
* Fix - Issue with 'Subscription Payment Failed' trigger


2.4.3 *June 15, 2016*
---
* Feature - Consolidate AutomateWoo pages under a single admin menu item. Required for when new pages will be added in the future.
* Feature - Add system check for PHP version
* Feature - 'User Has Not Purchased For a Set Period' trigger is now processed in batches to support huge user counts
* Feature - Improvements to license page UI
* Other minor fixes and performance improvements


2.4.2 *June 10, 2016*
---
* Tweak - Add a filter to allow modification of a workflow variable's value
* Fix - Issue on some servers where variable modals did not display correctly


2.4.1 *June 7, 2016*
---
* Fix - Issue where pending payment triggers would not fire when 'pending' was the unchanged initial status of an order


2.4 *June 6, 2016*
---
* Feature - [New UI for workflow variables](https://automatewoo.com/introducing-new-ui-workflow-variables/)
* Tweak - Cart restore links are now use a token rather than ID for added security


2.3.4 *May 6, 2016*
---
* Fix - Product images sizing issue


2.3.3 *April 26, 2016*
---
* Tweak - Additional check for the **New User Account Created** trigger


2.3.2 *April 24, 2016*
---
* Feature - New template **cart-table.php** added for use with the {{ cart.items }} variable
* Fix - Issue where product images width could overflow on some custom email templates 


2.3.1 *April 20, 2016*
---
* Tweak - Improvements to MailChimp API Integration 


2.3 *April 13, 2016*
---
* Feature - WPML Support
* Feature - Upgrade MailChimp API to 3.0
* Feature - WooPOS Support
* Feature - New trigger 'Wishlist - User Adds Product' (YITH only)
* Feature - New trigger 'Trigger Order Action'
* Feature - Add system checker tool that can check if WP cron is functioning 
* Feature - Add current queue count to workflows admin column
* Tweak - Abandoned cart data is now split into 2 tables, 1 for guests, 1 for carts
* Tweak - Refactor and improve session tracking code
* Fix - Gmail image aspect ratio issue


2.2.1 *March 25, 2016*
---
* Feature - New option on abandoned cart triggers to limit send frequency for a user/guest
* Tweak - Add fallback for user.firstname and user.lastname to order billing fields
* Tweak - Minor improvements to Wishlist triggers, add descriptions
* Tweak - Add new email/styles.php template, add image alignment classes


2.2 *March 16, 2016*
---
* Feature - Logs Report now has a modal which displays additional info
* Feature - New report that shows a details conversions list
* Feature - New 'Unique Clicks' dimension to click tracking report
* Feature - New action 'Resend Order Emails'
* Feature - New trigger 'Order Note Added'
* Feature - New variable {{ shop.products }} supports displaying products by category, tag or custom filter
* Feature - New variable {{ order.related_products }}
* Feature - Custom email templates can have dynamic content via the new AW_Mailer_API 
* Feature - New trigger 'Order Note Added'
* Feature - New tool added that lets you reset all records for a workflow  
* Feature - New action 'Clear Queued Events'
* Tweak - Email tracking click events now also count as an open if one has not already been recorded (images may be have been blocked)
* Tweak - Email content has a new filter specifically designed for sending instead of using 'the_content'
* Fix - Some dates we're being shown as GMT
* Fix - Bug where Google Analytics tracking codes we're not being appended to URLs


2.1.14 *February 28, 2016*
---

* Tweak - Minor improvement to conversion tracking logic
* Tweak - Improve display of date and time fields in admin area
* Tweak - Improve 'Unsubscribe' link flexibility 
* Tweak - Add CHANGELOG.md file

2.1.13 *February 20, 2016*
---

* Fix – Allows plugin to continue to work as normal after licence expiry
* Tweak – Remove licence email field, activation to happen via licence key only
* Tweak – Add a dismissible admin notice when licence has expired
* Tweak – Dev installs now require a valid licence key

2.1.12 *February 8, 2016*
---

* Feature – New trigger – Guest leaves review
* Fix – Issue where reviews that were immediately approved did not get caught by user review trigger

2.1.11 *February 6, 2016*
---

* Feature – Improved UI for email preview
* Feature – Ability to send an email preview as a test
* Feature – Ability to define an order in which workflows will run when triggered
* Feature – Trigger Order Includes a Specific Product now supports product variations

2.1.10 *February 3, 2016*
---

* Feature – Support for the [WooThemes Shipment Tracking](https://www.woothemes.com/products/shipment-tracking/) plugin with new variables
	* {{ order.tracking_number }}
	* {{ order.tracking_url }}
	* {{ order.date_shipped }}
	* {{ order.shipping_provider }}
* Feature – Improved abandoned cart delay accuracy, 15 minute intervals are now possible
* Feature – Support for triggers to have descriptions in the backend
* Tweak – User type and user tag fields will be revalidated before a queued run
* Fix – Removed the guest select option on the Abandoned Cart (Users) trigger

2.1.9.1 *January 29, 2016*
---

* Fix – Potential fatal error on some servers

2.1.9 *January 29, 2016*
---

* Feature – Google Analytics tracking on URLs in SMS body
* Feature – New trigger: Order Placed fires as soon as an order is created in the database regardless of status
* Feature – New variable {{ order.view_url }}
* Feature – New variable {{ order.payment_url }}
* Fix – Issue for email tracking URLs with ampersands in them
* Improvement to payment gateway select box stability
* Internal improvements and code refactoring

2.1.8 *January 18, 2016*
---

* Fix – Bug preventing the user.meta variable from working
* Tweak – Abandoned cart are processed every 30 mins rather than every hour to improve time accuracy
* Tweak – Minor improvements to cron

2.1.7 *January 12, 2016*
---

* Fix – Issue where user tags could not be managed in WP 4.1.1

2.1.6 *December 28, 2015*
---
* Feature – Add option to delete or unsubscribe user on the Remove from MailChimp list action
* Tweak – Improvements to abandoned cart clearing logic
* Tweak – Improvement to automatewoo_custom_validate_workflow filter
* Tweak – Simulate signed out user when previewing emails
* Fix – MailChimp lists transient key was incorrect

2.1.5 *December 15, 2015*
---
* New action: Change Subscription Status
* New variable: {{ subscription.view_order_url }}
* Internationalize phone number for SMS actions
* Cron stability improvements

2.1.4 *December 5, 2015*
---

* Option to add Google Analytics Campaign tracking params to links in emails
* Fix to subscription products field logic
* Make Times Run value a link to a filtered logs view

2.1.3 *December 3, 2015*
---

* Add ability to filter logs by workflow and by user
* Logic fix for subscriptions skip first payment option
* Fix issue with {{ shop.products_on_sale }} variable
* Ensure WooCommerce Subscriptions is at least version 2.0
Fix admin display issue with product select field

2.1.2 *November 28, 2015*
---
* Fix issue where the reports graph dates were not being converted to the site timezone
* Fix an issue with email preview display
* Improvement to the User Leaves Review trigger so that doesn’t fire until the comment is approved
* New feature allowing export of users in a tag to CSV
* Improvement to the user tag query for the user list admin view

2.1.1 *November 25, 2015*
---
[Check out the version 2.1 blog post](https://automatewoo.com/version-2-1/)

2.0.2 *October 27, 2015*
---
* Abandoned Cart email capturing can now be enabled on any form field, not just the checkout
* Internal improvements

2.0.1 *October 17, 2015*
---
* Fix an issue where Send Email actions created before 2.0 might not be styled

2.0.0 *October 14, 2015*
---
[Check out the version 2.0 blog post](https://automatewoo.com/version-2/)

* Feature: Plain text emails and custom email templates
* Feature: Conversion tracking expanded to any workflow, not just abandoned cart
* Feature: Customer tags
* Feature: ActiveCampaign integration
* Feature: New report for currently stored carts
* Feature: Once Per User checkbox has been changed to Limit Per User number field
* Feature: New trigger Workflow Times Run Reaches
* Feature: New trigger User Order Count Reaches
* Feature: New action Change Post Status
* Feature: Order Status Changes trigger now lets you select a from and to status. This trigger also has support for custom order statuses.
* Feature: New options to target orders for specific countries or orders that used a certain payment method.
* Tweak: Refactor abandoned cart code into model
* Fix: Issue where some fields where not cloning on coupon generation
* Fix: Issue where visitor key sometimes wasn’t stored for abandoned carts

1.1.10 *September 26, 2015*
---
* New Trigger: Order Payment Pending
* Fix issue where {{ order.total }} was blank

1.1.9 *September 23, 2015*
---
* SMS Integration via Twilio
* Performance Improvements

1.1.8 *September 21, 2015*
---
* Performance improvements
* Bug fixes

1.1.7 *September 14, 2015*
---
* New Trigger: Order Includes Product from Taxonomy Term
* New option on order triggers to select payment method

1.1.6 *September 5, 2015*
---
* New Trigger: Order Includes Product Variation with Specific Attribute
* New Text Variable: {{ order_item.attribute | slug: … }}
* New Action: Add User to Mad Mimi List

1.1.5 *September 2, 2015*
---
* Fix an issue where the licence check could fail if WP Cron occurred over SSL

1.1.4 *September 1, 2015*
---
* New Trigger:  Order Includes Product from a Specific Tag
* New Action: Change Order Status
* New Action: Add/Update Product Meta

1.1.3 *August 27, 2015*
---
* Add an additional check to ensure stored abandoned carts are cleared when an order is created
* Fix an issue where checking ‘Once Per User’ prevents order triggers firing for guests
* Improvements to Conversion Tracking

1.1.2 *August 24, 2015*
---
* New report: Conversion tracking (Only tracks Abandoned Carts for now)
* New Trigger Option: Check Status Hasn’t Changed Before Run (useful when queuing)
* New Text Variable Parameter: template lets you define alternative templates for:
	* {{ cart.items }}
	* {{ order.items }
	* {{ order.cross_sells }}
	* {{ wishlist.items }}
* New Email Product List Templates:  
	* product-grid-2-col.php
	* product-grid-3-col.php
	* product-rows.php
* Important: template removed product-listing.php. Instead use product-grid-2-col.php
* Admin area: Expanded actions will now stay expanded after saving

1.1.1 *August 20, 2015*
---
* Add conversion tracking on abandoned carts (report coming soon)
* Fix an issue that prevented triggers firing after guest order

1.1.0 *August 19, 2015*
---
* Total overhaul of the Abandoned Cart system to now use pre-submit email capturing as well as detecting registered users when they aren’t logged in. Implement with new trigger: Abandoned Cart (Guests)

1.0.6 *August 16, 2015*
---
* New Text Variable {{ wishlist.itemscount }}
* New Text Variable {{ order.number }}
* Order Queue by Run Date
* Improve Coupon Generation

1.0.5 *August 13, 2015*
---
* Adds integration with the free YITH Wishlists plugin
* Change the image size of the ‘product.featured_image’ text variable
* Improvements to cart tracking
* Improvements to wishlist triggers

1.0.4 *August 11, 2015*
---
* Improvements to Abandoned Cart
* Allow coupon prefix to be blank
* Minor other fixes

1.0.3 *July 30, 2015*
---
* New feature: Preview ability on emails!
* Security improvements
* Internal improvements

1.0.2 *July 28, 2015*
---
* Fix some licence issues

1.0.1 *July 26, 2015*
---
* UI Improvements to Text Variables
	* Single click to select a  Text Variable
	* Change editor to sans serif
* Small changes to some labels

1.0.0 *July 20, 2015*
---
* Launch it!