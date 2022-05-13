<?php
if (! defined('sugarEntry') || ! sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once ('include/Dashlets/DashletGeneric.php');
require_once ('modules/SA_AthenaSyncLogs/SA_AthenaSyncLogs.php');

classSA_AthenaSyncLogsDashlet extends DashletGeneric
{

    function __construct($id, $def = null)
    {
        global $current_user, $app_strings;
        require ('modules/SA_AthenaSyncLogs/metadata/dashletviewdefs.php');
        
        parent::__construct($id, $def);
        
        if (empty($def['title'])) {
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'SA_AthenaSyncLogs');
        }
        
        $this->searchFields = $dashletData['SA_AthenaSyncLogsDashlet']['searchFields'];
        $this->columns = $dashletData['SA_AthenaSyncLogsDashlet']['columns'];
        
        $this->seedBean = newSA_AthenaSyncLogs();
    }
}