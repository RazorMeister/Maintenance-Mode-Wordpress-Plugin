<?php

namespace MaintenanceModePlugin\Inc\API;

use MaintenanceModePlugin\Inc\Base\BaseController;

class SettingsApi extends BaseController
{
    private $settings = [];
    private $sections = [];
    private $fields = [];

    /**
     * Add action to admin_init hook.
     */
    public function register()
    {
        if (!empty($this->settings))
            add_action('admin_init', [$this, 'registerCustomFields']);
    }

    /**
     * Settings setter.
     *
     * @param array $settings
     *
     * @return $this
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Settings sections setter.
     *
     * @param array $sections
     *
     * @return $this
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * Settings fields setter.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Register all settings, settings sections and settings fields to wp.
     */
    public function registerCustomFields()
    {
        // Register settings
        foreach ($this->settings as $setting)
            register_setting($setting['optionGroup'], $setting['optionName'], (isset($setting['callback']) ? $setting['callback'] : ''));

        // Register sections
        foreach ($this->sections as $section)
            add_settings_section($section['id'], $section['title'], (isset($section['callback']) ? $section['callback'] : ''), $section['page']);

        // Register fields
        foreach ($this->fields as $field) {
            if (isset($field['args']['placeholder']))
                $field['args']['placeholder'] = __($field['args']['placeholder'], $this->pluginName);
            add_settings_field($field['id'], __($field['title'], $this->pluginName),  (isset($field['callback']) ? $field['callback'] : ''), $field['page'], $field['section'], (isset($field['args']) ? $field['args'] : ''));
        }
    }
}