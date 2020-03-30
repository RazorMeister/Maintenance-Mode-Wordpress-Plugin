<?php

namespace MaintenanceModePlugin\Inc\Base;

class InitLibs extends BaseController
{
    private $libDirPath = 'lib/';
    private $libsPaths = ['ip-lib/ip-lib.php'];

    /**
     * Run loadLibs methos.
     */
    public function register()
    {
        $this->loadLibs();
    }

    /**
     * Run needed php libraries.
     */
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