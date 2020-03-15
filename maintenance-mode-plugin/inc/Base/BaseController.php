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

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->pluginPath = plugin_dir_path((dirname(__FILE__, 2)));
        $this->pluginUrl = plugin_dir_url((dirname(__FILE__, 2)));
        $this->pluginWPName = plugin_basename((dirname(__FILE__, 3)).'/maintenance-mode-plugin.php');
        $this->pageName = $this->prefix.'index';
    }
}