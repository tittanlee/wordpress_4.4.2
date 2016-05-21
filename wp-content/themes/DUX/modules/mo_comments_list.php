<?php
/**
 * [mo_comments_list description]
 * @param  [type] $comment [description]
 * @param  [type] $args    [description]
 * @param  [type] $depth   [description]
 * @return [type]          [description]
 */
function mo_comments_list($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
    global $commentcount,$wpdb, $post;
    if(!$commentcount) { //初始化樓層計數器
    $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
    $cnt = count($comments);//獲取主評論總數量
    $page = get_query_var('cpage');//獲取當前評論列表頁碼
    $cpp=get_option('comments_per_page');//獲取每頁評論顯示數量
    if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
      $commentcount = $cnt + 1;//如果評論只有1頁或者是最後一頁，初始值為主評論總數
    } else {
      $commentcount = $cpp * $page + 1;
    }
    }


  echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';

  //樓層
    if(!$parent_id = $comment->comment_parent) {
        echo '<span class="comt-f">'; printf('#%1$s', --$commentcount); echo '</span>';
    }


  //頭像
  echo '<div class="comt-avatar">';
  echo _get_the_avatar($user_id=$comment->user_id, $user_email=$comment->comment_author_email);
  echo '</div>';
  //內容
  echo '<div class="comt-main" id="div-comment-'.get_comment_ID().'">';
    // echo str_replace(' src=', ' data-src=', convert_smilies(get_comment_text()));
    comment_text();
    if ($comment->comment_approved == '0'){
      echo '<span class="comt-approved">待審核</span>';
    }
    echo '<div class="comt-meta"><span class="comt-author">'.get_comment_author_link().'</span>';
    echo _get_time_ago($comment->comment_date); 
    if ($comment->comment_approved !== '0'){
        $replyText = get_comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
        // echo str_replace(' href', ' href="javascript:;" data-href', $replyText ); 
        if( strstr($replyText, 'reply-login') ){
          echo preg_replace('# class="[\s\S]*?" href="[\s\S]*?"#', ' class="signin-loader" href="javascript:;"', $replyText );
        }else{
          echo preg_replace('# href=[\s\S]*? onclick=#', ' href="javascript:;" onclick=', $replyText );
        }
    }
    echo '</div>';
  echo '</div>';
}