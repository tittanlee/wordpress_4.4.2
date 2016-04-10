<?php
/*
 * 以下內容由君子不器添加，每段代碼的作用都已經寫了註釋，為了省事就懶得加入後台選項面板了。你可以按照自己的需要來修改
 * 若是在使用過程中遇到問題，歡迎前往君子不器的網站http://www.weiton.net留言或者直接聯繫君子不器獲取幫助。
 *
 * 2015年11月17日 14:45:21 修復內容如下
 * 修復因為疏忽導致的點贊於拍磚中點贊不計數問題
 * 
 * 2015年11月17日 12:48:03 修復內容如下
 * 修復點贊拍磚時出現的alert提示框
 * 修復縮略圖導致會員中心文章列表加載錯誤的問題
 * 修復小工具帶縮略圖時顯示錯位的問題
 * 修復無限加載文章後導致縮略圖不顯示的問題
 * 順便說明一下主題下載，演示等簡碼使用方式，假設需要一個主題演示，那麼就輸入簡碼如[demo]這是主題演示站點[/demo]，然後在文章下方輸入一個自定義字段demo，裡面的值就填入你需要演示的網址即可。
 * 其他如下載頁面簡碼的使用方式可以到我網站http://www.weiton.net搜索  獨立下載頁面  那篇文章中君子不器就介紹過
 
 * 若是使用中碰到bug或者有什麼其他疑問歡迎加入君子不器的QQ群：479928584和大家一起交流
*/

require get_stylesheet_directory() . '/inc/fn.php';

//設置AJAS評論的字數限制
function set_comments_length($commentdata) {
    $minCommentlength = 3;      //最少字數限制
    $maxCommentlength = 200;   //最多字數限制
    $pointCommentlength = mb_strlen($commentdata['comment_content'],'UTF8');    //mb_strlen 一個中文字符當做一個長度
    if ($pointCommentlength < $minCommentlength){
        err('抱歉，您評論的字數過少，請至少輸入' . $minCommentlength .'個字（目前字數：'. $pointCommentlength .'個字）');
        exit;
    }
    if ($pointCommentlength > $maxCommentlength){
        err('抱歉，您評論的字數過多，請輸入少於' . $maxCommentlength .'個字的評論（您目前輸入了：'. $pointCommentlength .'個字）');
        exit;
    }
    return $commentdata;
}
add_filter('preprocess_comment', 'set_comments_length');

#圖片鏈接修改

function auto_post_link($content) {
	global $post;
        $content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', "<a class=\"dengxiang\" href=\"javascript:;\" data-scr=\"$2\"title=\"".$post->post_title."\" ><img src=\"$2\" alt=\"".$post->post_title."\" /></a>", $content);
	return $content;
}
add_filter ('the_content', 'auto_post_link',0);

#去除摘要的[...]
function junzibuqi_com_more() {
    return '';
}
add_filter('excerpt_more', 'junzibuqi_com_more');
#為摘要添加繼續閱讀
function junzibuqi_com_more_link($output) {
    if (!is_attachment()) {
        if (!has_excerpt()) {
            $output = mb_strimwidth($output, 0, 300);
        }
        $output .= '</p><a href="' . esc_url(get_permalink()) . '" class="gengduo">' . ' &rarr;[ 閱讀全文 ] &larr; </a>';
    }
    return $output;
}
add_filter('get_the_excerpt', 'junzibuqi_com_more_link');

//搜索結果只有一個時直接跳轉到文章
add_action('template_redirect', 'redirect_single_post');
function redirect_single_post() {
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1) {
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
            exit;
        }
    }
}

