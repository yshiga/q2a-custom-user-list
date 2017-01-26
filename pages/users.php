<?php
    if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
        header('Location: ../');
        exit;
    }

    require_once QA_INCLUDE_DIR.'db/users.php';
    require_once QA_INCLUDE_DIR.'db/selects.php';
    require_once QA_INCLUDE_DIR.'app/format.php';


//    Get list of all users

    $start = qa_get_start();
    $selectspec = qa_db_top_users_selectspec($start, qa_opt_if_loaded('page_size_users'));
    $cond_location = qa_get('location');
    $query = " ^users JOIN (SELECT userid FROM ^userpoints ORDER BY points DESC ) y ON ^users.userid=y.userid";
    $query .= " JOIN ^userpoints ON ^users.userid=^userpoints.userid";
    $query .= " LEFT JOIN ( SELECT userid, CASE WHEN title = 'about' THEN content ELSE '' END AS about";
    $query .= " FROM qa_userprofile WHERE title like 'about' ) a ON qa_users.userid = a.userid";
    $query .= " LEFT JOIN ( SELECT userid, CASE WHEN title = 'location' THEN content ELSE '' END AS location";
    $query .= " FROM qa_userprofile
    WHERE title like 'location' ) l ON qa_users.userid = l.userid";
    $selectspec['arguments'] = array();
    if (isset($cond_location)) {
        $query .= " WHERE l.location like $";
        $selectspec['arguments'][] = '%'.$cond_location.'%';
    }
    $query .= " LIMIT #,#";
    $selectspec['arguments'][] = $start;
    $selectspec['arguments'][] = qa_opt('page_size_users');
    $selectspec['columns']['about'] = 'a.about';
    $selectspec['columns']['location'] = 'l.location';
    $selectspec['source'] = $query;
    $users = qa_db_select_with_pending($selectspec);
    
    if (isset($cond_location)) {
        $usercount = page_size_location($cond_location);
    } else {
        $usercount = qa_opt('cache_userpointscount');
    }
    $pagesize = qa_opt('page_size_users');
    
    
    $users = array_slice($users, 0, $pagesize);
    $usershtml = qa_userids_handles_html($users);


//    Prepare content for theme

    $qa_content = qa_content_prepare();

    if (isset($cond_location)) {
      $location_name = get_location($cond_location);
      $qa_content['title'] = strtr(qa_lang_html('cul_lang/location_title'), array('^1' => $location_name));
      $qa_content['description'] = get_description($location_name);
    } else {
      $qa_content['title'] = qa_lang_html('main/highest_users');
    }

    $qa_content['ranking'] = array(
        'items' => array(),
        'rows' => ceil($pagesize/qa_opt('columns_users')),
        'type' => 'users'
    );
    
    if (count($users)) {
        foreach ($users as $userid => $user) {
            if (QA_FINAL_EXTERNAL_USERS)
                $avatarhtml = qa_get_external_avatar_html($user['userid'], qa_opt('avatar_users_size'), true);
            else {
                $avatarhtml = qa_get_user_avatar_html($user['flags'], $user['email'], $user['handle'],
                    $user['avatarblobid'], $user['avatarwidth'], $user['avatarheight'], qa_opt('avatar_users_size'), true);
            }

            // avatar and handle now listed separately for use in themes
            $qa_content['ranking']['items'][] = array(
                'avatar' => $avatarhtml,
                'label' => $usershtml[$user['userid']],
                'url' => qa_path_html('user/'.$user['handle']),
                'score' => qa_html(number_format($user['points'])),
                'about' => $user['about'],
                'location' => $user['location'],
                'raw' => $user,
            );
        }
    }
    else
        $qa_content['title'] = qa_lang_html('main/no_active_users');

    if (isset($cond_location)) {
        $options = array('location' => $cond_location);
        $qa_content['page_links'] = qa_html_page_links(qa_request(), $start, $pagesize, $usercount, qa_opt('pages_prev_next'), $options);
    } else {
        $qa_content['page_links'] = qa_html_page_links(qa_request(), $start, $pagesize, $usercount, qa_opt('pages_prev_next'));
    }
    $qa_content['navigation']['sub'] = qa_users_sub_navigation();

    return $qa_content;


function page_size_location($location) {
    $sql = "SELECT count(*)";
    $sql .= " FROM ^users";
    $sql .= " LEFT JOIN ( SELECT userid, CASE WHEN title = 'location' THEN content ELSE '' END AS location";
    $sql .= " FROM ^userprofile WHERE title like 'location' ) l ON ^users.userid = l.userid";
    $sql .= " WHERE l.location like $";
    return qa_db_read_one_value(qa_db_query_sub($sql, '%'.$location.'%'), true);
}

function get_location($location)
{
    $name = '';
    if ($location === '北海道') {
        $name = $location;
    } elseif ($location === '東京都') {
        $name = $location;
    } elseif ($location === '京都' || $location === '大阪') {
        $name = $location . '府';
    } else {
        $name = $location . '県';
    }
    return $name;
    
}

function get_description($location)
{
    $desc = strtr(qa_lang('cul_lang/location_description'), array('^1' => $location));
    return $desc;
}

/*
    Omit PHP closing tag to help avoid accidental output
*/
