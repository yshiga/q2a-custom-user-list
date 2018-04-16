<?php

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}

require_once CUL_DIR.'/cul-html-builder.php';

class cul_theme_main
{
    protected $context = array();

    /**
    * 名前検索のフォームと、都道府県検索フォーム
    */
    public static function control_items($theme_obj)
    {
        $html = cul_html_builder::create_control_items($theme_obj);
        $theme_obj->output($html);
    }

    public static function user_list($theme_obj)
    {
        $html = cul_html_builder::create_user_list($theme_obj);
        $theme_obj->output('<div class="users-list">');
        $theme_obj->output($html);
        $theme_obj->output('</div>');
    }
}
