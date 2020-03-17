<?php

namespace MaintenanceModePlugin\Inc\API\Callbacks;

class SettingsCallbacks
{
    public function generalSettings($input)
    {
        return $input;
    }

    public function ipManagementSettings($input)
    {
        return $input;
    }

    public function scheduleSettings($input)
    {
        return $input;
    }

    public function checkboxField($args)
    {
        $value = $this->getOption($args);

        echo '<input type="checkbox" style="display: none" class="tgl tgl-flat" id="'.$args['name'].'" ' . 'name="'.$this->getFullName($args).'" '.($value ? 'checked' : '').'>' . '<label class="tgl-btn"' . ' for="' . $args['name'] .'"></label>';
    }

    public function textField($args)
    {
        $value = $this->getOption($args);

        echo '<input type="text" class="" name="'.$this->getFullName($args).'" value="'.$value.'" placeholder="'.$args['placeholder'].'">';
    }

    public function textarea($args)
    {
        $value = $this->getOption($args);

        echo '<textarea class="" name="'.$this->getFullName($args).'" placeholder="'.$args['placeholder'].'">'.$value.'</textarea>';
    }

    public function wpEditor($args)
    {
        $value = $this->getOption($args);
        $editorId = $args['name'];
        wp_editor($value, $editorId, ['textarea_name' => $this->getFullName($args)]);
    }

    private function getFullName($args)
    {
        return $args['settings'].'['.$args['name'].']';
    }

    private function getOption($args)
    {
        $value = get_option($args['settings']);
        $value = (isset($value[$args['name']]) ? $value[$args['name']] : '');
        return esc_attr($value);
    }
}