//壓縮時繞過代碼塊
function unCompress($content) {
    if(preg_match_all('/(crayon-|<\/pre>)/i', $content, $matches)) {
        $content = '<!--wp-compress-html--><!--wp-compress-html no compression-->'.$content;
        $content.= '<!--wp-compress-html no compression--><!--wp-compress-html-->';
    }
    return $content;
}
add_filter( "the_content", "unCompress");
//壓縮html代碼 
function wp_compress_html(){
    function wp_compress_html_main ($buffer){
        $initial=strlen($buffer);
        $buffer=explode("<!--wp-compress-html-->", $buffer);
        $count=count ($buffer);
        for ($i = 0; $i <= $count; $i++){
            if (stristr($buffer[$i], '<!--wp-compress-html no compression-->')) {
                $buffer[$i]=(str_replace("<!--wp-compress-html no compression-->", " ", $buffer[$i]));
            } else {
                $buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
                $buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
                $buffer[$i]=(str_replace("\n", "", $buffer[$i]));
                $buffer[$i]=(str_replace("\r", "", $buffer[$i]));
                while (stristr($buffer[$i], '  ')) {
                    $buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
                }
            }
            $buffer_out.=$buffer[$i];
        }
        $final=strlen($buffer_out);   
        $savings=($initial-$final)/$initial*100;   
        $savings=round($savings, 2);   
        $buffer_out.="\n<!--壓縮前的大小: $initial bytes; 壓縮後的大小: $final bytes; 節約：$savings% -->";   
    return $buffer_out;
}
ob_start("wp_compress_html_main");
}
add_action('get_header', 'wp_compress_html');
//百度實時推送
 /*
function mee_post_baidu($post_id,$post){
	$PostUrl = get_permalink($post_id);
	$urls=array($PostUrl);
	$api = 'http://data.zz.baidu.com/urls?site=www.yndali.com&token=p6PDgaynVOaw2o4H&type=original';//請輸入你站長平台的主動推送api
	$ch = curl_init();//主機需要支持curl
	$options = array(
				CURLOPT_URL => $api,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => implode("\n", $urls),
				CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
			);
	curl_setopt_array($ch, $options);
	curl_exec($ch);
}
add_action('publish_post', 'mee_post_baidu');
 */
