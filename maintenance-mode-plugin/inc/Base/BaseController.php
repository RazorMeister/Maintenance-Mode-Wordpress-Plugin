<?php

namespace MaintenanceModePlugin\Inc\Base;

class BaseController
{
    protected $pluginPath;
    protected $pluginUrl;
    protected $pluginName;
    protected $prefix = 'MMP_';
    protected $pageName;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->pluginPath = plugin_dir_path((dirname(__FILE__, 2)));
        $this->pluginUrl = plugin_dir_url((dirname(__FILE__, 2)));
        $this->pluginName = plugin_basename((dirname(__FILE__, 3)).'/maintenance-mode-plugin.php');
        $this->pageName = $this->prefix.'index';
    }
}