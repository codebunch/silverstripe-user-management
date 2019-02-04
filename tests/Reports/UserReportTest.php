<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use UserManagement\Reports\UserReport;

/**
 * Class UserReportTest
 *
 * @package user-management
 */
class UserReportTest extends FunctionalTest
{

    private $userReport;

    protected function setUp()
    {
        parent::setUp();
        $this->userReport = new UserReport;
    }
    
    /**
     * User Report Title test
     */
    public function testtitle()
    {
       
        $gettitle = $this->userReport->title();
        $this->assertEquals($gettitle, "Customer List", "Title validation");
    }

    /**
     * User Report Source records test
     */
    public function testsourceRecords()
    {
        $params = array();

        $getsourcerecords = count($this->userReport->sourceRecords($params));

        if ($getsourcerecords) {
            $this->assertLessThan($getsourcerecords, "0", "Source records validation");
        } else {
            $this->assertEquals($getsourcerecords, "0", "Source records validation");
        }
    }

    /**
     * User Report fields test
     */
    public function testcolumns()
    {

        $fields = count($this->userReport->columns());

        if ($fields == 3) {
            $this->assertEquals($fields, "3", "Default fields");
        } else {
            $this->assertLessThan($fields, "3", "Extra fields added");
        }
    }

    /**
     * User Report parameter fields test
     */
    public function testparameterFields()
    {

        $fields = count($this->userReport->parameterFields());

        if ($fields == 3) {
            $this->assertEquals($fields, "3", "Default fields");
        } else {
            $this->assertLessThan($fields, "3", "Extra fields added");
        }
    }
}
