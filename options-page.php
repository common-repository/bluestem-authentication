<?php
class BluestemAuthenticationOptionsPage {
	var $plugin;
	var $group;
	var $page;
	var $options;
	var $title;

	function __construct($plugin, $group, $page, $options, $title = 'Bluestem Authentication') {
		$this->plugin = $plugin;
		$this->group = $group;
		$this->page = $page;
		$this->options = $options;
		$this->title = $title;

		add_action('admin_init', array($this, 'register_options'));
		add_action('admin_menu', array($this, 'add_options_page'));
	}

	/*
	 * Register the options for this plugin so they can be displayed and updated below.
	 */
	function register_options() {
		register_setting($this->group, $this->group, array($this, 'sanitize_settings'));

		$section = 'bluestem_authentication_main';
		add_settings_section($section, 'Main Options', array($this, '_display_options_section'), $this->page);
		if (!is_multisite() ) {
		add_settings_field('bluestem_authentication_allow_wp_auth', 'Allow WordPress authentication?', array($this, '_display_option_allow_wp_auth'), $this->page, $section, array('label_for' => 'bluestem_authentication_allow_wp_auth'));
		add_settings_field('bluestem_authentication_auth_label', 'Authentication label', array($this, '_display_option_auth_label'), $this->page, $section, array('label_for' => 'bluestem_authentication_auth_label'));
		add_settings_field('bluestem_authentication_bluestem_path', 'Bluestem Path', array($this, '_display_option_bluestem_path'), $this->page, $section, array('label_for' => 'bluestem_authentication_bluestem_path'));
		add_settings_field('bluestem_authentication_auto_create_email_domain', 'Email address domain', array($this, '_display_option_auto_create_email_domain'), $this->page, $section, array('label_for' => 'bluestem_authentication_auto_create_email_domain'));
		}
		add_settings_field('bluestem_authentication_auto_create_user', 'Automatically create accounts?', array($this, '_display_option_auto_create_user'), $this->page, $section, array('label_for' => 'bluestem_authentication_auto_create_user'));	
}

	/*
	 * Set the database version on saving the options.
	 */
	function sanitize_settings($input) {
		$output = $input;
		$output['db_version'] = $this->plugin->db_version;
		$output['allow_wp_auth'] = isset($input['allow_wp_auth']) ? (bool) $input['allow_wp_auth'] : false;
		$output['auto_create_user'] = isset($input['auto_create_user']) ? (bool) $input['auto_create_user'] : false;

		return $output;
	}

	/*
	 * Add an options page for this plugin.
	 */
	function add_options_page() {
		add_options_page($this->title, $this->title, 'manage_options', $this->page, array($this, '_display_options_page'));
	}

	/*
	 * Display the options for this plugin.
	 */
	function _display_options_page() {
		if (! current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
?>
<div class="wrap">
  <h2>Bluestem Authentication Options</h2>
  <form action="options.php" method="post">
    <?php settings_errors(); ?>
    <?php settings_fields($this->group); ?>
    <?php do_settings_sections($this->page); ?>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button-primary" />
    </p>
  </form>
</div>
<?php
	}

	/*
	 * Display explanatory text for the main options section.
	 */
	function _display_options_section() {
	}

	/*
	 * Display the WordPress authentication checkbox.
	 */
	function _display_option_allow_wp_auth() {
		$allow_wp_auth = $this->options['allow_wp_auth'];
		$this->_display_checkbox_field('allow_wp_auth', $allow_wp_auth);
?>
Should the plugin fallback to WordPress authentication if none is found from the server?
<?php
	}

	/*
	 * Display the authentication label field, describing the authentication system
	 * in use.
	 */
	function _display_option_auth_label() {
		$auth_label = $this->options['auth_label'];
		$this->_display_input_text_field('auth_label', $auth_label);
?>
Default is <code>UIC Common Password</code>; override to use the name of your single sign-on system.
<?php
	}

	/*
	 * Display the login URI field.
	 */
	function _display_option_bluestem_path() {
		$bluestem_path = $this->options['bluestem_path'];
		$this->_display_input_text_field('bluestem_path', $bluestem_path);
	}

	/*
	 * Display the automatically create accounts checkbox.
	 */
	function _display_option_auto_create_user() {
		$auto_create_user = $this->options['auto_create_user'];
		$this->_display_checkbox_field('auto_create_user', $auto_create_user);
?>
Should a new user be created automatically if not already in the WordPress database?<br />
Created users will obtain the role defined under &quot;New User Default Role&quot; on the <a href="options-general.php">General Options</a> page.
<?php
	}

	/*
	 * Display the email domain field.
	 */
	function _display_option_auto_create_email_domain() {
		$auto_create_email_domain = $this->options['auto_create_email_domain'];
		$this->_display_input_text_field('auto_create_email_domain', $auto_create_email_domain);
?>
When a new user logs in, this domain is used for the initial email address on their account. The user can change his or her email address by editing their profile.
<?php
	}

	/*
	 * Display a text input field.
	 */
	function _display_input_text_field($name, $value, $size = 75) {
?>
<input type="text" name="<?php echo htmlspecialchars($this->group); ?>[<?php echo htmlspecialchars($name); ?>]" id="bluestem_authentication_<?php echo htmlspecialchars($name); ?>" value="<?php echo htmlspecialchars($value) ?>" size="<?php echo htmlspecialchars($size); ?>" /><br />
<?php
	}

	/*
	 * Display a checkbox field.
	 */
	function _display_checkbox_field($name, $value) {
?>
<input type="checkbox" name="<?php echo htmlspecialchars($this->group); ?>[<?php echo htmlspecialchars($name); ?>]" id="bluestem_authentication_<?php echo htmlspecialchars($name); ?>"<?php if ($value) echo ' checked="checked"' ?> value="1" /><br />
<?php
	}
}
?>
