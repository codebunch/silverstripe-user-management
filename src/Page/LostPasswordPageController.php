<?php
namespace UserManagement\Page;

use PageController;
use SilverStripe\Security\MemberAuthenticator\LostPasswordHandler;
use SilverStripe\Security\MemberAuthenticator\LostPasswordForm;
use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;

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

    /**
     * Returns the default lost password form.
     *
     * @return \SilverStripe\Security\MemberAuthenticator\LostPasswordForm
     */
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
