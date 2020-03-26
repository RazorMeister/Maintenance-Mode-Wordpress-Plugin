<?php

namespace MaintenanceModePlugin\Inc\Pages;

use MaintenanceModePlugin\Inc\API\Callbacks\SettingsCallbacks;
use MaintenanceModePlugin\Inc\API\SettingsApi;
use MaintenanceModePlugin\Inc\Base\BaseController;

class Admin extends BaseController
{
    private $settings;
    private $settingsCallbacks;

    public function register()
    {
        if (!$this->isAdmin)
            return;

        $this->settings = new SettingsApi();
        $this->settingsCallbacks = new SettingsCallbacks();

        add_action('admin_menu', [$this, 'addAdminPage']);

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->register();
    }

    public function addAdminPage()
    {
        add_options_page(__('Maintenance mode plugin settings', $this->pluginName), 'Maintenance Mode Plugin', 'manage_options', $this->pageName, [$this, 'showAdminPage']);
    }

    public function showAdminPage()
    {
        require_once $this->pluginPath.'/templates/admin.php';
    }

    public function setSettings()
    {
        $args = [];

        foreach ($this->pluginSettingsNames as $setting)
            $args[] = [
                'optionGroup' => $this->prefix . $setting,
                'optionName' => $this->prefix . $setting,
                'callback' => [$this->settingsCallbacks, $setting . 'Settings']
            ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => $this->prefix . 'generalSection',
                'title' => 'General settings',
                'page' => $this->prefix . 'general'
            ],
            [
                'id' => $this->prefix . 'ipManagementSection',
                'title' => 'Ip management',
                'page' => $this->prefix . 'ipManagement'
            ],
            [
                'id' => $this->prefix . 'scheduleSection',
                'title' => 'Schedule',
                'page' => $this->prefix . 'schedule'
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [
            // General settings
            [
                'id' => 'enabled',
                'title' => __('Maintenance mode enabled', $this->pluginName),
                'callback' => [$this->settingsCallbacks, 'enableField'],
                'page' => $this->prefix . 'general',
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'name' => 'enabled',
                    'settings' => $this->prefix.'general',
                    'description' => __('Opisik', $this->pluginName)
                ]
            ],
            [
                'id' => 'theme',
                'title' => __('Select theme', $this->pluginName),
                'callback' => [$this->settingsCallbacks, 'selectTheme'],
                'page' => $this->prefix . 'general',
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'name' => 'theme',
                    'settings' => $this->prefix.'general',
                    'description' => __('Opisik', $this->pluginName)
                ]
            ],
            [
                'id' => 'title',
                'title' => __('Site title', $this->pluginName),
                'callback' => [$this->settingsCallbacks, 'textField'],
                'page' =>$this->prefix . 'general',
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'name' => 'title',
                    'placeholder' => 'My very good website', $this->pluginName,
                    'settings' => $this->prefix.'general',
                    'description' => __('Opisik', $this->pluginName)
                ]
            ],
            [
                'id' => 'description',
                'title' => __('Site description', $this->pluginName),
                'callback' => [$this->settingsCallbacks, 'wpEditor'],
                'page' => $this->prefix . 'general',
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'name' => 'description',
                    'placeholder' => 'This is my website description',
                    'settings' => $this->prefix.'general',
                    'description' => __('Opisik', $this->pluginName)
                ]
            ],

            // Ip management Settings
            [
                'id' => 'ipWhitelist',
                'title' => __('Excluded Ip address', $this->pluginName),
                'callback' => [$this->settingsCallbacks, 'ipField'],
                'page' => $this->prefix . 'ipManagement',
                'section' => $this->prefix . 'ipManagementSection',
                'args' => [
                    'name' => 'ipWhitelist',
                    'placeholder' => '127.0.0.0 | 127.0.0.* | 10.0.0.0/8',
                    'settings' => $this->prefix.'ipManagement',
                    'description' => __('Opisik', $this->pluginName)
                ]
            ],

            // Schedule Settings
            [
                'id' => 'dateStart',
                'title' => __('Date of starting maintenance mode', $this->pluginName),
                'callback' => [$this->settingsCallbacks, 'scheduleField'],
                'page' => $this->prefix . 'schedule',
                'section' => $this->prefix . 'scheduleSection',
                'args' => [
                    'name' => 'dateStart',
                    'settings' => $this->prefix.'schedule',
                    'description' => __('Opisik', $this->pluginName)
                ]
            ],
            [
                'id' => 'dateEnd',
                'title' => __('Date of ending maintenance mode', $this->pluginName),
                'callback' => [$this->settingsCallbacks, 'scheduleField'],
                'page' => $this->prefix . 'schedule',
                'section' => $this->prefix . 'scheduleSection',
                'args' => [
                    'name' => 'dateEnd',
                    'settings' => $this->prefix.'schedule',
                    'description' => __('Opisik', $this->pluginName)
                ]
            ],
        ];

        $this->settings->setFields($args);
    }
}