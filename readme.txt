=== Bluestem Authentication ===
Contributors: jtk, wbm1
Tags: uic, authentication
Requires at least: 3.1
Tested up to: 5.0
Stable tag: 0.6.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Use UIC's Bluestem SSO authentication in WordPress.

== Description ==

Use UIC's Bluestem SSO authentication in WordPress.

== Installation ==

1. Login as an existing user, such as admin.
2. Upload the `bluestem-authentication` folder to your plugins folder, usually `wp-content/plugins`. (Or simply via the built-in installer.)
3. Activate the plugin on the Plugins screen.
4. Configure the plugin specifying your bluestem CGI path.
5. Add one or more users to WordPress, specifying the user's NetID for the "Username" field. Also be sure to set the role for each user.
6. Logout.
7. Enable Bluestem access handler to protect your wordpress instance.
8. Try logging in as one of the users added in step 4.

== Frequently Asked Questions ==

Coming soon.

== Screenshots ==

1. Screenshot 1

2. Screenshot 2

== Changelog ==

= 0.6.1 =
* Moved to wordpress.org plugin hosting.
* Minimum username character length reduced from 4 to 3 to accommodate UIC netids.
* The auto_create_user option is now available to invidual sites on multisite configurations for cases where site owners may want to automatically afford minimal access to all UIC users without needing to add all UIC users to the site.

= 0.6.0 = 
* Initial version distributed on wordpressplugins.uic.edu. 
