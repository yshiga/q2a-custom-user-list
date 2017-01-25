<?php

require_once CUL_DIR.'/cul-theme-main.php';

class qa_html_theme_layer extends qa_html_theme_base
{
    private $infscr = null;
    
    function qa_html_theme_layer($template, $content, $rooturl, $request)
    {
        qa_html_theme_base::qa_html_theme_base($template, $content, $rooturl, $request);
        $this->infscr = new qa_infinite_scroll();
    }
    
    function body_footer()
    {
        qa_html_theme_base::body_footer();
        if (qa_opt('site_theme') === CUL_TARGET_THEME_NAME && $this->template === 'users') {
            $this->output('<SCRIPT TYPE="text/javascript" SRC="'.$this->infscr->pluginjsurl.'jquery-ias.min.js"></SCRIPT>');
            // $this->output('<SCRIPT TYPE="text/javascript">var action = "'.$action.'";</SCRIPT>');
            $this->output('<SCRIPT TYPE="text/javascript" SRC="'. QA_HTML_THEME_LAYER_URLTOROOT.'js/ias-users.js"></SCRIPT>');
            
            $cond_location = qa_get('location');
            $this->output('<SCRIPT>',' var cond_location = "'.$cond_location.'";','</SCRIPT>');
            $this->output('<SCRIPT TYPE="text/javascript" SRC="'. QA_HTML_THEME_LAYER_URLTOROOT.'js/custom-user-list.js"></SCRIPT>');
        }
    }

    function head_css()
    {
        qa_html_theme_base::head_css();
        if (qa_opt('site_theme') === CUL_TARGET_THEME_NAME && $this->template === 'users') {
            $this->output('<LINK REL="stylesheet" TYPE="text/css" HREF="'.$this->infscr->plugincssurl.'jquery.ias.css"/>');
        }
    }
    
    public function main()
    {
        if (qa_opt('site_theme') === CUL_TARGET_THEME_NAME && $this->template === 'users') {
            cul_theme_main::main($this);
        } else {
            qa_html_theme_base::main();
        }
    }
    
}
