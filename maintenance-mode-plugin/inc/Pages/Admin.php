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
        add_options_page('Włącz \ Wyłącz', 'Maintenance Mode Plugin', 'manage_options', $this->pageName, [$this, 'showAdminPage']);
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
                'id' => $this->prefix . 'schedule',
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
                'title' => 'Włączony tryb maintence',
                'callback' => [$this->settingsCallbacks, 'checkboxField'],
                'page' => $this->prefix . 'general',
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'name' => 'enabled',
                    'settings' => $this->prefix.'general'
                ]
            ],
            [
                'id' => 'title',
                'title' => 'Tytuł strony',
                'callback' => [$this->settingsCallbacks, 'textField'],
                'page' =>$this->prefix . 'general',
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'name' => 'title',
                    'placeholder' => 'Moja strona',
                    'settings' => $this->prefix.'general'
                ]
            ],
            [
                'id' => 'description',
                'title' => 'Opis strony',
                'callback' => [$this->settingsCallbacks, 'textarea'],
                'page' => $this->prefix . 'general',
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'name' => 'description',
                    'placeholder' => 'Lore ipsum dolore sit amet itp.',
                    'settings' => $this->prefix.'general'
                ]
            ],

            // Ip management Settings
            [
                'id' => 'ipWhitelist',
                'title' => 'Wykluczone adresy IP (po przecinku)',
                'callback' => [$this->settingsCallbacks, 'textField'],
                'page' => $this->prefix . 'ipManagement',
                'section' => $this->prefix . 'ipManagementSection',
                'args' => [
                    'name' => 'ipWhitelist',
                    'placeholder' => 'Wpisz adresy ip po przecinku :)',
                    'settings' => $this->prefix.'ipManagement'
                ]
            ],
        ];

        $this->settings->setFields($args);
    }
}