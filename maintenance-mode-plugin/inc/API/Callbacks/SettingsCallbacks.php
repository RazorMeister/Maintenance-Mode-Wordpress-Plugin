<?php

namespace MaintenanceModePlugin\Inc\API\Callbacks;

use MaintenanceModePlugin\Inc\Base\BaseController;

class SettingsCallbacks extends BaseController
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
        $newInput = [];
        $oldStarts = $this->options['dateStart'];
        $oldEnds = $this->options['dateEnd'];

        if (!is_array($oldStarts))
            $oldStarts = [];
        if (!is_array($oldEnds))
            $oldEnds = [];

        $newInput['dateStart'] = $oldStarts;
        $newInput['dateEnd'] = $oldEnds;

        if ($input['dateStart'] && $input['dateEnd']) {
            $dateStart = explode('T', $input['dateStart']);
            $dateStart = array_merge(explode('-', $dateStart[0]), explode(':', $dateStart[1]));
            $timeStart = mktime($dateStart[3], $dateStart[4], 0, $dateStart[1], $dateStart[2], $dateStart[0]);

            $dateEnd = explode('T', $input['dateEnd']);
            $dateEnd = array_merge(explode('-', $dateEnd[0]), explode(':', $dateEnd[1]));
            $timeEnd = mktime($dateEnd[3], $dateEnd[4], 0, $dateEnd[1], $dateEnd[2], $dateEnd[0]);

            if ($timeEnd > $timeStart) {
                $newInput['dateStart'][] = $input['dateStart'];
                $newInput['dateEnd'][] = $input['dateEnd'];
            } else
                add_settings_error('scheduleSettings', 'scheduleErrorEndLowerStart', 'Data zakończenia nie może być wcześniej niż data rozpoczęcia!');
        } else
            add_settings_error('scheduleSettings', 'scheduleErrorEmpty', 'Musisz podać datę początku i końca!');

        return $newInput;
    }

    public function checkboxField($args)
    {
        $value = $this->getOption($args);

        echo '<input type="checkbox" style="display: none" class="tgl tgl-flat" id="'.$args['name'].'" ' . 'name="'.$this->getFullName($args).'" '.($value ? 'checked' : '').'>' . '<label class="tgl-btn"' . ' for="' . $args['name'] .'"></label>';

        $this->addDescription($args);
    }

    public function textField($args)
    {
        $value = $this->getOption($args);

        echo '<input type="text" class="" name="'.$this->getFullName($args).'" value="'.$value.'" placeholder="'.$args['placeholder'].'">';

        $this->addDescription($args);
    }

    public function textarea($args)
    {
        $value = $this->getOption($args);

        echo '<textarea class="" name="'.$this->getFullName($args).'" placeholder="'.$args['placeholder'].'">'.$value.'</textarea>';

        $this->addDescription($args);
    }

    public function wpEditor($args)
    {
        $this->addDescription($args);

        $value = $this->getOption($args, false);
        $editorId = $args['name'];
        wp_editor($value, $editorId, ['textarea_name' => $this->getFullName($args)]);
    }

    public function selectTheme($args)
    {
        $value = $this->getOption($args);

        $this->addDescription($args);

        echo '<div class="choose-theme">';

        foreach ($this->getThemes() as $themeName => $themeInfo) {
            echo '<div id="theme-'.$themeName.'" class="single-theme '.($value == $themeName ? 'active' : '').'" data-toggle="select-theme">
                        <input type="checkbox" name="'.$this->getFullName($args).'" value="'.$themeName.'" '.($value == $themeName ? 'checked' : '').'>
                        <img class="theme-img" src="'.$this->pluginUrl.$themeInfo['img'].'" alt="'.$themeInfo['name'].'">
                        <div class="theme-content">
                            <h3>'.$themeInfo['name'].'</h3>
                            <p>'.$themeInfo['description'].'</p>
                        </div>
                   </div>';
        }

        echo '</div>';
    }

    public function scheduleField($args)
    {
        echo '<input type="datetime-local" class="" min="'.date('Y-m-d').'T'.date('H:i').'" name="'.$this->getFullName($args).'">';
    }

    private function getFullName($args)
    {
        return $args['settings'].'['.$args['name'].']';
    }

    private function getOption($args, $escAttr = true)
    {
        $value = get_option($args['settings']);
        $value = (isset($value[$args['name']]) ? $value[$args['name']] : '');
        return $escAttr ? esc_attr($value) : $value;
    }

    private function getThemes()
    {
        $dir = [];
        $files = scandir($this->pluginPath.'templates/themes/');

        foreach ($files as $file)
            if (is_dir($this->pluginPath.'templates/themes/'.$file)
                && file_exists($this->pluginPath.'templates/themes/'.$file.'/index.php')
                && file_exists($this->pluginPath.'templates/themes/'.$file.'/info.php'))
                $dir[$file] = require_once $this->pluginPath.'templates/themes/'.$file.'/info.php';

        return $dir;
    }

    private function addDescription($args)
    {
        if (isset($args['description']))
            echo '<p class="input-description">'.__($args['description'], $this->pluginName).'</p>';
    }

}