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
        $args = [
            // General settings
            [
                'optionGroup' => $this->prefix . 'general',
                'optionName' => $this->prefix . 'enabled',
                'callback' => [$this->settingsCallbacks, 'generalSettings']
            ],
            [
                'optionGroup' => $this->prefix . 'general',
                'optionName' => $this->prefix . 'ipWhitelist',
                'callback' => [$this->settingsCallbacks, 'generalSettings']
            ],

        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => $this->prefix . 'generalSection',
                'title' => 'General settings',
                'callback' => [$this->settingsCallbacks, 'generalSection'],
                'page' => $this->pageName
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [
            // General settings
            [
                'id' => $this->prefix . 'enabled',
                'title' => 'Włączony tryb maintence',
                'callback' => [$this->settingsCallbacks, 'checkboxField'],
                'page' => $this->pageName,
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'label_for' => $this->prefix . 'enabled'
                ]
            ],
            [
                'id' => $this->prefix . 'ipWhitelist',
                'title' => 'Wykluczone adresy IP (po przecinku)',
                'callback' => [$this->settingsCallbacks, 'textField'],
                'page' => $this->pageName,
                'section' => $this->prefix . 'generalSection',
                'args' => [
                    'label_for' => $this->prefix . 'ipWhitelist',
                    'placeholder' => 'Wpisz adresy ip po przecinku :)'
                ]
            ],
        ];

        $this->settings->setFields($args);
    }
}