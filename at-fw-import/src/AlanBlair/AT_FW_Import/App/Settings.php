<?php

namespace AlanBlair\AT_FW_Import\App;

class Settings
{
    private $_config;

    private static $_instance;
    public static function get_instance()
    {
        if(!self::$_instance){ self::$_instance = new self(); }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->_config = AppController::get_instance()->get_config();
        add_action('admin_menu', [$this, 'register_settings_page'], 99);
        add_action('admin_init', [$this, 'register_settings_fields']);
    }

    public function register_settings_page() {
        add_submenu_page(
            'bricks', // Assuming "bricks" is the slug of the parent menu page
            $this->_config['plugin_name'],
            $this->_config['plugin_short_name'],
            'manage_options',
            'atfwi-settings',
            [$this, 'render_settings_page'],
            9999
        );
    }

    function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo $this->_config['plugin_name']; ?> Settings</h1>
            <div class="notice notice-info">
                <p>This plugin parses the entered URLs to variables for Advanced Themer, and classes to Bricks Builder</p>
                <p>To map CSS variables to AT Variable sets, comment the CSS with /* @at-category: Category Name */</p>
                <p>Followed by Variables. Example</p>
                <code><pre>
                        /* @at-category: Spacing */
                        :root{
                            --spacing-var1: 1rem;
                            --spacing-var2: 2rem;
                        }
                    </pre>
                </code>
                <p>If you have a large CSS file and want to stop processing the Variable sets early, add a comment line:</p>
                <p>/* @at-end */</p>
                <i>Only needed for very large CSS files as a performance gain.</i>
            </div>
            <form method="post" action="options.php">
                <?php settings_fields('at-fw-import-settings-group'); ?>
                <?php do_settings_sections('at-fw-import-settings'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    function register_settings_fields() {
        register_setting(
            'at-fw-import-settings-group',
            'atfwi_urls'
        );

        add_settings_section(
            'at-fw-import-settings-section',
            'URL Settings',
            [$this, 'atfwi_render_settings_section'],
            'at-fw-import-settings'
        );
        
        add_settings_field(
            'atfwi-urls',
            'URLs to Parse',
            [$this, 'atfwi_urls_field'],
            'at-fw-import-settings',
            'at-fw-import-settings-section'
        );
    }

    function atfwi_render_settings_section() {
        echo '<p>Enter your URLs to parse below:</p><p>One URL per line</p>';
    }
    

    function atfwi_urls_field() {
        $value = get_option('atfwi_urls', '');
        echo "<textarea class='widefat' name='atfwi_urls' rows='10'  type='textarea'>{$value}</textarea>";
    }

}