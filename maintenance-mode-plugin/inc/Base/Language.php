<?php

namespace MaintenanceModePlugin\Inc\Base;

class Language extends BaseController
{
    public function register()
    {
        add_action('plugins_loaded', [$this, 'loadTextDomain']);
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain($this->pluginName, false, basename($this->pluginPath).'/languages/');
    }
}