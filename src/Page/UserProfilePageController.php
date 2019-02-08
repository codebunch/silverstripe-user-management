<?php
namespace UserManagement\Page;

use PageController;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use UserManagement\Forms\ProfileForm;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class UserProfilePageController
 *
 * @package user-management
 */
class UserProfilePageController extends PageController
{
    private static $url_segment = 'my-profile';

    private static $allowed_actions = array('ProfileForm');

    private $member = false;


    public function init()
    {
        parent::init();

        $this->member = Security::getCurrentUser();

        if (!$this->member || !$this->member->exists()) {
            $config = SiteConfig::current_site_config();
            if ($config->LoginUrl()->URLSegment) {
                return $this->redirect($config->LoginUrl()->URLSegment);
            }
        }
    }
    
    /**
    * Returns the profile form
    * @return \UserManagement\Forms\ProfileForm
    */
    public function ProfileForm()
    {
        $form =  new ProfileForm($this, 'ProfileForm');
        if ($this->member) {
            $form->loadDataFrom($this->member);
        }
        return $form;
    }
}
