<?php

namespace MaintenanceModePlugin\Inc\Base;

class Language extends BaseController
{
    /**
     * Add action to plugins_loaded hook.
     */
    public function register()
    {
        add_action('plugins_loaded', [$this, 'loadTextDomain']);
    }

    /**
     * Load language translation for textdomain.
     */
    public function loadTextDomain()
    {
        load_plugin_textdomain($this->pluginName, false, basename($this->pluginPath).'/languages/');
    }
}