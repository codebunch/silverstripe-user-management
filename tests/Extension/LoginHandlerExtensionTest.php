<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Security\Security;
use UserManagement\Extension\LoginHandlerExtension;
use SilverStripe\Security\Member;

/**
 * Class LoginHandlerExtensionTest
 *
 * @package user-management
 */
class LoginHandlerExtensionTest extends FunctionalTest
{
   /**
   *
   **/
    public function testRedirect()
    {
        $member = Member::create();
        $member->Email = "hello334@cms.com";
        $member->Password = "admin";
        $this->logInAs($member);
        $page = $this->get("user-login/");  // attempt to access the user login Page
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
    }
}
