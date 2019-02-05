<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Security\Member;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Core\Injector\Injector;
use UserManagement\Page\UserProfilePage;

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
        $member = Member::get()->filter("Email", "hello3@cms.com")->first();
        Injector::inst()->get(IdentityStore::class)->logIn($member);
        $page = $this->get("my-profile/");  // attempt to access the profile Page
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
        $this->assertEquals(UserProfilePage::find_link(false), "my-profile", "My profile page exists");
    }

    /**
     * User profile form test
     */
    public function testMyForm()
    {
        $member = Member::get()->filter("Email", "hello3@cms.com")->first();
        Injector::inst()->get(IdentityStore::class)->logIn($member);

        $this->get("my-profile/");
     
        $this->submitForm("ProfileForm", "action_doSubmitProfile", array("FirstName" => "John"));

        $this->assertEquals(
            1,
            Member::get()->filter("Email", "hello3@cms.com")->count()>0 ? 1 : 0,
            'testMyForm() returns the email from profile page.'
        );
    }
}
