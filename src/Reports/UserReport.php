<?php
namespace UserManagement\Reports;

use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
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

    /**
     * It returns Tile of the report
     * @return string
     */
    public function title()
    {
        return 'Customer List';
    }

    /**
     * @param array $params
     * @return \SilverStripe\ORM\DataList
     */
    public function sourceRecords($params)
    {
        
        $fields = $this->parameterFields();
        $fields->setValues($params);
        $start = $fields->fieldByName('StartPeriod')->dataValue();
        $end = $fields->fieldByName('EndPeriod')->dataValue();
        $firstName = $fields->fieldByName('FirstName')->dataValue();
        if ($end) {
            $end = date('Y-m-d', strtotime($end) + 86400);
        }
        $config = SiteConfig::current_site_config();
        $member = Member::get()->filter('Groups.Title', $config->CustomerGroup()->Title);
        $filter = $this->FilterByDate($start, $end);
        if ($this->FilterByName($filter, $firstName)) {
            return $member->where($filter);
        }
        return $member;
    }

    /**
     * Returns columns names of the reports
     * @return array
     */
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
    
    /**
     * Return a FieldList of the fields that can be used to filter
     * @return array
     */
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
    
    /**
     * @param string $start
     * @param string $end
     * @param string $firstName
     * @return string | false
     */
    public function FilterByDate($start, $end)
    {
        $filter = false;
        if ($start && $end) {
            $filter = "Member.Created BETWEEN '$start' AND '$end'";
        } elseif ($start) {
            $filter = "Member.Created > '$start'";
        } elseif ($end) {
            $filter = "Member.Created <= '$end'";
        }
        return $filter;
    }

    /**
     * @param string $firstName
     * @param string $filter
     * @return string | false
     */
    public function FilterByName($filter, $firstName)
    {
        if ($firstName) {
            $filter = ($filter) ? $filter . " AND FirstName Like '%$firstName%'" : "FirstName Like '%$firstName%'";
        }
        return $filter;
    }
}
