<?php

class SA_AthenaSyncLogs extends Basic
{

    const MODULE_NAME = 'SA_AthenaSyncLogs';
    const TABLE_NAME = 'sa_athenasynclogs';

    public $new_schema = true;
    public $module_dir = self::MODULE_NAME;
    public $object_name = 'SA_AthenaSyncLogs';
    public $table_name = self::TABLE_NAME;
    public $importable = true;
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $SecurityGroups;

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        
        return false;
    }

    public function ACLAccess($view, $is_owner = 'not_set', $in_group = 'not_set')
    {
        global $current_user;
        if(!$current_user->is_admin){
            return false;
        }
        return parent::ACLAccess($view, $is_owner, $in_group);
    }


}
