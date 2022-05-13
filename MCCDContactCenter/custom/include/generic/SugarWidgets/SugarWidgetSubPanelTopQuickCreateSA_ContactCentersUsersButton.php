<?php

class SugarWidgetSubPanelTopQuickCreateSA_ContactCentersUsersButton extends SugarWidgetSubPanelTopButtonQuickCreate
{

    function display($defines)
    {
        global $app_strings;
        global $currentModule;
        
        $title = $app_strings['LBL_NEW_BUTTON_TITLE'];
        $value = $app_strings['LBL_NEW_BUTTON_LABEL'];
        $this->module = 'Users';
        if (ACLController::moduleSupportsACL($defines['module']) && ! ACLController::checkAccess($defines['module'], 'edit', true)) {
            $button = "<input title='$title'class='button' type='button' name='button' value='  $value  ' disabled/>\n";
            return $button;
        }
        
        $additionalFormFields = array();        if (! empty($defines['focus']->name)) {
            $additionalFormFields['sa_contactcenters_name'] = $defines['focus']->name;
        }        if (! empty($defines['focus']->id)) {
            $additionalFormFields['sa_contactcenters_id'] = $defines['focus']->id;
        }
        
        $button = $this->_get_form($defines, $additionalFormFields);
        $button .= "<input title='$title' class='button' type='submit' name='{$this->getWidgetId()}' id='{$this->getWidgetId()}' value='  $value  '/>\n";
        $button .= "</form>";
        return $button;
    }
}
