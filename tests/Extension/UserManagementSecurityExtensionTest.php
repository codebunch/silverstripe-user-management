<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use UserManagement\Extension\SecurityExtension;

/**
 * Class UserManagementSecurityExtensionTest
 *
 * @package user-management
 */
class UserManagementSecurityExtensionTest extends FunctionalTest
{

    public function testlogin_url()
    {
        $login_url = SecurityExtension::login_url();
        $page = $this->get($login_url);  // attempt to access the signup Page
        $this->assertEquals(200, $page->getStatusCode(), "Login page exists");
    }

    public function testlost_password_url()
    {
        $lost_password_url = SecurityExtension::lost_password_url();
        $page = $this->get($lost_password_url);  // attempt to access the signup Page
        $this->assertEquals(200, $page->getStatusCode(), "Lost password page exists");
    }
}
