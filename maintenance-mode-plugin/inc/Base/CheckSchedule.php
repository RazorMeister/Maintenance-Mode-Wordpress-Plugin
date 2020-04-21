<?php

namespace MaintenanceModePlugin\Inc\Base;

class CheckSchedule extends BaseController
{
    private $showBeforeSchedule;

    /**
     * Run check method.
     */
    public function register()
    {
        $this->check();
        add_action('wp_footer', [$this, 'addInfoBeforeMaintenance']);
    }

    /**
     * Check if maintenance page should be shown due to schedule.
     */
    public function check()
    {
        $minTimeBefore = null;

        if (is_array($this->options['dateStart'])) {
            foreach (array_keys($this->options['dateStart']) as $key) {
                if ($this->options['dateEnd'][$key] < current_time('U')) { // was schedule and ended
                    unset($this->options['dateStart'][$key]);
                    unset($this->options['dateEnd'][$key]);
                    $options = get_option($this->prefix.'schedule');
                    $options['dateStart'] = $this->options['dateStart'];
                    $options['dateEnd'] = $this->options['dateEnd'];
                    update_option($this->prefix.'schedule', $options);
                    $this->changeMaintenanceModeStatus(false);
                } else if ($this->options['dateStart'][$key] < current_time('U') && $this->options['dateEnd'][$key] > current_time('U')) { // Currently in progress schedule
                    $this->changeMaintenanceModeStatus();
                    BaseController::$scheduleEnd = $this->options['dateEnd'][$key];
                    break;
                } else if ($this->options['informBefore'] && current_time('U') < $this->options['dateStart'][$key] && $this->options['dateStart'][$key] - current_time('U') < $this->options['informBeforeTime'] * 60) {
                    if ($minTimeBefore == null || $this->options['dateStart'][$key] - current_time('U') < $minTimeBefore)
                        $minTimeBefore = $this->options['dateStart'][$key] - current_time('U');
                }
            }
        }

        if ($minTimeBefore != null) {
            $this->showBeforeSchedule = $minTimeBefore;
        } else
            $this->showBeforeSchedule = null;
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

    /**
     * Add information script to website.
     */
    public function addInfoBeforeMaintenance()
    {
        if ($this->showBeforeSchedule != null && !is_admin() && !is_feed() && !is_robots() && !is_trackback()) {
            echo '
            <style>.swal2-container { z-index: 9999999; } </style>
            <script src='.$this->pluginUrl.'/assets/js/sweet-alert.js></script>
            <script>    
                window.onload = function() {
                    const Toast = Swal.mixin({
                      toast: true,
                      position: "bottom-end",
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true,
                      onOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                      }
                    });
                    
                    Toast.fire({
                      icon: "info",
                      title: "'.__('Maintenance mode is starting in: ', $this->pluginName).human_readable_duration( date('i:s', $this->showBeforeSchedule) ).'"
                    });
                }
            </script>
            ';
        }
    }
}