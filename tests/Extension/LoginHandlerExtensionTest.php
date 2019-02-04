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
        $results = [];
        $this->get("user-registration/");
        $this->submitForm("SignUpForm", "action_doSubmit", array("FirstName" => "John",
            "Password[_Password]" => "admin",
            "Password[_ConfirmPassword]" => "test", "Email" => "hellotest@cms.com"));
        $member = Member::create();
        $member->FirstName = "John";
        $member->Email = "hellotest@cms.com";
        $member->Password = "test";
        $this->logInAs($member);
        $page = $this->get("admin/pages/");
        $this->assertEquals(403, $page->getStatusCode(), "a page should load" . $page->getStatusCode());
    }
}
