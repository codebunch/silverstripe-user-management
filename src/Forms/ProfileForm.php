<?php
namespace UserManagement\Forms;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\ReadOnlyField;
use SilverStripe\Forms\FormAction;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;

/**
 * Class ProfileForm
 *
 * @package user-management
 */
class ProfileForm extends SignUpForm
{
    
    protected $siteConfig;

    public function __construct($controller, $name)
    {
        $this->setAttribute('id', 'ProfileForm');
        $this->setsiteConfig();
        parent::__construct($controller, $name, $this->getFormFields($controller), $this->getFormActions());
    }
    protected function getFormFields($controller = null)
    {
        $member = Security::getCurrentUser();
        $fieldList = parent::getFormFields();
        $fieldList->removeByName('Password');
        $fieldList->removeByName('Email');
        $this->setAttribute('id', 'ProfileForm');
        $fieldList->insertBefore(ReadOnlyField::create("Email", "Email", $member->Email), 'Mobile');
        return $fieldList;
    }

    /**
     * @return FieldList Actions for this form.
     */
    protected function getFormActions()
    {
        return FieldList::create(
            FormAction::create("doSubmitProfile", "Submit")
        );
    }

    /**
     * Form action, updates the user profile.
     */
    public function doSubmitProfile($data, Form $form)
    {
        $member = Security::getCurrentUser();
        if ($member) {
            try {
                $form->saveInto($member);
                $member->write();
                $msg = $this->getCustomMessage('ProfileUpdateSuccess')!=""
                    ? $this->getCustomMessage('ProfileUpdateSuccess') : "Profile updated!";
                $form->sessionMessage($msg, 'good');
            } catch (Exception $e) {
                $msg = $this->getCustomMessage('ProfileUpdatError')!=""
                    ? $this->getCustomMessage('ProfileUpdatError') : "Technical issue, Profile not updated!";
                $form->sessionMessage($msg, 'bad');
            }
        } else {
            return $this->controller->redirect($this->siteConfig->LoginUrl()->URLSegment);
        }
        return $this->controller->redirectBack();
    }

    
    public function getCustomMessage($field)
    {
        return $this->siteConfig->$field;
    }
   
    protected function setsiteConfig()
    {
        $this->siteConfig = SiteConfig::current_site_config();
    }
}
