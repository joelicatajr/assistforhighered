<?php
require_once 'custom/include/MCCDThemeLib/scssphp/scss.inc.php';

use ScssPhp\ScssPhp\Compiler;

if (!is_admin($current_user)) {
    sugar_die('Unauthorized access to Administration.');
}
function getColours()
{
    global $sugar_config, $mod_strings;
    $colours = [
        [
            'name' => 'main-font-color',
            'label' => $mod_strings['LBL_MARICOPATHEME_MAIN_TEXT'],
            'value' => $sugar_config['maricopatheme']['main-font-color'],
            'default' => '#2D2926',
        ],
        [
            'name' => 'navbar-inverse-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_NAVBAR_INVERSE_BG'],
            'value' => $sugar_config['maricopatheme']['navbar-inverse-bg'],
            'default' => '#2D2926',],
        [
            'name' => 'color-9',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR9'],
            'value' => $sugar_config['maricopatheme']['color-9'],
            'default' => '#0C2340',
        ],
        [
            'name' => 'color-11',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR11'],
            'value' => $sugar_config['maricopatheme']['color-11'],
            'default' => '#65697A',
        ],
        [
            'name' => 'color-59',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR59'],
            'value' => $sugar_config['maricopatheme']['color-59'],
            'default' => '#AFAABF',
        ],
        [
            'name' => 'color-64',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR64'],
            'value' => $sugar_config['maricopatheme']['color-64'],
            'default' => '#DDDDDD',],

        [
            'name' => 'color-80',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR80'],
            'value' => $sugar_config['maricopatheme']['color-80'],
            'default' => '#FFFFFF',
        ],
        [
            'name' => 'color-50',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR50'],
            'value' => $sugar_config['maricopatheme']['color-50'],
            'default' => '#CC5A5A',],
        [
            'name' => 'color-46',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR46'],
            'value' => $sugar_config['maricopatheme']['color-46'],
            'default' => '#CC5A5A',],
        [
            'name' => 'color-43',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR43'],
            'value' => $sugar_config['maricopatheme']['color-43'],
            'default' => '#D66C60',],

        [
            'name' => 'color-51',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR51'],
            'value' => $sugar_config['maricopatheme']['color-51'],
            'default' => '#F5F5F5',],
        [
            'name' => 'color-39',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR39'],
            'value' => $sugar_config['maricopatheme']['color-39'],
            'default' => '#BFCAD3',],

        [
            'name' => 'color-34',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR34'],
            'value' => $sugar_config['maricopatheme']['color-34'],
            'default' => '#A5E8D6',],
        [
            'name' => 'color-44',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR44'],
            'value' => $sugar_config['maricopatheme']['color-44'],
            'default' => '#D8F5EE',],


        [
            'name' => 'color-35',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR35'],
            'value' => $sugar_config['maricopatheme']['color-35'],
            'default' => '#CC5A5A',],


        [
            'name' => 'color-33',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR33'],
            'value' => $sugar_config['maricopatheme']['color-33'],
            'default' => '#0C2340',],
        [
            'name' => 'color-28',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR28'],
            'value' => $sugar_config['maricopatheme']['color-28'],
            'default' => '#0C2340',],

        [
            'name' => 'color-24',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR24'],
            'value' => $sugar_config['maricopatheme']['color-24'],
            'default' => '#8499AB',],
        [
            'name' => 'color-22',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR22'],
            'value' => $sugar_config['maricopatheme']['color-22'],
            'default' => '#808F9C',],
        [
            'name' => 'color-19',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR19'],
            'value' => $sugar_config['maricopatheme']['color-19'],
            'default' => '#777777',],

        [
            'name' => 'color-20',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR20'],
            'value' => $sugar_config['maricopatheme']['color-20'],
            'default' => '#2D2926',],
        [
            'name' => 'color-18',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR18'],
            'value' => $sugar_config['maricopatheme']['color-18'],
            'default' => '#757083',],


        [
            'name' => 'color-14',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR14'],
            'value' => $sugar_config['maricopatheme']['color-14'],
            'default' => '#677785',],

        [
            'name' => 'color-13',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR13'],
            'value' => $sugar_config['maricopatheme']['color-13'],
            'default' => '#2D2926',],

        [
            'name' => 'action-tab-separator',
            'label' => $mod_strings['LBL_MARICOPATHEME_ACTION_SEPARATOR'],
            'value' => $sugar_config['maricopatheme']['action-tab-separator'],
            'default' => '#FA988D',],


        [
            'name' => 'color-79',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR79'],
            'value' => $sugar_config['maricopatheme']['color-79'],
            'default' => '#FCF8E3',],
        [
            'name' => 'color-36',
            'label' => $mod_strings['LBL_MARICOPATHEME_COLOR36'],
            'value' => $sugar_config['maricopatheme']['color-36'],
            'default' => '#ABC3D7',],
        [
            'name' => 'table-focus-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_TABLE_FOCUS_BG'],
            'value' => $sugar_config['maricopatheme']['table-focus-bg'],
            'default' => '#FAF7CF',],
        [
            'name' => 'mccd-custom-icon-color',
            'label' => $mod_strings['LBL_MARICOPATHEME_CUSTOM_ICON_COLOR'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-icon-color'],
            'default' => '#F08377',],

        [
            'name' => 'additional-info-header',
            'label' => $mod_strings['LBL_MARICOPATHEME_ADDITIONAL_INFO_HEADER'],
            'value' => $sugar_config['maricopatheme']['additional-info-header'],
            'default' => '#F5F5F5',],
        [
            'name' => 'mccd-custom-additional-info-link',
            'label' => $mod_strings['LBL_MARICOPATHEME_ADDITIONAL_INFO_LINK'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-additional-info-link'],
            'default' => '#F08377',],

        [
            'name' => 'scroll-bar-thumb-color',
            'label' => $mod_strings['LBL_MARICOPATHEME_SCROLLBAR_THUMB'],
            'value' => $sugar_config['maricopatheme']['scroll-bar-thumb-color'],
            'default' => '#a5e8d6',],
        [
            'name' => 'mccd-custom-dropdown-arrow-color',
            'label' => $mod_strings['LBL_MARICOPATHEME_DROPDOWN_ARROW_COLOR'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-dropdown-arrow-color'],
            'default' => '#f08377',
        ],
        [
            'name' => 'mccd-custom-search-icon',
            'label' => $mod_strings['LBL_MARICOPATHEME_SEARCH_ICON_COLOR'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-search-icon'],
            'default' => '#ffffff',
        ],
        [
            'name' => 'mccd-custom-case-card-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_CARD_BG'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-case-card-bg'],
            'default' => '#f08377',
        ],
        [
            'name' => 'mccd-custom-case-card-bg-hover',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_CARD_BG_HOVER'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-case-card-bg-hover'],
            'default' => '#808f9c',
        ],
        [
            'name' => 'mccd-custom-case-card-header',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_CARD_HEADER'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-case-card-header'],
            'default' => '#534D64',
        ],
        [
            'name' => 'mccd-custom-case-card-sub',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_CARD_SUB'],
            'value' => $sugar_config['maricopatheme']['mccd-custom-case-card-sub'],
            'default' => '#534D64',
        ],
        [
            'name' => 'mccd-global-search-filter-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_GLOBAL_SEARCH_FILTER_BG'],
            'value' => $sugar_config['maricopatheme']['mccd-global-search-filter-bg'],
            'default' => '#F5F5F5',
        ],
        [
            'name' => 'mccd-global-search-filter-border',
            'label' => $mod_strings['LBL_MARICOPATHEME_GLOBAL_SEARCH_FILTER_BORDER'],
            'value' => $sugar_config['maricopatheme']['mccd-global-search-filter-border'],
            'default' => '#F5F5F5',
        ],
        [
            'name' => 'mccd-case-progress-bar-active-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_PROGRESS_BAR_ACTIVE_BG'],
            'value' => $sugar_config['maricopatheme']['mccd-case-progress-bar-active-bg'],
            'default' => '#808f9c',
        ],
        [
            'name' => 'mccd-case-progress-bar-active-font',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_PROGRESS_BAR_ACTIVE_FONT'],
            'value' => $sugar_config['maricopatheme']['mccd-case-progress-bar-active-font'],
            'default' => '#FFFFFF',
        ],
        [
            'name' => 'mccd-case-progress-bar-inactive-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_PROGRESS_BAR_INACTIVE_BG'],
            'value' => $sugar_config['maricopatheme']['mccd-case-progress-bar-inactive-bg'],
            'default' => '#f08377',
        ],
        [
            'name' => 'mccd-case-progress-bar-inactive-font',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_PROGRESS_BAR_INACTIVE_FONT'],
            'value' => $sugar_config['maricopatheme']['mccd-case-progress-bar-inactive-font'],
            'default' => '#FFFFFF',
        ],
        [
            'name' => 'mccd-case-progress-bar-div-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_CASE_PROGRESS_BAR_DIV_BG'],
            'value' => $sugar_config['maricopatheme']['mccd-case-progress-bar-div-bg'],
            'default' => '#F5F5F5',
        ],
        [
            'name' => 'mccd-selected-option-bg',
            'label' => $mod_strings['LBL_MARICOPATHEME_SELECTED_OPTION_BG'],
            'value' => $sugar_config['maricopatheme']['mccd-selected-option-bg'],
            'default' => '#FFFFFF',
        ],
        [
            'name' => '$mccd-selected-option',
            'label' => $mod_strings['LBL_MARICOPATHEME_SELECTED_OPTION'],
            'value' => $sugar_config['maricopatheme']['$mccd-selected-option'],
            'default' => '#0c2340',
        ],
    ];
    foreach ($colours as $k => $colour) {
        if (empty($colour['value'])) {
            $colours[$k]['value'] = $colour['default'];
        }
    }
    return $colours;
}

