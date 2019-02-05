<?php
namespace UserManagement\Page;

use PageController;
use UserManagement\Forms\SignUpForm;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;


/**
 * Class UserRegistrationPageController
 *
 * @package user-management
 */
class UserRegistrationPageController extends PageController
{
    private static $url_segment = 'user-registration';

    private static $allowed_actions = array('SignUpForm');

    public function init()
    {
        parent::init();
        $member = Security::getCurrentUser();
        if ($member && $member->exists()) {
            $config = SiteConfig::current_site_config();
            if ($config->LoginCallBackUrl()->URLSegment) {
                return $this->redirect($config->LoginCallBackUrl()->URLSegment);
            }
        }
    }

    /**
     * @method string enableSpamProtection()
     * @return object
     */
    public function SignUpForm()
    {
        $form = new SignUpForm($this, 'SignUpForm');
        $config = SiteConfig::current_site_config();
        if ($config->EnableSpamProtection && class_exists('UndefinedOffset\NoCaptcha\Forms\NocaptchaField')) {
            $form->enableSpamProtection();
        }
        return $form;
    }
}
