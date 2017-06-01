<?php

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

class cul_html_builder
{
    const ABOUT_MAX_LENGTH = 68;

    public static function create_user_list($theme_obj)
    {
        if (count($theme_obj->content['ranking']['items']) <= 0) {
            return '<span style="font-size:18px;color:#646464;padding-left:12px;">'.qa_lang_html('main/no_active_users').'</span>';
        }
        $path = CUL_DIR . '/html/user_list.html';
        $template = file_get_contents($path);
        $html = '';
        foreach ($theme_obj->content['ranking']['items'] as $user) {
            $params = self::create_params($user);
            $html .= strtr($template, $params);
            $html .= PHP_EOL;
        }
        return $html;
    }

    public static function create_params($user)
    {
        if (mb_strlen($user['about'], 'UTF-8') > self::ABOUT_MAX_LENGTH) {
            $about = mb_substr($user['about'], 0, self::ABOUT_MAX_LENGTH - 1, 'UTF-8');
            $about .= '<a href="'.$user['url'].'">...</a>';
        } else {
            $about = $user['about'];
        }
        return array(
            '^blobid' => $user['raw']['avatarblobid'],
            '^label' => $user['label'],
            '^location' => $user['location'],
            '^points' => $user['score'],
            '^about' =>  $about,
            '^url' => $user['url'],
            '^location_label' => qa_lang_html('cul_lang/location_label'),
        );
    }

    public static function create_spinner()
    {
        $html = '<div class="ias-spinner" style="align:center;"><span class="mdl-spinner mdl-js-spinner is-active" style="height:20px;width:20px;"></span></div>';
        return $html;
    }

    public static function create_control_items($theme_obj) {
    		$path = CUL_DIR . '/html/control_items.html';
    		$html = file_get_contents($path);
				return $html;
		}
}
