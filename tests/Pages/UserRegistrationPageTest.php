<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;

/**
 * Class UserRegistrationPageTest
 *
 * @package user-management
 */
class UserRegistrationPageTest extends FunctionalTest
{
    
    /**
     * User registration page link test
     */
    public function testfindlink()
    {
        $page = $this->get("user-registration/");  // attempt to access the signup Page
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
        $this->assertEquals(UserRegistration::find_link(false), "user-registration", "user-registration page exists");
    }
}
