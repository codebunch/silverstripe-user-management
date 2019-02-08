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
   
    /**
     * Login in the user and figure out where to redirect the browser.
     * It redirect general group user to profile page. Otherwise it refers parent method.
     * The $data has this format
     * array(
     *   'AuthenticationMethod' => 'MemberAuthenticator',
     *   'Email' => 'sam@silverstripe.com',
     *   'Password' => '1nitialPassword',
     *   'BackURL' => 'test/link',
     *   [Optional: 'Remember' => 1 ]
     * )
     *
     * @return HTTPResponse
     */
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
