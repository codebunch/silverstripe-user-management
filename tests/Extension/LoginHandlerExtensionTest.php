<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Security;
use UserManagement\Extension\LoginHandlerExtension;
use SilverStripe\Security\Member;

/**
 * Class LoginHandlerExtensionTest
 *
 * @package user-management
 */
class LoginHandlerExtensionTest extends SapphireTest
{
    public static $fixture_file = array(
        __DIR__ . '/../Fixtures/user.yml'
    );
    /**
     * Login redirect
     */
    public function testRedirect()
    {
        $member = $this->objFromFixture(Member::class, "joebloggs");
        //$this->logInAs($member);
        $this->markTestIncomplete('Test user config CMS fields');
    }
}
