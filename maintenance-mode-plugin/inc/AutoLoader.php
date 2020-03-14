<?php

namespace MaintenanceModePlugin\Inc;

class AutoLoader
{
    private $path;

    /**
     * AutoLoader constructor.
     */
    public function __construct()
    {
        $this->path = dirname(__FILE__, 2);
        spl_autoload_register([$this, 'autoLoad']);
    }

    /**
     * AutoLoad classes.
     *
     * @param $className
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function autoLoad($className)
    {
        if (strpos($className, 'MaintenanceModePlugin') !== false) {
            $className = str_replace('MaintenanceModePlugin\\', '', $className);
            $className = str_replace('Inc', 'inc', $className);
            $file = $this->path.DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";

            try {
                if (!file_exists($file))
                    throw new \Exception('Class '.$className.' does not exist');
                else {
                    require_once($file);
                    return true;
                }
            } catch(Exception $e) {
                die($e->getMessage());
            }
        }
    }
}