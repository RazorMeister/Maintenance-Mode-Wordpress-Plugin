<?php

namespace MaintenanceModePlugin\Inc\API\Callbacks;

class SettingsCallbacks
{
    public function generalSettings($input)
    {
        return $input;
    }

    public function generalSection()
    {
        echo 'Główna sekcja naszej wtyczki';
    }

    public function checkboxField($args)
    {
        $value = esc_attr(get_option($args['label_for']));

        echo '<input type="checkbox" class="" name="'.$args['label_for'].'" '.($value ? 'checked' : '').'>';
    }

    public function textField($args)
    {
        $value = esc_attr(get_option($args['label_for']));

        echo '<input type="text" class="" name="'.$args['label_for'].'" value="'.$value.'" placeholder="Wpisz adresy ip oddzielone przecinkami">';
    }
}