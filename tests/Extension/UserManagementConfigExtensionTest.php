<?php

namespace UserManagement\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class UserManagementConfigExtensionTest
 *
 * @package user-management
 */
class UserManagementConfigExtensionTest extends FunctionalTest
{
    
    private $siteconfig;

    protected function setUp()
    {
        parent::setUp();

        $this->siteconfig = SiteConfig::create();
    }

    /**
     * Login url test
     */
    public function testgetLoginUrlID()
    {
       
        $loginurlid = $this->siteconfig->getLoginUrlID();
        $this->assertNotNull($loginurlid, "login url exists");
    }


    /**
     * Login call back url test
     */
    public function testgetLoginCallBackUrlID()
    {
       
        $logincallbackurlid = $this->siteconfig->getLoginCallBackUrlID();
        $this->assertNotNull($logincallbackurlid, "login call back url exists");
    }

    /**
     * Lost password url test
     */
    public function testgetLostPasswordUrlID()
    {
       
        $lostpasswordurlid = $this->siteconfig->getLostPasswordUrlID();
        $this->assertNotNull($lostpasswordurlid, "lost password url exists");
    }

    /**
     * Customer group id test
     */
    public function testgetCustomerGroupID()
    {
       
        $customergroupid = $this->siteconfig->getCustomerGroupID();
        $this->assertNotNull($customergroupid, "lost password url exists");
    }

    /**
     * Export fields test
     */
    public function testgetExportFieldNames()
    {
       
        $exportfields = $this->siteconfig->getExportFieldNames();
        $this->assertNotEmpty($exportfields, "export fields should be returned");
    }
    
    /**
   * CMS fields test
   **/
    public function testgetCMSFields()
    {
       
        $fields = $this->siteconfig->getCMSFields();
        $this->assertNotEmpty($fields, "All fields exists in Sitconfig");
    }
}
