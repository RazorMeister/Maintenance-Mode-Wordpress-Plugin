<?php

namespace MaintenanceModePlugin\Inc\Pages;

use MaintenanceModePlugin\Inc\Base\BaseController;
use MaintenanceModePlugin\Inc\Extra\Theme;

class Maintenance extends BaseController
{
    private $siteUrl;
    private $loginUrl;
    private $allowed = [
        '/wp-login.php',
        '/wp-admin/',
        '/async-upload.php',
        '/upgrade.php',
        '/plugins/',
        '/xmlrpc.php'
    ];

    /**
     * Maintenance constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $protocol = (isset($_SERVER['HTTPS']) ? 'https' : 'http');
        $this->siteUrl = $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->loginUrl = wp_login_url();
    }

    /**
     * Register method to init wp action.
     */
    public function register()
    {
        add_action('init', [$this, 'initMaintenanceModePlugin']);
    }

    /**
     * Check if maintenance mode page should be shown.
     */
    public function initMaintenanceModePlugin()
    {
        $isEnabled = $this->options['enabled'];

        if (!$this->isPreview()) {
            if (!$isEnabled)
                return;

            if ((defined('DOING_CRON') && DOING_CRON)
                || (defined('DOING_AJAX') && DOING_AJAX)
                || (defined('WP_CLI') && WP_CLI)
                || $this->isAdmin
                || is_user_logged_in()
                || $this->isAllowedUrl()
                || $this->isAllowedIp())
                return;
        }

        $this->showMaintenancePage();
        exit();
    }

    /**
     * Check if requested url is allowed.
     *
     * @return bool
     */
    private function isAllowedUrl()
    {
        foreach ($this->allowed as $allow)
            if (strpos($this->siteUrl, $allow) !== false)
                return true;

        return false;
    }

    /**
     * Check if user ip is allowed to see website.
     *
     * @return bool
     */
    private function isAllowedIp()
    {
        $clientAddress = \IPLib\Factory::addressFromString($this->userIp);

        foreach ($this->options['ipWhitelist'] as $ipRange) {
            $range = \IPLib\Factory::rangeFromString($ipRange);
            if ($clientAddress->matches($range))
                return true;
        }

        return false;
    }

    /**
     * Check if preview get var is set.
     *
     * @return bool
     */
    private function isPreview()
    {
        return (isset($_GET['maintenanceModePreview']) && $_GET['maintenanceModePreview']);
    }

    /**
     * Show maintenance mode page.
     */
    public function showMaintenancePage()
    {
        $theme = new Theme($this->options['theme']);
        $theme->render();
    }
}