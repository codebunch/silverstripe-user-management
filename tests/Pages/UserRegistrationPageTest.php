<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\SapphireTest;

/**
 * Class UserRegistrationPageTest
 *
 * @package user-management
 */
class UserRegistrationPageTest extends SapphireTest
{
    
    /**
     * User registration page link test
     */
    public function testfindlink()
    {
        $page = $this->get("user-registration/");  // attempt to access the signup Page
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
    }
}
