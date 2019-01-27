<?php
namespace UserManagement\Reports;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\i18n\i18nEntityProvider;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\Reports\Report;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Forms\TextField;
use SilverStripe\SiteConfig\SiteConfig;

/**
 *
 * Base class for creating reports that can be filtered to a specific range.
 * Record grouping is also supported.
 *
 * @package user-management
 *
 */
class UserReport extends Report
{
    protected $periodfield = '"Member"."Created"';

     // the name of the report
    public function title()
    {
        return 'Customer List';
    }

    // what we want the report to return
    public function sourceRecords($params)
    {
        
        $fields = $this->parameterFields();
        $fields->setValues($params);
        $start = $fields->fieldByName('StartPeriod')->dataValue();
        $end = $fields->fieldByName('EndPeriod')->dataValue();
        $firstName = $fields->fieldByName('FirstName')->dataValue();
        $filter = false;
        if ($end) {
            $end = date('Y-m-d', strtotime($end) + 86400);
        }

        if ($start && $end) {
            $filter = "Member.Created BETWEEN '$start' AND '$end'";
        } elseif ($start) {
            $filter = "Member.Created > '$start'";
        } elseif ($end) {
            $filter = "Member.Created <= '$end'";
        }
        if ($firstName) {
            $filter = ($filter)? $filter . " AND FirstName Like '%$firstName%'" : "FirstName Like '%$firstName%'";
        }
        $config = SiteConfig::current_site_config();
        $member = Member::get()->filter('Groups.Title', $config->CustomerGroup()->Title);
        if ($filter) {
            return $member->where($filter);
        }
        return $member;
    }

    // which fields on that object we want to show
    public function columns()
    {
        $fields = [
            'FirstName' => 'FirstName',
            'Surname' => 'Surname',
            'Email' => 'Email'
        ];
        $config = SiteConfig::current_site_config();
        if ($config->getField("ExportFields")) {
            $ExportFields = json_decode($config->getField("ExportFields"), true);
            $ExtraFields = array_combine($ExportFields, $ExportFields);
            $fields = array_merge($fields, $ExtraFields);
        }


        return $fields;
    }

    public function parameterFields()
    {
        $member = Security::getCurrentUser() ? Security::getCurrentUser() : Member::create();
        $dateformat = $member->getDateFormat();
        $fields = FieldList::create(
            $firstName = TextField::create('FirstName', 'FirstName'),
            $start = DateField::create('StartPeriod', 'Start Date'),
            $end = DateField::create('EndPeriod', 'End Date')
        );
        
        return $fields;
    }
}
