<?php

namespace UserManagement\Tests;

use UserManagement\Page\UserRegistrationPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Control\Director;

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
        $pagedetails = [
        "userregistrationlink" => "user-registration/"
        ];
        
        $link = UserRegistrationPage::find_link();
        
        foreach ($pagedetails as $key => $value) {
            $this->assertEquals(
            Director::baseURL() . $value,
            $link,
            'testfindlink() returns the correct link to user registration page.'
            );
        }
    }
}
