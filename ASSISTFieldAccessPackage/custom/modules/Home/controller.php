<?php
require_once 'modules/Home/controller.php';
require_once 'custom/include/Services/ASSISTFieldRestriction.php';

function getEditFieldHTMLASSIST($module, $fieldname, $aow_field, $view = 'EditView', $id = '', $alt_type = '', $currency_id = '')
{
    global $current_language, $app_strings, $app_list_strings, $current_user, $beanFiles, $beanList;


    $bean = BeanFactory::getBean($module, $id);
    $fieldRestriction = new ASSISTFieldRestriction();
    $fieldRestriction->setFieldFlags($bean);

    if (!checkAccess($bean)) {
        return false;
    }


    $value = getFieldValueFromModule($fieldname, $module, $id);
    // use the mod_strings for this module
    $mod_strings = return_module_language($current_language, $module);

    // set the filename for this control
    $file = create_cache_directory('include/InlineEditing/') . $module . $view . $alt_type . $fieldname . '.tpl';

    if (!is_file($file)
        || inDeveloperMode()
        || !empty($_SESSION['developerMode'])
    ) {
        if (!isset($vardef)) {
            require_once($beanFiles[$beanList[$module]]);
            $focus = new $beanList[$module];
            $vardef = $focus->getFieldDefinition($fieldname);
        }

        $displayParams = array();
        //$displayParams['formName'] = 'EditView';

        // if this is the id relation field, then don't have a pop-up selector.
        if ($vardef['type'] == 'relate' && $vardef['id_name'] == $vardef['name']) {
            $vardef['type'] = 'varchar';
        }

        if (isset($vardef['precision'])) {
            unset($vardef['precision']);
        }

        //$vardef['precision'] = $locale->getPrecedentPreference('default_currency_significant_digits', $current_user);

        //TODO Fix datetimecomebo
        //temp work around
        if ($vardef['type'] == 'datetime') {
            $vardef['type'] = 'datetimecombo';
        }

        // trim down textbox display
        if ($vardef['type'] == 'text') {
            $vardef['rows'] = 2;
            $vardef['cols'] = 32;
        }

        // create the dropdowns for the parent type fields
        if ($vardef['type'] == 'parent_type') {
            $vardef['type'] = 'enum';
        }

        if ($vardef['type'] == 'link') {
            $vardef['type'] = 'relate';
            $vardef['rname'] = 'name';
            $vardef['id_name'] = $vardef['name'] . '_id';
            if ((!isset($vardef['module']) || $vardef['module'] == '') && $focus->load_relationship($vardef['name'])) {
                $vardef['module'] = $focus->{$vardef['name']}->getRelatedModuleName();
            }
        }

        //check for $alt_type
        if ($alt_type != '') {
            $vardef['type'] = $alt_type;
        }

        // remove the special text entry field function 'getEmailAddressWidget'
        if (isset($vardef['function'])
            && ($vardef['function'] == 'getEmailAddressWidget'
                || $vardef['function']['name'] == 'getEmailAddressWidget')
        ) {
            unset($vardef['function']);
        }

        if (isset($vardef['name']) && ($vardef['name'] == 'date_modified')) {
            $vardef['name'] = 'aow_temp_date';
        }

        // load SugarFieldHandler to render the field tpl file
        static $sfh;

        if (!isset($sfh)) {
            require_once('include/SugarFields/SugarFieldHandler.php');
            $sfh = new SugarFieldHandler();
        }

        $contents = $sfh->displaySmarty('fields', $vardef, $view, $displayParams);

        // Remove all the copyright comments
        $contents = preg_replace('/\{\*[^\}]*?\*\}/', '', $contents);
        // remove extra wrong javascript which breaks auto complete on flexi relationship parent fields
        $contents = preg_replace("/<script language=\"javascript\">if\(typeof sqs_objects == \'undefined\'\){var sqs_objects = new Array;}sqs_objects\[\'EditView_parent_name\'\].*?<\/script>/", "", $contents);


        if ($view == 'EditView' && ($vardef['type'] == 'relate' || $vardef['type'] == 'parent')) {
            $contents = str_replace('"' . $vardef['id_name'] . '"', '{/literal}"{$fields.' . $vardef['name'] . '.id_name}"{literal}', $contents);
            $contents = str_replace('"' . $vardef['name'] . '"', '{/literal}"{$fields.' . $vardef['name'] . '.name}"{literal}', $contents);
            // regex below fixes button javascript for flexi relationship
            if ($vardef['type'] == 'parent') {
                $contents = str_replace("onclick='open_popup(document.{\$form_name}.parent_type.value, 600, 400, \"\", true, false, {literal}{\"call_back_function\":\"set_return\",\"form_name\":\"EditView\",\"field_to_name_array\":{\"id\":{/literal}\"{\$fields.parent_name.id_name}", "onclick='open_popup(document.{\$form_name}.parent_type.value, 600, 400, \"\", true, false, {literal}{\"call_back_function\":\"set_return\",\"form_name\":\"EditView\",\"field_to_name_array\":{\"id\":{/literal}\"parent_id", $contents);
            }
        }

        // hack to disable one of the js calls in this control
        if (isset($vardef['function']) && ($vardef['function'] == 'getCurrencyDropDown' || $vardef['function']['name'] == 'getCurrencyDropDown')) {
            $contents .= "{literal}<script>function CurrencyConvertAll() { return; }</script>{/literal}";
        }



        // Save it to the cache file
        if ($fh = @sugar_fopen($file, 'w')) {
            fwrite($fh, $contents);
            fclose($fh);
        }
    }

    // Now render the template we received
    $ss = new Sugar_Smarty();

    // Create Smarty variables for the Calendar picker widget
    global $timedate;
    $time_format = $timedate->get_user_time_format();
    $date_format = $timedate->get_cal_date_format();
    $ss->assign('USER_DATEFORMAT', $timedate->get_user_date_format());
    $ss->assign('TIME_FORMAT', $time_format);
    $time_separator = ":";
    $match = array();
    if (preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match)) {
        $time_separator = $match[1];
    }
    $t23 = strpos($time_format, '23') !== false ? '%H' : '%I';
    if (!isset($match[2]) || $match[2] == '') {
        $ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . "%M");
    } else {
        $pm = $match[2] == "pm" ? "%P" : "%p";
        $ss->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . "%M" . $pm);
    }

    $ss->assign('CALENDAR_FDOW', $current_user->get_first_day_of_week());

    $fieldlist = array();
    if (!isset($focus) || !($focus instanceof SugarBean)) {
        require_once($beanFiles[$beanList[$module]]);
    }
    $focus = new $beanList[$module];
    // create the dropdowns for the parent type fields
    $vardefFields[$fieldname] = $focus->field_defs[$fieldname];
    if ($vardefFields[$fieldname]['type'] == 'parent') {
        $focus->field_defs[$fieldname]['options'] = $focus->field_defs[$vardefFields[$fieldname]['group']]['options'];
    }
    foreach ($vardefFields as $name => $properties) {
        $fieldlist[$name] = $properties;
        // fill in enums
        if (isset($fieldlist[$name]['options']) && is_string($fieldlist[$name]['options']) && isset($app_list_strings[$fieldlist[$name]['options']])) {
            $fieldlist[$name]['options'] = $app_list_strings[$fieldlist[$name]['options']];
        }
        // Bug 32626: fall back on checking the mod_strings if not in the app_list_strings
        elseif (isset($fieldlist[$name]['options']) && is_string($fieldlist[$name]['options']) && isset($mod_strings[$fieldlist[$name]['options']])) {
            $fieldlist[$name]['options'] = $mod_strings[$fieldlist[$name]['options']];
        }
    }

    // fill in function return values
    if (!in_array($fieldname, array('email1', 'email2'))) {
        if (!empty($fieldlist[$fieldname]['function']['returns']) && $fieldlist[$fieldname]['function']['returns'] == 'html') {
            $function = $fieldlist[$fieldname]['function']['name'];
            // include various functions required in the various vardefs
            if (isset($fieldlist[$fieldname]['function']['include']) && is_file($fieldlist[$fieldname]['function']['include'])) {
                require_once($fieldlist[$fieldname]['function']['include']);
            }
            $_REQUEST[$fieldname] = $value;
            $value = $function($focus, $fieldname, $value, $view);

            $value = str_ireplace($fieldname, $aow_field, $value);
        }
    }

    if ($fieldlist[$fieldname]['type'] == 'link') {
        $fieldlist[$fieldname]['id_name'] = $fieldlist[$fieldname]['name'] . '_id';

        if ((!isset($fieldlist[$fieldname]['module']) || $fieldlist[$fieldname]['module'] == '') && $focus->load_relationship($fieldlist[$fieldname]['name'])) {
            $relateField = $fieldlist[$fieldname]['name'];
            $fieldlist[$fieldname]['module'] = $focus->$relateField->getRelatedModuleName();
        }
    }

    if ($fieldlist[$fieldname]['type'] == 'parent') {
        $fieldlist['parent_id']['name'] = 'parent_id';
    }

    if (isset($fieldlist[$fieldname]['name']) && ($fieldlist[$fieldname]['name'] == 'date_modified')) {
        $fieldlist[$fieldname]['name'] = 'aow_temp_date';
        $fieldlist['aow_temp_date'] = $fieldlist[$fieldname];
        $fieldname = 'aow_temp_date';
    }

    if (isset($fieldlist[$fieldname]['id_name']) && $fieldlist[$fieldname]['id_name'] != '' && $fieldlist[$fieldname]['id_name'] != $fieldlist[$fieldname]['name']) {
        if ($value) {
            $relateIdField = $fieldlist[$fieldname]['id_name'];
            $rel_value =  $bean->$relateIdField;
        }
        $fieldlist[$fieldlist[$fieldname]['id_name']]['value'] = $rel_value;
        $fieldlist[$fieldname]['value'] = $value;
        $fieldlist[$fieldname]['id_name'] = $aow_field;
        $fieldlist[$fieldname]['name'] = $aow_field . '_display';
    } elseif (isset($fieldlist[$fieldname]['type']) && ($fieldlist[$fieldname]['type'] == 'datetimecombo' || $fieldlist[$fieldname]['type'] == 'datetime' || $fieldlist[$fieldname]['type'] == 'date')) {
        $value = $focus->convertField($value, $fieldlist[$fieldname]);
        if (!$value) {
            $value = date($timedate->get_date_time_format());
        }
        $fieldlist[$fieldname]['name'] = $aow_field;
        $fieldlist[$fieldname]['value'] = $value;
    } elseif (isset($fieldlist[$fieldname]['type']) && ($fieldlist[$fieldname]['type'] == 'date')) {
        $value = $focus->convertField($value, $fieldlist[$fieldname]);
        $fieldlist[$fieldname]['name'] = $aow_field;
        if (empty($value)) {
            $value = str_replace("%", "", date($date_format));
        }
        $fieldlist[$fieldname]['value'] = $value;
    } else {
        $fieldlist[$fieldname]['value'] = $value;
        $fieldlist[$fieldname]['name'] = $aow_field;
    }

    if ($fieldlist[$fieldname]['type'] == 'currency' && $view != 'EditView') {
        static $sfh;

        if (!isset($sfh)) {
            require_once('include/SugarFields/SugarFieldHandler.php');
            $sfh = new SugarFieldHandler();
        }

        if ($currency_id != '' && !stripos($fieldname, '_USD')) {
            $userCurrencyId = $current_user->getPreference('currency');
            if ($currency_id != $userCurrencyId) {
                $currency = BeanFactory::newBean('Currencies');
                $currency->retrieve($currency_id);
                $value = $currency->convertToDollar($value);
                $currency->retrieve($userCurrencyId);
                $value = $currency->convertFromDollar($value);
            }
        }

        $parentfieldlist[strtoupper($fieldname)] = $value;

        return ($sfh->displaySmarty($parentfieldlist, $fieldlist[$fieldname], 'ListView', $displayParams));
    }

    $ss->assign("fields", $fieldlist);
    $ss->assign("form_name", $view);
    $ss->assign("bean", $focus);

    $ss->assign("MOD", $mod_strings);
    $ss->assign("APP", $app_strings);

    return json_encode($ss->fetch($file));
}

class CustomHomeController extends HomeController{
    public function action_getEditFieldHTML()
    {
        if ($_REQUEST['field'] && $_REQUEST['id'] && $_REQUEST['current_module']) {
            $html = getEditFieldHTMLASSIST($_REQUEST['current_module'], $_REQUEST['field'], $_REQUEST['field'], 'EditView', $_REQUEST['id']);
            echo $html;
        }
    }
    public function action_saveHTMLField()
    {
        $bean = BeanFactory::getBean($_REQUEST['current_module'], $_REQUEST['id']);
        $fieldRestriction = new ASSISTFieldRestriction();
        $fieldRestriction->setFieldFlags($bean);
        $fieldDef = $bean->field_defs[$_REQUEST['field']];
        if(!empty($fieldDef['assist_field_hidden']) || !empty($fieldDef['assist_field_restricted'])){
            return;
        }
        parent::action_saveHTMLField();
    }
}