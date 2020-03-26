<?php

namespace MaintenanceModePlugin\Inc\Base;

class InitLibs extends BaseController
{
    private $libDirPath = 'lib/';
    private $libsPaths = ['ip-lib/ip-lib.php'];

    public function register()
    {
        $this->loadLibs();
    }

    public function loadLibs()
    {
        foreach ($this->libsPaths as $path) {
            try {
                require_once $this->pluginPath.$this->libDirPath.$path;
            } catch (\Exception $e) {

            }
        }
    }
}