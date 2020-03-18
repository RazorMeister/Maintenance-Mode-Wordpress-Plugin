<?php

namespace MaintenanceModePlugin\Inc\Base;

class BaseController
{
    protected $pluginPath;
    protected $pluginUrl;
    protected $pluginWPName;
    protected $prefix = 'MMP_';
    protected $pageName;
    protected $pluginName = 'maintenance-mode-plugin';
    protected $isAdmin;
    protected $pluginSettingsNames = ['general', 'ipManagement', 'schedule'];
    protected $options;
    protected $userIp;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->pluginPath = plugin_dir_path((dirname(__FILE__, 2)));
        $this->pluginUrl = plugin_dir_url((dirname(__FILE__, 2)));
        $this->pluginWPName = plugin_basename((dirname(__FILE__, 3)).'/maintenance-mode-plugin.php');
        $this->pageName = $this->prefix.'index';
        $this->isAdmin = is_admin();
        $this->options = $this->getOptions();
        $this->userIp = $this->getUserIp();
    }

    /**
     * Get plugin options by settings names.
     *
     * @return array
     */
    private function getOptions()
    {
        $options = [];

        foreach ($this->pluginSettingsNames as $setting) {
            $settingOptions = get_option($this->prefix.$setting);
            if (!is_array($settingOptions))
                $settingOptions = [];
            $options = array_merge($options, $settingOptions);
        }

        return $options;
    }

    /**
     * Get user ip.
     *
     * @return mixed
     */
    private function getUserIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return apply_filters('wpb_get_ip', $ip);
    }
}