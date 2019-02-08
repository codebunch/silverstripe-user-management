<?php
namespace UserManagement\Page;

use Page;
use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

/**
 * Class UserProfilePage
 *
 * @package user-management
 */
class UserProfilePage extends Page
{
    public function canCreate($member = null, $context = array())
    {
        return !self::get()->exists();
    }

    /**
     * Returns the link or the URLSegment to the profile page on this site
     *
     * @param boolean $urlSegment Return the URLSegment only
     *
     * @return mixed
     */
    public static function find_link($urlSegment = false)
    {
        $page = self::get_if_profile_page_exists();
        return ($urlSegment) ? $page->URLSegment : $page->Link();
    }

    /**
     * @return object
     */
    protected static function get_if_profile_page_exists()
    {
        if ($page = DataObject::get_one(self::class)) {
            return $page;
        }
        user_error(_t(__CLASS__.'.NoPage', 'No UserProfilePage was found. 
            Please create one in the CMS!'), E_USER_ERROR);
        return null;
    }
    
    /**
     * This module always requires a page model.
     */
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();
        if (!self::get()->exists() && $this->config()->create_default_pages) {
            /**
             * @var UserProfilePage $page
             */
            $page = self::create()->update(
                [
                'Title' => 'Profile',
                'URLSegment' => UserProfilePageController::config()->url_segment,
                'CanViewType' => 'LoggedInUsers',
                'ShowInMenus' => 0,
                ]
            );
            $page->write();
            $page->publishSingle();
            $page->flushCache();
            DB::alteration_message('UserProfilePage page created', 'created');
        }
    }
}
