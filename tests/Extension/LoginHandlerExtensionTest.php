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
        $member->FirstName = "John";
        $member->Email = "hellotest@cms.com";
        $member->Password = "test";
        $this->logInAs($member);
    }
}
