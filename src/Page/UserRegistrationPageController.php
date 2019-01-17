<?php
namespace UserManagement\Page;

use PageController;
use SilverStripe\Security\Member;
use UserManagement\Forms\SignUpForm;
use SilverStripe\SiteConfig\SiteConfig;

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
        $member = Member::currentUser();
        if ($member && $member->exists()) {
            $config = SiteConfig::current_site_config();
            if ($config->LoginCallBackUrl()->URLSegment) {
                return $this->redirect($config->LoginCallBackUrl()->URLSegment);
            }
        }
    }

    /**
     * @return object
     */
    public function SignUpForm()
    {
        $form = new SignUpForm($this, 'SignUpForm');
        $config = SiteConfig::current_site_config();
        if($config->EnableSpamProtection)
            $form->enableSpamProtection();
        return $form;
    }
}
