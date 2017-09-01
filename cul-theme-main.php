<?php

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

require_once CUL_DIR.'/cul-html-builder.php';

class cul_theme_main
{
    protected $context = array();

    public static function main($theme_obj)
    {
        $content = $theme_obj->content;
        $theme_obj->output('<main class="mdl-layout__content">');
        $theme_obj->output('<section>');
        $theme_obj->output('<div class="qa-main'.(@$theme_obj->content['hidden'] ? ' qa-main-hidden' : '').'">');
        if($theme_obj->template !== 'login')
            $theme_obj->output(
                '<div class="mdl-grid mdl-grid--no-spacing">',
                '<div class="mdl-cell mdl-cell--12-col">'
            );
        //横幅を640pxに収める
        if($theme_obj->template !== 'question'&&$theme_obj->template !== 'login'&&$theme_obj->template !== 'register')
            $theme_obj->output('<div class="centering__width-640">');

        $theme_obj->widgets('main', 'top');

        self::control_items($theme_obj);
        self::user_list($theme_obj);

        $no_page_title_template = array('unanswered', 'user', 'users','login', 'blogs');
        if(!in_array($theme_obj->template, $no_page_title_template)) {
            $theme_obj->page_title_error();
        }

        $theme_obj->widgets('main', 'high');

        if($theme_obj->template !== 'user'){
            $theme_obj->main_parts($content);
        }

        $theme_obj->page_links();
        if($theme_obj->template !== 'question' && $theme_obj->template !== 'login') {
            $theme_obj->output('</div><!-- END centering__width-640 -->');
        }

        $theme_obj->widgets('main', 'low');
        $theme_obj->suggest_next();
        $theme_obj->widgets('main', 'bottom');

        if($theme_obj->template !== 'login') {
            $theme_obj->output(
                '</div><!-- END mdl-cell--12-col -->',
                '</div> <!-- END mdl-grid -->'
            );
        }

        $theme_obj->output('</div> <!-- END qa-main -->', '');
        $theme_obj->output('</section>');
        $theme_obj->output('</div> <!-- END mdl-layout__content -->', '');
    }

		/**
		* 名前検索のフォームと、都道府県検索フォーム
		*/
		private static function control_items($theme_obj)
		{
			$html = cul_html_builder::create_control_items($theme_obj);
			$theme_obj->output($html);
		}

    private static function user_list($theme_obj)
    {
        $html = cul_html_builder::create_user_list($theme_obj);
        $theme_obj->output('<div class="users-list">');
        $theme_obj->output($html);
        $theme_obj->output('</div>');
    }
}
