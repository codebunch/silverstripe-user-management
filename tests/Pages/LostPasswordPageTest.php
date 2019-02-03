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


    /**
     * Lost password form test
     */
    public function testLostPasswordForm()
    {

        $this->get("forgotten-password/");

        $this->submitForm("LostPasswordForm_lostPasswordForm", "action_forgotPassword", array("Email" => "test@gmail.com"));
        
        $this->assertEquals(
            false,
            http_response_code(),
            'testLostPasswordForm() sends email'
        );
    }
}
