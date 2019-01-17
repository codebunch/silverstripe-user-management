<?php

namespace UserManagement\Tests;

use UserManagement\Forms\SignUpForm;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Control\Director;
use SilverStripe\Security\Member;

/**
 * Class SignUpFormTest
 *
 * @package user-management
 */
class SignUpFormTest extends FunctionalTest
{
    
    /**
     * Signup form test
     */
    public function testMyForm()
    {

        $this->get("user-registration-1/");

        $this->submitForm("SignUpForm", "action_doSubmit", array("FirstName" => "John",
         "Password[_Password]" => "admin",
            "Password[_ConfirmPassword]" => "admin", "Email" => "hello3@cms.com"));

        $this->assertEquals(1, Member::get()->filter("Email", "hello5@cms.com")->count()>0 ? 1 : 0,
         'testMyForm() returns the user email');
    }
}
