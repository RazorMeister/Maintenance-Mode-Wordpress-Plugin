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

        $isEnabled = $this->options['enabled'];

        if ($isEnabled)
        {
            //$action = '<input type="checkbox" style="display: none" class="tgl tgl-flat" id="MMP_enabled" name="MMP_enabled" checked><label class="tgl-btn" for="MMP_enabled"></label>';
            $isEnabledLabel = '<span style="color:green">⬤</span>';
        }
        else
        {
            //$action = '<input type="checkbox" style="display: none" class="tgl tgl-flat" id="MMP_enabled" name="MMP_enabled"><label class="tgl-btn" for="MMP_enabled"></label>';
            $isEnabledLabel = '<span style="color:red">⭕</span>';
        }

        $wp_admin_bar->add_menu([
            'parent' => '',
            'id'     => $this->prefix.'bar',
            'title'  => 'Maintenance Mode '.$isEnabledLabel,
            'href'   => admin_url('options-general.php?page='.$this->pageName)
        ]);
       /* $wp_admin_bar->add_node( array(
            'parent' => $this->prefix.'bar',
            'id'    => $this->prefix.'state',
            'title' => $action,
            'href'  => false,
        ));*/
        $wp_admin_bar->add_node( array(
            'parent' => $this->prefix.'bar',
            'id'     => $this->prefix.'preview',
            'title'  => __('Preview', $this->pluginName),
            'href'   => site_url('index.php?maintenanceModePreview=true'),
            'meta'   => ['target' => '_blank']
        ));
        $wp_admin_bar->add_node( array(
            'parent' => $this->prefix.'bar',
            'id'     => $this->prefix.'settings',
            'title'  => __('Settings', $this->pluginName),
            'href'   => admin_url('options-general.php?page='.$this->pageName)
        ));
    }
}