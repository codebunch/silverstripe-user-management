<?php
namespace UserManagement\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Group;

/**
 * Class GroupExtension
 *
 * @package user-management
 */
class GroupExtension extends DataExtension
{
    /**
     * Add default records to database.
     *
     * This function is called whenever the database is built, after
     * the database tables have all been created. Overload
     * this to add default records when the database is built,
     * but make sure you call parent::requireDefaultRecords().
     */
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        // Add default general group if doesn't exists
        $allGroups = Group::get()->filter('Title', 'general');
        if ($allGroups->count() == 0) {
            $authorGroup = new Group();
            $authorGroup->Code = 'general';
            $authorGroup->Title = _t(__CLASS__ . '.DefaultGroupTitleGeneral', 'General');
            $authorGroup->Sort = 1;
            $authorGroup->write();
        }
    }
}