// Customize your functions
//評論分頁的seo處理
function canonical_for_junke() {
        global $cpage, $post;
        if ( $cpage > 1 ) :
                echo "\n";
                echo "<link rel='canonical' href='";
                echo get_permalink( $post->ID );
                echo "' />\n";
                echo "<meta name=\"robots\" content=\"noindex,follow\">";
         endif;
}
add_action( 'wp_head', 'canonical_for_junke' );
//支持中文名註冊，
function junzibuqi_com_zwuser ($username, $raw_username, $strict) {
  $username = wp_strip_all_tags( $raw_username );
  $username = remove_accents( $username );
  $username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
  $username = preg_replace( '/&.+?;/', '', $username ); // Kill entities
  if ($strict) {
    $username = preg_replace ('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $username);
  }
  $username = trim( $username );
  $username = preg_replace( '|\s+|', ' ', $username );
  return $username;
}
add_filter ('sanitize_user', 'junzibuqi_com_zwuser', 10, 3);

//取消後台登陸錯誤的提示
function git_wps_login_error() {
        remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'git_wps_login_error');
//百度收錄提示
function baidu_check($url) {
    global $wpdb;
    $post_id = (null === $post_id) ? get_the_ID() : $post_id;
    $baidu_record = get_post_meta($post_id, 'baidu_record', true);
    if ($baidu_record != 1) {
        $url = 'http://www.baidu.com/s?wd=' . $url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $rs = curl_exec($curl);
        curl_close($curl);
        if (!strpos($rs, '沒有找到')) {
            if ($baidu_record == 0) {
                update_post_meta($post_id, 'baidu_record', 1);
            } else {
                add_post_meta($post_id, 'baidu_record', 1, true);
            }
            return 1;
        } else {
            if ($baidu_record == false) {
                add_post_meta($post_id, 'baidu_record', 0, true);
            }
            return 0;
        }
    } else {
        return 1;
    }
}
function baidu_record() {

   if (baidu_check(get_permalink()) == 1) {
        echo '<a target="_blank" title="點擊查看" rel="external nofollow" href="http://www.baidu.com/s?wd=' . get_the_title() . '"><i class="fa fa-flag"></i>百度已收錄</a>';
    } else {
        echo '<a rel="external nofollow" title="幫忙點擊提交下，謝謝！" target="_blank" href="http://zhanzhang.baidu.com/linksubmit/url?sitename=' . get_permalink() . '"><i class="fa fa-flag"></i>百度抽風了</a>';
    }
}
//中文文件重命名
function git_upload_filter($file) {
    $time = date("YmdHis");
    $file['name'] = $time . "" . mt_rand(1, 100) . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'git_upload_filter');

//屏蔽暱稱，評論內容帶鏈接的評論
function Googlolink($comment_data) {
    $links = '/http:\/\/|https:\/\/|www\./u';
    if (preg_match($links, $comment_data['comment_author']) || preg_match($links, $comment_data['comment_content'])) {
        err(__('在暱稱和評論裡面是不准發鏈接滴.'));
    }
    return ($comment_data);
}
add_filter('preprocess_comment', 'Googlolink');

//WordPress文字標籤關鍵詞自動內鏈
$match_num_from = 1; 
$match_num_to = 6; 
function tag_sort($a, $b) {
    if ($a->name == $b->name) return 0;
    return (strlen($a->name) > strlen($b->name)) ? -1 : 1;
}
function tag_link($content) {
    global $match_num_from, $match_num_to;
    $posttags = get_the_tags();
    if ($posttags) {
        usort($posttags, "tag_sort");
        foreach ($posttags as $tag) {
            $link = get_tag_link($tag->term_id);
            $keyword = $tag->name;
            $cleankeyword = stripslashes($keyword);
            $url = "<a href=\"$link\" title=\"" . str_replace('%s', addcslashes($cleankeyword, '$') , __('查看更多關於%s的文章')) . "\"";
            $url.= ' target="_blank"';
            $url.= ">" . addcslashes($cleankeyword, '$') . "</a>";
            $limit = rand($match_num_from, $match_num_to);
            $content = preg_replace('|(<a[^>]+>)(.*)(' . $ex_word . ')(.*)(</a[^>]*>)|U' . $case, '$1$2%&&&&&%$4$5', $content);
            $content = preg_replace('|(<img)(.*?)(' . $ex_word . ')(.*?)(>)|U' . $case, '$1$2%&&&&&%$4$5', $content);
            $cleankeyword = preg_quote($cleankeyword, '\'');
            $regEx = '\'(?!((<.*?)|(<a.*?)))(' . $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
            $content = preg_replace($regEx, $url, $content, $limit);
            $content = str_replace('%&&&&&%', stripslashes($ex_word) , $content);
        }
    }
    return $content;
}
add_filter('the_content', 'tag_link', 1);
/*相關圖片文章圖片調取*/
add_theme_support( 'post-thumbnails' );
 
function catch_that_image() {
global $post, $posts;
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
$first_img = $matches [1] [0];
if(empty($first_img)){
$popimg= get_stylesheet_directory_uri() . '/img/thumbnail.png';
$first_img = "$popimg";
}
return $first_img;
}
 
function mmimg($postID) {
 $cti = catch_that_image();
 $showimg = $cti;
 has_post_thumbnail();
 if ( has_post_thumbnail() ) { 
 $thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
 $shareimg = $thumbnail_image_url[0];
 } else { 
 $shareimg = $showimg;
 };
 return $shareimg;
} 
/*相關圖片文章圖片調取end*/
add_filter('pre_option_link_manager_enabled','__return_true');
/*輸出縮略圖*/
function _get_post_thumbnail() {
	global $post;
  $thumbnail_path = "wp-content/img/$post->ID/thumb.jpg";

  if ( file_exists($thumbnail_path)) {
       echo '<img data-src="/wp/'.$thumbnail_path.'" class="thumb">';
      //echo '<img data-src= "/wp/wp-content/img/'.$post->ID.'/thumb.jpg" class="thumb">';
  } else {
      //如果文章沒有圖片則讀取默認圖片
      echo '<img data-src="' . get_stylesheet_directory_uri() . '"/img/thumbnail.png" class="thumb">';
  }
	/*
	global $post;
	if (has_post_thumbnail ()) {
		//如果存在縮略圖
		$domsxe = simplexml_load_string ( get_the_post_thumbnail () );
		$thumbnailsrc = $domsxe->attributes()->src;
		echo '<img data-src="' . $thumbnailsrc . '" class="thumb">';
	} else {
		//讀取第一張圖片
		$content = $post->post_content;
		preg_match_all ( '/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER );
		$n = count ( $strResult [1] );
		if ($n > 0) {
			//文章第一張圖片
			echo '<img data-src="' . $strResult [1] [0] . '" class="thumb">';
		} else {
			//如果文章沒有圖片則讀取默認圖片
			echo '<img data-src="' . get_stylesheet_directory_uri() . '"/img/thumbnail.png" class="thumb">';
		}
	} */
}

function post_thumbnail( $width = 100,$height = 80 ){
    global $post;
    if( has_post_thumbnail() ){    //如果有縮略圖，則顯示縮略圖
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
        $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb.php?src='.$timthumb_src[0].'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1" alt="'.$post->post_title.'" class="thumb" />';
        echo $post_timthumb;
    } else {
        $post_timthumb = '';
        ob_start();
        ob_end_clean();
        $output = preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $index_matches);    //獲取日誌中第一張圖片
        $first_img_src = $index_matches [1];    //獲取該圖片 src
        if( !empty($first_img_src) ){    //如果日誌中有圖片
            $path_parts = pathinfo($first_img_src);    //獲取圖片 src 信息
            $first_img_name = $path_parts["basename"];    //獲取圖片名
            $first_img_pic = get_bloginfo('wpurl'). '/cache/'.$first_img_name;    //文件所在地址
            $first_img_file = ABSPATH. 'cache/'.$first_img_name;    //保存地址
            $expired = 604800;    //過期時間
            if ( !is_file($first_img_file) || (time() - filemtime($first_img_file)) > $expired ){
                copy($first_img_src, $first_img_file);    //遠程獲取圖片保存於本地
                $post_timthumb = '<img src="'.$first_img_src.'" alt="'.$post->post_title.'" class="thumb" />';    //保存時用原圖顯示
            }
            $post_timthumb = '<img src="'.get_bloginfo("template_url").'/timthumb.php?src='.$first_img_pic.'&amp;h='.$height.'&amp;w='.$width.'&amp;zc=1" alt="'.$post->post_title.'" class="thumb" />';
        } else {    //如果日誌中沒有圖片，則顯示默認
            $post_timthumb = '<img src="'.get_bloginfo("template_url").'/images/default_thumb.gif" alt="'.$post->post_title.'" class="thumb" />';
        }
        echo $post_timthumb;
    }
}

