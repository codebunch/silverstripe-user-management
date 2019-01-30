<?php

if (SilverStripe\ORM\DB::is_active() && count(SilverStripe\ORM\DB::table_list()) > 0) {
    $config = SilverStripe\SiteConfig\SiteConfig::current_site_config();
    $lost_password_url_segment = $config->LostPasswordUrl()->URLSegment;
    if ($lost_password_url_segment) {
        SilverStripe\Security\Security::config()->set('lost_password_url', $lost_password_url_segment);
    }
    $login_url_segment = $config->LoginUrl()->URLSegment;
    if ($login_url_segment) {
        SilverStripe\Security\Security::config()->set('login_url', $login_url_segment);
    }
}
