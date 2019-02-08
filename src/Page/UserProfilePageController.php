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
    /**
     * @var string
     */
    private static $url_segment = 'my-profile';

    /**
     * @var array
     */
    private static $allowed_actions = array('ProfileForm');

    /**
     * @var mixed
     */
    private $member = false;

    public function init()
    {
        parent::init();

        $this->member = Security::getCurrentUser();
    }
    
    /**
     * Returns the profile form
     * @return \UserManagement\Forms\ProfileForm
     */
    public function ProfileForm()
    {

        $form = new ProfileForm($this, 'ProfileForm');
        $form->loadDataFrom($this->member);
        return $form;
    }
}
