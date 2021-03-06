<?php
require_once 'modules/ModuleBuilder/parsers/ParserFactory.php';
function pre_install()
{
    $cfg = new Configurator();
    echo "Setting up config";
    if(empty($cfg->config['assist_athena'])) {
        $cfg->config['assist_athena']['database'] = 'LAKE_SISDATA';
        $cfg->config['assist_athena']['api_version'] = '2018-08-01';
        $cfg->config['assist_athena']['region'] = 'us-west-2';
        $cfg->config['assist_athena']['field_mapping'] = ['EMPLID' => 'emplid'];
        $cfg->saveConfig();
    }
    $schedulerBean = BeanFactory::getBean('Schedulers',"b29be142-54b2-f5b0-b699-613775e9f7ab");
    if(empty($schedulerBean->id)){
        $scheduler = BeanFactory::newBean('Schedulers');
        $scheduler->new_with_id = true;
        $scheduler->id = 'b29be142-54b2-f5b0-b699-613775e9f7ab';
        $scheduler->name = 'ASSIST Sync';
        $scheduler->job = "function::ASSISTRDSSyncScheduler";
        $scheduler->job_interval = "0::*/1::*::*::*";
        $scheduler->status = "Inactive";
        $scheduler->catch_up = 0;
        $scheduler->save();
    }
    $schedulerBean = BeanFactory::getBean('Schedulers',"a6a42fde-32b7-6ed9-e540-61489a5989f2");
    if(empty($schedulerBean->id)){
        $scheduler = BeanFactory::newBean('Schedulers');
        $scheduler->new_with_id = true;
        $scheduler->id = 'a6a42fde-32b7-6ed9-e540-61489a5989f2';
        $scheduler->name = 'ASSIST Historic Sync';
        $scheduler->job = "function::ASSISTRDSSyncHistoricScheduler";
        $scheduler->job_interval = "*/15::2-6::*::*::*";
        $scheduler->status = "Inactive";
        $scheduler->catch_up = 0;
        $scheduler->save();
    }

    $parser = ParserFactory::getParser('DetailView','Contacts');
    $parser->_viewdefs['templateMeta']['form']['buttons']['ASSIST_RDS_SYNC'] = array(
        'customCode' => '<input type="button" onclick="assistSync(\'{$fields.id.value}\')" class="button" value="{$MOD.LBL_PERFORM_ASSIST_RDS_SYNC_BUTTON}">',
    );
    $jsAdded = false;
    foreach($parser->_viewdefs['templateMeta']['includes'] as $def){
        if($def['file'] == 'custom/modules/Contacts/js/ASSISTSync.js'){
            $jsAdded = true;
        }
    }
    if(!$jsAdded){
        $parser->_viewdefs['templateMeta']['includes'][] = ['file' => 'custom/modules/Contacts/js/ASSISTSync.js'];
    }
    $parser->handleSave(false);

}
