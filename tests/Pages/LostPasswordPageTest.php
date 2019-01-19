<?php

namespace UserManagement\Tests;

use UserManagement\Page\LostPasswordPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Control\Director;

/**
 * Class LostPasswordPageTest
 *
 * @package user-management
 */
class LostPasswordPageTest extends SapphireTest
{
    
    /**
     * Lost password page link test
     */
    public function testfindlink()
    {
       
        $page = $this->get("forgotten-password/");  // attempt to access the Lost Forgot Page
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
    }
}
