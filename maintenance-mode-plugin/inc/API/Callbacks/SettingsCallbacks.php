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
        $newInput = [];
        $old = $this->options['ipWhitelist'];

        if (!is_array($old))
            $old = [];

        $newInput['ipWhitelist'] = $old;

        if ($input['ipWhitelist']) {
            $range = \IPLib\Factory::rangeFromString($input['ipWhitelist']);
            if ($range) {
                $newInput['ipWhitelist'][] = $input['ipWhitelist'];
            } else
                add_settings_error('ipWhitelistSettings', 'ipWhitelistIncorrect', __('Specified ip address is incorrect!', $this->pluginName));
        } else if (!isset($input['delete']))
            add_settings_error('ipWhitelistSettings', 'ipWhitelistErrorEmpty', __('You have to set ip!', $this->pluginName));


        if(isset($input['delete'])) {
            $toDelete = array_keys($input['delete']);

            foreach (array_keys($newInput['ipWhitelist']) as $key)
                if (in_array($key, $toDelete))
                    unset($newInput['ipWhitelist'][$key]);
        }

        return $newInput;
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
            try {
                new \DateTime($input['dateStart']);
                new \DateTime($input['dateEnd']);

                $dateStart = explode(' ', $input['dateStart']);
                $dateStart = array_merge(explode('-', $dateStart[0]), explode(':', $dateStart[1]));
                $timeStart = mktime($dateStart[3], $dateStart[4], 0, $dateStart[1], $dateStart[0], $dateStart[2]);

                $dateEnd = explode(' ', $input['dateEnd']);
                $dateEnd = array_merge(explode('-', $dateEnd[0]), explode(':', $dateEnd[1]));
                $timeEnd = mktime($dateEnd[3], $dateEnd[4], 0, $dateEnd[1], $dateEnd[0], $dateEnd[2]);

                if ($timeEnd > $timeStart) {
                    $newInput['dateStart'][] = $timeStart;
                    $newInput['dateEnd'][] = $timeEnd;
                } else
                    add_settings_error('scheduleSettings', 'scheduleErrorEndLowerStart', __('Date of end cannot be earlier than date od start!', $this->pluginName));
            } catch (\Exception $e) {
                add_settings_error('scheduleSettings', 'scheduleErrorIncorrect', __('Date format is incorrect!', $this->pluginName));
            }
        } else if (!isset($input['delete']))
            add_settings_error('scheduleSettings', 'scheduleErrorEmpty', __('You have to set date start and end!', $this->pluginName));

        if(isset($input['delete'])) {
            $toDelete = array_keys($input['delete']);

            foreach (array_keys($newInput['dateStart']) as $key)  {
                if (in_array($key, $toDelete)) {
                    unset($newInput['dateStart'][$key]);
                    unset($newInput['dateEnd'][$key]);
                }
            }
        }

        return $newInput;
    }

    public function enableField($args)
    {
        $value = $this->getOption($args);

        echo '<div class="enabled-input"><input type="checkbox" style="display: none" class="tgl tgl-flat" id="'.$args['name'].'" ' . 'name="'.$this->getFullName($args).'" '.($value ? 'checked' : '').'>' . '<label class="tgl-btn"' . ' for="' . $args['name'] .'"></label>';

        if (BaseController::$isSchedule)
            echo '<p class="enabled-by-schedule">['.__('Enabled by schedule settings', $this->pluginName).']</p>';

        echo '</div>';

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

    public function ipField($args)
    {
        echo '<input type="text" class="" name="'.$this->getFullName($args).'" placeholder="'.$args['placeholder'].'">';

        $this->addDescription($args);
    }

    public function scheduleField($args)
    {
        //echo '<input type="datetime-local" class="" min="'.date('Y-m-d').'T'.date('H:i').'" name="'.$this->getFullName($args).'">';
        echo '<input type="text" class="'.$args['name'].'" name="'.$this->getFullName($args).'">';
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