//拍磚
add_action('wp_ajax_nopriv_junke_pz', 'junke_pz');
add_action('wp_ajax_junke_pz', 'junke_pz');
function junke_pz() {
    global $wpdb, $post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ($action == 'cai') {
        $bigfa_raters = get_post_meta($id, 'junke_cai', true);
        $expire = time() + 3600;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie('junke_cai_' . $id, $id, $expire, '/', $domain, false);
        if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
            update_post_meta($id, 'junke_cai', 1);
        } else {
            update_post_meta($id, 'junke_cai', ($bigfa_raters + 1));
        }
        echo get_post_meta($id, 'junke_cai', true);
    }
    die;
}
//點贊
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like() {
    global $wpdb, $post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ($action == 'ding') {
        $bigfa_raters = get_post_meta($id, 'bigfa_ding', true);
        $expire = time() + 3600;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; 
        setcookie('bigfa_ding_' . $id, $id, $expire, '/', $domain, false);
        if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
            update_post_meta($id, 'bigfa_ding', 1);
        } else {
            update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
        }
        echo get_post_meta($id, 'bigfa_ding', true);
    }
    die;
}

function orwei_ds_alipay_wechat(){ //注意更換為你的支付寶或微信收款二維碼，二維碼獲取請自行百度
 echo '<section class="to-tip"><div class="inner"><div class="top-tip-shap"><a>賞<span class="code"><img alt="支付寶打賞" src="/wp-content/themes/Junzibuqi_Com/img/weixin.jpg"><b>支付寶 掃一掃</b></span></a></div></div></section>';
}
