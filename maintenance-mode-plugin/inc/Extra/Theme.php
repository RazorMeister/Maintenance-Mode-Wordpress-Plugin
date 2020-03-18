<?php

namespace MaintenanceModePlugin\Inc\Extra;

use MaintenanceModePlugin\Inc\Base\BaseController;

class Theme extends BaseController
{
    private $themeName;
    private $themePath;
    private $themeUrl;

    public function __construct($themeName)
    {
        parent::__construct();

        $this->themeName = $themeName;
        if (!file_exists($this->pluginPath.'templates/themes/'.$this->themeName.'/index.php'))
            $this->themeName = 'default';

        $this->themePath = $this->pluginPath.'templates/themes/'.$this->themeName;
        $this->themeUrl = $this->pluginUrl.'/templates/themes/'.$this->themeName.'/';
    }

    public function render()
    {
        require_once $this->themePath.'/index.php';
    }
}