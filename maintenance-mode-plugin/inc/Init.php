<?php

namespace MaintenanceModePlugin\Inc;

use MaintenanceModePlugin\Inc\Base\BaseController;

class Init
{
    /**
     * Store all classes inside an array.
     *
     * @return array Full list of classes
     */
    public static function getServices()
    {
        return [
            Base\Language::class,
            Base\SettingsLink::class,
            Base\Enqueue::class,
            Base\AdminBar::class,
            Base\CheckSchedule::class,
            Base\InitLibs::class,

            Pages\Admin::class,
            Pages\Maintenance::class,
        ];
    }

    /**
     * Register classes from gerServices() and call the register method if it exists;=.
     */
    public static function registerServices()
    {
        foreach (self::getServices() as $class) {
            $service = self::create($class);
            if (method_exists($service, 'register'))
                $service->register();
        }
    }

    /**
     * Create the class instance.
     *
     * @param $class
     *
     * @return class instance
     */
    public static function create($class)
    {
        return new $class();
    }
}