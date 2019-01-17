<?php
namespace UserManagement\Extension;

use SilverStripe\Security\Security;
use SilverStripe\Security\MemberAuthenticator\LoginHandler;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class LoginHandlerExtension
 *
 * @package user-management
 */
class LoginHandlerExtension extends LoginHandler
{
   

    protected function redirectAfterSuccessfulLogin()
    {
        if (Security::getCurrentUser()->inGroup('3')) {
            $config = SiteConfig::current_site_config();
            if ($config->LoginCallBackUrl()->URLSegment) {
                return $this->redirect($config->LoginCallBackUrl()->URLSegment);
            }
        }
        return parent::redirectAfterSuccessfulLogin();
    }
}
