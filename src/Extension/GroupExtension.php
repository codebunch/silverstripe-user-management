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
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        // Add default general group if doesn't exists
        $allGroups = Group::get()->filter('Title', 'general');
        if (!$allGroups->count()) {
            $authorGroup = new Group();
            $authorGroup->Code = 'general';
            $authorGroup->Title = _t(__CLASS__ . '.DefaultGroupTitleGeneral', 'General');
            $authorGroup->Sort = 1;
            $authorGroup->write();
        }
    }
}
