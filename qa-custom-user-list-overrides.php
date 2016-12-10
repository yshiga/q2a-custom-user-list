<?php

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

function qa_page_routing()
{
    $routing = qa_page_routing_base();
    if (qa_opt('site_theme') === CUL_TARGET_THEME_NAME) {
        $routing['users'] = CUL_RELATIVE_PATH . 'pages/users.php';
    }
    return $routing;
}
