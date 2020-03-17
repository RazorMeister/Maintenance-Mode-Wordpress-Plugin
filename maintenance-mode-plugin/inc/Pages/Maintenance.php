<?php

namespace MaintenanceModePlugin\Inc\Pages;

use MaintenanceModePlugin\Inc\Base\BaseController;

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
        $whitelistedIps = explode(',', $this->options['ipWhitelist']);
        if (!is_array($whitelistedIps))
            $whitelistedIps = [];

        return in_array($this->getUserIp(), $whitelistedIps);
    }

    /**
     * Get user ip.
     *
     * @return mixed
     */
    private function getUserIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return apply_filters('wpb_get_ip', $ip);
    }

    /**
     * Show maintenance mode page.
     */
    public function showMaintenancePage()
    {
        require_once $this->pluginPath.'/templates/maintenancePage.php';
    }
}