<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\SapphireTest;

/**
 * Class UserLoginPageTest
 *
 * @package user-management
 */
class UserLoginPageTest extends SapphireTest
{
    
    /**
     * Login page link test
     */
    public function testfindlink()
    {
        $page = $this->get("user-login/");  // attempt to access the user login Page
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
    }
}
