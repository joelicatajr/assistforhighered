<h2>Maricopa Theme</h2>
<form id="ConfigureSettings" name="ConfigureSettings" enctype='multipart/form-data' method="POST"
      action="index.php?module=Administration&action=MaricopaTheme&do=save">

    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">


        <tr>
            <td scope="row">
                <span>{$MOD.LBL_MCCD_THEME_SUPPORT_URL}</span>
            </td>
            <td>
                <input type="text" id="maricopatheme_support_url"
                       name='maricopatheme[support_url]'
                       value='{$config.maricopatheme.support_url}'>

            </td>
        </tr>
        <tr>
            <td scope="row">
                <span>{$MOD.LBL_MCCD_THEME_TRAINING_URL}</span>
            </td>
            <td>
                <input type="text" id="maricopatheme_training_url"
                       name='maricopatheme[training_url]'
                       value='{$config.maricopatheme.training_url}'>

            </td>
        </tr>
        <tr>
            <td scope="row">
                <span>{$MOD.LBL_MCCD_THEME_FEEDBACK_URL}</span>
            </td>
            <td>
                <input type="text" id="maricopatheme_feedback_url"
                       name='maricopatheme[feedback_url]'
                       value='{$config.maricopatheme.feedback_url}'>

            </td>
        </tr>
        {foreach from=$colours item=colour}
            <tr>
                <td scope="row">
                    <span>{$colour.label}</span>
                </td>
                <td>
                    <input type='color' size='20' id="maricopatheme_{$colour.name}"
                           name='maricopatheme[{$colour.name}]'
                           style="text-align: right;" value='{$colour.value}'>
                    <button type="button" onclick="$('#maricopatheme_{$colour.name}').val('{$colour.default}');return false;"><span class="suitepicon suitepicon-action-clear"></span></button>
                </td>
            </tr>
        {/foreach}
    </table>

    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="actionsContainer">
        <tr>
            <td>
                <input title="{$APP.LBL_SAVE_BUTTON_TITLE}"
                       accessKey="{$APP.LBL_SAVE_BUTTON_KEY}"
                       class="button primary"
                       type="submit"
                       name="save"
                       onclick="return check_form('ConfigureSettings');"
                       value="  {$APP.LBL_SAVE_BUTTON_LABEL}  ">
                &nbsp;
                <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"
                       onclick="document.location.href='index.php?module=Administration&action=index'"
                       class="button" type="button" name="cancel" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  ">
            </td>
        </tr>
    </table>
</form>
