<?php

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}

class cul_html_builder
{
    const ABOUT_MAX_LENGTH = 68;
    const ABOUT_MAX_LENGTH_MOBILE = 36;

    public static function create_user_list($theme_obj)
    {
        if (count($theme_obj->content['ranking']['items']) <= 0) {
            return '<span style="font-size:18px;color:#646464;padding-left:12px;">'.qa_lang_html('main/no_active_users').'</span>';
        }
        $path = CUL_DIR . '/html/user_list.html';
        $template = file_get_contents($path);
        $html = '<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">';
        $html.= '<div class="mdl-list qa-users-list">';
        foreach ($theme_obj->content['ranking']['items'] as $user) {
            $params = self::create_params($user);
            $html .= strtr($template, $params);
            $html .= PHP_EOL;
        }
        $html.= '</div>';
        $html.= '</div>';
        return $html;
    }

    public static function create_params($user)
    {
        if (qa_is_mobile_probably()) {
            $maxlength = self::ABOUT_MAX_LENGTH_MOBILE;
        } else {
            $maxlength = self::ABOUT_MAX_LENGTH;
        }
        if (mb_strlen($user['about'], 'UTF-8') > $maxlength) {
            $about = mb_substr($user['about'], 0, $maxlength - 1, 'UTF-8');
            $about .= '...';
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

    public static function create_control_items($theme_obj) {
        $path = CUL_DIR . '/html/control_items.html';
        $html = file_get_contents($path);
        return $html;
    }
}
