<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;

/**
 * Class LostPasswordPageTest
 *
 * @package user-management
 */
class LostPasswordPageTest extends FunctionalTest
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
