<?php

namespace MaintenanceModePlugin\Inc\Base;

class CheckSchedule extends BaseController
{
    /**
     * Run check method.
     */
    public function register()
    {
        $this->check();
    }

    /**
     * Check if maintenance page should be shown due to schedule.
     */
    public function check()
    {
        if (is_array($this->options['dateStart'])) {
            foreach (array_keys($this->options['dateStart']) as $key) {
                if ($this->options['dateEnd'][$key] < current_time('U')) {
                    unset($this->options['dateStart'][$key]);
                    unset($this->options['dateEnd'][$key]);
                    $options = get_option($this->prefix.'schedule');
                    $options['dateStart'] = $this->options['dateStart'];
                    $options['dateEnd'] = $this->options['dateEnd'];
                    update_option($this->prefix.'schedule', $options);
                    $this->changeMaintenanceModeStatus(false);
                } else if ($this->options['dateStart'][$key] < current_time('U') && $this->options['dateEnd'][$key] > current_time('U')) {
                    $this->changeMaintenanceModeStatus();
                    BaseController::$scheduleEnd = $this->options['dateEnd'][$key];
                }
            }
        }
    }

    /**
     * Change maintenance mode plugin status to enabled \ disabled.
     *
     * @param bool $turnOn
     */
    private function changeMaintenanceModeStatus($turnOn = true)
    {
        $options = get_option($this->prefix.'general');
        if ($turnOn) {
            BaseController::$isSchedule = true;
            if (!$options['enabled'])
                $options['enabled'] = 'on';
        } else
            unset($options['enabled']);

        update_option($this->prefix.'general', $options);
    }
}