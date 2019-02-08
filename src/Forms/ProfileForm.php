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
    /**
     * @var \SilverStripe\SiteConfig\SiteConfig
     */
    protected $siteConfig;

    public function __construct($controller, $name)
    {
        $this->setAttribute('id', 'ProfileForm');
        $this->setsiteConfig();
        parent::__construct($controller, $name, $this->getFormFields($controller), $this->getFormActions());
    }

    /**
     * Required FieldList creation on a ProfileForm
     *
     * @return \SilverStripe\Forms\FieldList
     */
    protected function getFormFields($controller = null)
    {
        $member = Security::getCurrentUser();
        $fieldList = parent::getFormFields();
        $fieldList->removeByName('Password');
        $fieldList->removeByName('Email');
        $this->setAttribute('id', 'ProfileForm');
        $fieldList->insertBefore(ReadOnlyField::create("Email", "Email", $member->Email), "Mobile");
        return $fieldList;
    }

    /**
     * Returns the Form action
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
     * @return \SilverStripe\Control\HTTPResponse
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
            } catch (\Exception $e) {
                $msg = $this->getCustomMessage('ProfileUpdatError')!=""
                    ? $this->getCustomMessage('ProfileUpdatError') : "Technical issue, Profile not updated!";
                $form->sessionMessage($msg, 'bad');
            }
        } else {
            return $this->controller->redirect($this->siteConfig->LoginUrl()->URLSegment);
        }
        return $this->controller->redirectBack();
    }

    /**
    * Return the Message from siteconfig
    * @return string
    */
    public function getCustomMessage($field)
    {
        return $this->siteConfig->$field;
    }
   
    /**
    * Assign siteconfig object
    */
    protected function setsiteConfig()
    {
        $this->siteConfig = SiteConfig::current_site_config();
    }
}
