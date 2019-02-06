<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Security\Security;
use UserManagement\Extension\LoginHandlerExtension;
use SilverStripe\Security\Member;

/**
 * Class LoginHandlerExtensionTest
 *
 * @package user-management
 */
class LoginHandlerExtensionTest extends FunctionalTest
{
  
    protected static $fixture_file = [
        __DIR__ . '/../Fixtures/user.yml'
    ];

    public function testRedirect()
    {
        $member = $this->objFromFixture(Member::class, "joebloggs");
        $this->logInAs($member);
        $page = $this->get("user-login/");
        $this->assertEquals(200, $page->getStatusCode(), "a page should load");
    }
}
