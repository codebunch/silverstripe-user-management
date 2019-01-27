<?php
namespace UserManagement\Extension;

use SilverStripe\Control\Controller;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Director;

/**
 * Class SecurityExtension
 *
 * @package user-management
 */
class SecurityExtension extends Security
{
    /**
     * Allows to set login url through siteconfig
     *
     * @return string
     */
    public static function login_url()
    {
        $config = SiteConfig::current_site_config();
        $segment = $config->LoginUrl()->URLSegment;
        if ($segment) {
            return Controller::join_links(Director::baseURL(), $segment);
        }
        return Controller::join_links(Director::baseURL(), self::config()->get('login_url'));
    }

    /**
     * Allows to set lost password url through siteconfig
     *
     * @return string
     */
    public static function lost_password_url()
    {
        $config = SiteConfig::current_site_config();
        $segment = $config->LostPasswordUrl()->URLSegment;
        if ($segment) {
            return Controller::join_links(Director::baseURL(), $segment);
        }
        return Controller::join_links(Director::baseURL(), self::config()->get('lost_password_url'));
    }
}
