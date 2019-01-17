<?php
namespace UserManagement\Page;

use PageController;
use SilverStripe\Security\MemberAuthenticator\LostPasswordHandler;
use SilverStripe\Security\MemberAuthenticator\LostPasswordForm;

/**
 * Class LostPasswordPageController
 *
 * @package user-management
 */
class LostPasswordPageController extends PageController
{
    private static $url_segment = 'forgotten-password';

    private $authenticatorClass = MemberAuthenticator::class;

    private static $allowed_actions = array('LostPasswordForm');

    public function LostPasswordForm()
    {
        return LostPasswordForm::create(
            LostPasswordHandler::create('/Security/lostpassword/'),
            $this->authenticatorClass,
            'lostPasswordForm',
            null,
            null,
            false
        );
    }
}
