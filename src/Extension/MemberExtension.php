<?php
namespace UserManagement\Extension;

use SilverStripe\ORM\DataExtension;

/**
 * Class MemberExtension
 *
 * @package user-management
 */
class MemberExtension extends DataExtension
{
    private static $db = array(
        "NickName" => "Varchar(255)",
        "Gender" => "Varchar(255)",
        "DOB" => "Date",
        "Mobile" => "Varchar(255)",
        "SecurityQuestion" => "Text",
        "SecurityAnswer" => "Text"
    );
}
