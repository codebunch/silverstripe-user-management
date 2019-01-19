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
        $config = SiteConfig::current_site_config();
        $groupID = $config->getCustomerGroupID();
        if (Security::getCurrentUser()->inGroup($groupID)) {
            if ($config->LoginCallBackUrl()->URLSegment) {
                return $this->redirect($config->LoginCallBackUrl()->URLSegment);
            }
        }
        return parent::redirectAfterSuccessfulLogin();
    }
}
