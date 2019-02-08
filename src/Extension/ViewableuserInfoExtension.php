<?php
namespace UserManagement\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Security\Group;
use SilverStripe\View\ViewableData;
use SilverStripe\Security\Security;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\TemplateGlobalProvider;

/**
 * Class ViewableuserInfoExtension
 *
 * @package user-management
 */
class ViewableuserInfoExtension extends Extension implements TemplateGlobalProvider
{

    /**
     * Returns logout link
     *
     * @return string | bool
     */
    public static function getlogoutLink()
    {
        if (Security::getCurrentUser()) {
            $html = DBHTMLText::create();
            $html->setValue("<a href='".Security::logout_url()."&BackURL=/'>Logout</a>");
            return $html;
        }
        return false;
    }

    /**
     * Defines global accessible templates variables.
     *
     * @return array
     */
    public static function get_template_global_variables()
    {
        return [
            "LoginLink" => "getlogoutLink",
        ];
    }
}
