<?php

namespace MaintenanceModePlugin\Inc\Base;

class SettingsLink extends BaseController
{
    /**
     * Add filter to wp to register additional link.
     */
    public function register()
    {
        add_filter('plugin_action_links_'.$this->pluginName, [$this, 'setLinks']);
    }

    /**
     * Callback function to add settings link.
     *
     * @param $links
     *
     * @return array
     */
    public function setLinks($links)
    {
        $links[] = '<a href="options-general.php?page='.$this->pageName.'">Settings</a>';

        return $links;
    }
}