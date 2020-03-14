<?php

namespace MaintenanceModePlugin\Inc\Base;

class Enqueue extends BaseController
{
    /**
     * Add action to enqueue scripts and styles.
     */
    public function register()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
    }

    /**
     * Enqueue styles and scripts for admin.
     */
    public function enqueueAdmin()
    {
        wp_enqueue_style('MaintenanceModePluginAdminStyles', $this->pluginUrl.'assets/css/admin-styles.css');
        wp_enqueue_script('MaintenanceModePluginAdminScripts', $this->pluginUrl.'assets/js/admin-scripts.js');
    }
}