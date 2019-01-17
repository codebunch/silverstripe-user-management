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
        $pagedetails = [
        "lostpasswordlink" => "forgotten-password/"
        ];
        
        $link = LostPasswordPage::find_link();
        
        foreach ($pagedetails as $key => $value) {
            $this->assertEquals(
            Director::baseURL() . $value,
            $link,
            'testfindlink() returns the correct link to lost password.'
            );
        }
    }
}
