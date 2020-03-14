<?php

namespace MaintenanceModePlugin\Inc\Base;

class AdminBar extends BaseController
{
    /**
     * Register action to set admin bar;
     */
    public function register()
    {
        add_action('wp_before_admin_bar_render', [$this, 'setAdminBar']);
    }

    /**
     * Add new menu for admin bar.
     */
    public function setAdminBar()
    {
        global $wp_admin_bar;

        $isEnabled = (get_option($this->prefix.'enabled') ? 'ON' : 'OFF');

        $wp_admin_bar->add_menu([
            'parent' => '',
            'id'     => $this->prefix.'bar',
            'title'  => 'Maintenance Mode: '.$isEnabled,
            'href'   => admin_url('options-general.php?page='.$this->pageName)
        ]);
    }
}