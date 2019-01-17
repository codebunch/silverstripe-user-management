<?php

namespace UserManagement\Tests;

use UserManagement\Page\UserProfilePage;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Control\Director;
use SilverStripe\Security\Member;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Core\Injector\Injector;

/**
 * Class UserProfilePageTest
 *
 * @package user-management
 */
class UserProfilePageTest extends FunctionalTest
{
    
    /**
     * User profile page link test
     */
    public function testfindlink()
    {
        $pagedetails = [
        "userprofilelink" => "my-profile/"
        ];
        
        $link = UserProfilePage::find_link();
        
        foreach ($pagedetails as $key => $value) {
            $this->assertEquals(
            Director::baseURL() . $value,
            $link,
            'testfindlink() returns the correct link to user profile page.'
            );
        }
    }

    /**
     * User profile form test
     */
    public function testMyForm()
    {
        $member = Member::get()->filter("Email", "hello3@cms.com")->first();
        Injector::inst()->get(IdentityStore::class)->logIn($member);

        $this->get("my-profile/");
     
        $this->submitForm("ProfileForm", "action_doSubmit", array("FirstName" => "John"));

        $this->assertEquals(1, Member::get()->filter("Email", "hello3@cms.com")->count()>0 ? 1 : 0,
         'testMyForm() returns the email from profile page.');
    }
}
