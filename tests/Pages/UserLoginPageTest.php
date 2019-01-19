<?php

namespace UserManagement\Tests;

use UserManagement\Page\UserLoginPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Control\Director;

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
        $pagedetails = [
        "URLSegment1" => "user-login-1/"       
        ];
        
        $link = UserLoginPage::find_link();
        
        foreach ($pagedetails as $key => $value) {
            $this->assertEquals(
            Director::baseURL() . $value,
            $link,
            'testfindlink() returns the correct link to login page.'
            );
        }
    }
}