if (isset($_REQUEST['do']) && $_REQUEST['do'] === 'save') {
    $cfg = new Configurator();
    $cfg->allow_undefined[] = 'maricopatheme';
    $cfg->saveConfig();
    $colours = getColours();
    $failed = false;
    try {
        $compiler = new Compiler();
        $vars = [];
        foreach ($colours as $colour) {
            if (empty($colour['value'])) {
                continue;
            }
            $vars['$' . $colour['name']] = $colour['value'];
        }
        $compiler->replaceVariables($vars);

        $ret = $compiler->compileString('@import "themes/SuiteP/css/MCCD/style.scss";');
        $f = sugar_file_put_contents('themes/SuiteP/css/MCCD/style.css', $ret->getCss());
        unlink('cache/themes/SuiteP/css/MCCD/style.css');
    } catch (Exception $ex) {
        $failed = true;
        SugarApplication::appendErrorMessage("Failed to set theme: " . $ex->getMessage());
    }
    if (!$failed) {
        SugarApplication::redirect('index.php?module=Administration&action=index');
        exit();
    }
}

$sugar_smarty = new Sugar_Smarty();

$colours = getColours();

$sugar_smarty->assign('colours', $colours);
$loadingGif = SugarThemeRegistry::current()->getImage('loading.gif');
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->assign('LANGUAGES', get_languages());
$sugar_smarty->assign('JAVASCRIPT', get_set_focus_js());
$sugar_smarty->assign('config', $sugar_config);
$sugar_smarty->display('custom/modules/Administration/MaricopaTheme.tpl');
