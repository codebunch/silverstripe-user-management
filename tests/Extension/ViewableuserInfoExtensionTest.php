<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Security\Security;
use UserManagement\Extension\ViewableuserInfoExtension;

/**
 * Class ViewableuserInfoExtensionTest
 *
 * @package user-management
 */
class ViewableuserInfoExtensionTest extends FunctionalTest
{

    /**
     * Logout template variable
     */
    public function testget_template_global_variables()
    {
        $data = ViewableuserInfoExtension::get_template_global_variables();
        $this->assertEquals("getlogoutLink", $data["LoginLink"], "Login page exists");
    }

    /**
     * Logout Link
     */
    public function testgetlogoutLink()
    {
        $data = ViewableuserInfoExtension::getlogoutLink();
        if ($data) {
            $this->markTestIncomplete('Login page exists');
        } else {
            $this->assertInternalType('bool', $data);
        }
    }
}
