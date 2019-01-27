<?php
namespace UserManagement\Page;

use Page;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;

/**
 * Class UserLoginPage
 *
 * @package user-management
 */
class UserLoginPage extends Page
{
    
    private static $table_name = 'UserManagement_UserLoginPage';

    public function canCreate($member = null, $context = array())
    {
        return !self::get()->exists();
    }

    /**
     * Returns the link or the URLSegment to the account page on this site
     *
     * @param boolean $urlSegment Return the URLSegment only
     *
     * @return mixed
     */
    public static function find_link($urlSegment = false)
    {
        $page = self::get_if_login_page_exists();
        return ($urlSegment) ? $page->URLSegment : $page->Link();
    }

    /**
     * @return UserRegistrationPage
     */
    protected static function get_if_login_page_exists()
    {
        if ($page = DataObject::get_one(self::class)) {
            return $page;
        }
        user_error(_t(__CLASS__ . '.NoPage', 'No CustomerLoginPage was found. 
            Please create one in the CMS!'), E_USER_ERROR);
        return null; // just to keep static analysis happy
    }
    
    /**
     * This module always requires a page model.
     */
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();
        if (!self::get()->exists() && $this->config()->create_default_pages) {
            /**
             * @var UserLoginPage $page
             */
            $page = self::create()->update(
                [
                'Title' => 'UserLogin',
                'URLSegment' => UserLoginPageController::config()->url_segment,
                'ShowInMenus' => 0,
                ]
            );
            $page->write();
            $page->publishSingle();
            $page->flushCache();
            DB::alteration_message('UserLoginPage page created', 'created');
        }
    }
}
