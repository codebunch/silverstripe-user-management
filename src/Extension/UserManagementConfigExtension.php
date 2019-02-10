<?php
namespace UserManagement\Extension;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Group;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Security\Member;

/**
 * Class UserManagementConfigExtension
 *
 * @package user-management
 */
class UserManagementConfigExtension extends DataExtension
{
    /**
     * DB Fields
     * @var array
     */
    private static $db = [
        "ProfileUpdateSuccess" => 'Text',
        "ProfileUpdatError" => 'Text',
        "EnableSpamProtection" => 'Boolean',
        "ExportFields" => 'Text'

    ];

    /**
     * One to many relationship
     * @var array
     */
    private static $has_one = [
        'LoginCallBackUrl' => SiteTree::class,
        'LoginUrl' => SiteTree::class,
        'LostPasswordUrl' => SiteTree::class,
        'CustomerGroup' => Group::class
    ];
    
    /**
     * Update the CMS fields
     *
     * @return \SilverStripe\Forms\FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->insertBefore('Access', $usertab = Tab::create('UserManagement', 'User Management'));
        $fields->addFieldToTab(
            'Root.UserManagement',
            TreeDropdownField::create(
                'CustomerGroupID',
                _t(__CLASS__ . '.CustomerGroup', 'Group to add new customers to'),
                Group::class
            )
        );
        $fields->addFieldToTab(
            'Root.UserManagement',
            TreeDropdownField::create(
                'LoginUrlID',
                _t(__CLASS__ . '.LoginUrl', 'Login Url'),
                SiteTree::class
            )
        );
        $fields->addFieldToTab(
            'Root.UserManagement',
            TreeDropdownField::create(
                'LoginCallBackUrlID',
                _t(__CLASS__ . '.LoginCallBackUrl', 'Login Call Back Url'),
                SiteTree::class
            )
        );
        $fields->addFieldToTab(
            'Root.UserManagement',
            TreeDropdownField::create(
                'LostPasswordUrlID',
                _t(__CLASS__ . '.LostPasswordUrl', 'Lost Password Url'),
                SiteTree::class
            )
        );
        $fields->addFieldToTab(
            'Root.UserManagement',
            TextareaField::create(
                'ProfileUpdateSuccess',
                _t(__CLASS__ . '.ProfileUpdateSuccess', 'Profile update Success Message')
            )
        );
        $fields->addFieldToTab(
            'Root.UserManagement',
            TextareaField::create(
                'ProfileUpdatError',
                _t(__CLASS__ . '.ProfileUpdatError', 'Profile update Error Message')
            )
        );
        $fields->addFieldToTab(
            'Root.UserManagement',
            CheckboxField::create(
                'EnableSpamProtection',
                _t(__CLASS__ . '.EnableSpamProtection', 'Enable Spam Protection')
            )
        );
        
        $fields->addFieldToTab(
            'Root.UserManagement',
            ListboxField::create(
                'ExportFields',
                'Select Data fields for the report',
                $this->getExportFieldNames(),
                json_decode($this->owner->ExportFields)
            )
        );
    }
    
    /**
     * Returns login page id
     *
     * @return integer
     */
    public function getLoginUrlID()
    {
        if (!$this->owner->LoginUrl()->ID && $this->getDBstatus()) {
            $LoginUrl = SiteTree::get()
                ->filter('ClassName', 'UserManagement\Page\UserLoginPage');
            if ($LoginUrl->count() > 0) {
                return $LoginUrl->first()->ID;
            } else {
                return;
            }
        } else {
            return $this->owner->LoginUrl()->ID;
        }
    }
    
    /**
     * Returns call back page id
     *
     * @return integer
     */
    public function getLoginCallBackUrlID()
    {
        if (!$this->owner->LoginCallBackUrl()->ID && $this->getDBstatus()) {
            $LoginCallBackUrl = SiteTree::get()
            ->filter('ClassName', 'UserManagement\Page\UserProfilePage');
            if ($LoginCallBackUrl->count() > 0) {
                return $LoginCallBackUrl->first()->ID;
            } else {
                return;
            }
        } else {
            return $this->owner->LoginCallBackUrl()->ID;
        }
    }

    /**
     * Returns lost password page id
     *
     * @return integer | null
     */
    public function getLostPasswordUrlID()
    {
        if (!$this->owner->LostPasswordUrl()->ID && $this->getDBstatus()) {
            $LostPasswordUrl = SiteTree::get()->filter('ClassName', 'UserManagement\Page\LostPasswordPage');
            if ($LostPasswordUrl->count() > 0) {
                return $LostPasswordUrl->first()->ID;
            } else {
                return;
            }
        } else {
            return $this->owner->LostPasswordUrl()->ID;
        }
    }
    
    
    /**
     * Returns customer group id
     *
     * @return integer | null
     */
    public function getCustomerGroupID()
    {
        if (!$this->owner->CustomerGroup()->ID && $this->getDBstatus()) {
            $group = Group::get()->filter('Title', 'general');
            if ($group->count() > 0) {
                return $group->first()->ID;
            } else {
                return;
            }
        } else if ($this->getDBstatus()) {
            return $this->owner->CustomerGroup()->ID;
        }
        return;
    }
    
    /**
     * Returns the DB fields exist for Member
     *
     * @return array
     */
    public function getExportFieldNames()
    {
        $memberFields = Member::create()->getFrontEndFields()->dataFieldNames();
        $memberFields = array_diff($memberFields, ["FirstName", "Surname", "Email",
            "TempIDHash", "TempIDExpired", "AutoLoginHash", "AutoLoginExpired",
            "PasswordEncryption", "Salt", "Locale", "FailedLoginCount",
            "LockedOutUntil", "Password", "PasswordExpiry"]);
        return array_combine($memberFields, $memberFields);
    }

    /**
     * Checks the DB status
     *
     * @return bool
     */
    public function getDBstatus()
    {
        if (\SilverStripe\ORM\DB::is_active() && count(\SilverStripe\ORM\DB::table_list()) > 0) {
            return true;
        }
        return false;
    }
}
