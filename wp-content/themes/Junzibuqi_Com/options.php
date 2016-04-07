<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {

	// Change this to use your theme slug
	return 'Junzibuqi_Com';
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'options_framework_theme'),
		'two' => __('Two', 'options_framework_theme'),
		'three' => __('Three', 'options_framework_theme'),
		'four' => __('Four', 'options_framework_theme'),
		'five' => __('Five', 'options_framework_theme')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_framework_theme'),
		'two' => __('Pancake', 'options_framework_theme'),
		'three' => __('Omelette', 'options_framework_theme'),
		'four' => __('Crepe', 'options_framework_theme'),
		'five' => __('Waffle', 'options_framework_theme')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	// $options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	$options_linkcats = array();
	$options_linkcats_obj = get_terms('link_category');
	foreach ( $options_linkcats_obj as $tag ) {
		$options_linkcats[$tag->term_id] = $tag->name;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	$adsdesc =  __('可添加任意廣告聯盟代碼或自定義代碼', 'haoui');

	$options = array();

	// ======================================================================================================================
	$options[] = array(
		'name' => __('基本設置', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Logo', 'haoui'),
		'id' => 'logo_src',
		'desc' => __('Logo不會做？微通網絡（weiton.net）留言求助！Logo 最大高：32px；建議尺寸：140*32px 格式：png', 'haoui'),
		'std' => 'http://www.daqianduan.com/wp-content/uploads/2015/01/logo.png',
		'type' => 'upload');

	$options[] = array(
		'name' => __('佈局', 'haoui'),
		'id' => 'layout',
		'std' => "2",
		'type' => "radio",
		'desc' => __("2種佈局供選擇，點擊選擇你喜歡的佈局方式，保存後前端展示會有所改變。", 'haoui'),
		'options' => array(
			'2' => __('有側邊欄', 'haoui'),
			'1' => __('無側邊欄', 'haoui')
		));

	$options[] = array(
		'name' => __("主題風格", 'haoui'),
		'desc' => __("14種顏色供選擇，點擊選擇你喜歡的顏色，保存後前端展示會有所改變。", 'haoui'),
		'id' => "theme_skin",
		'std' => "45B6F7",
		'type' => "colorradio",
		'options' => array(
			'45B6F7' => 100,
			'FF5E52' => 1,
			'2CDB87' => 2,
			'00D6AC' => 3,
			'16C0F8' => 4,
			'EA84FF' => 5,
			'FDAC5F' => 6,
			'FD77B2' => 7,
			'76BDFF' => 8,
			'C38CFF' => 9,
			'FF926F' => 10,
			'8AC78F' => 11,
			'C7C183' => 12,
			'555555' => 13
		)
	);

	$options[] = array(
		'id' => 'theme_skin_custom',
		'std' => "",
		'desc' => __('不喜歡上面提供的顏色，你好可以在這裡自定義設置，如果不用自定義顏色清空即可（默認不用自定義）', 'haoui'),
		'type' => "color");

	$options[] = array(
		'name' => __('全站連接符', 'haoui'),
		'id' => 'connector',
		'desc' => __('一經選擇，切勿更改，對SEO不友好，一般為「-」或「_」', 'haoui'),
		'std' => _hui('connector') ? _hui('connector') : '-',
		'type' => 'text',
		'class' => 'mini');

	$options[] = array(
		'name' => __('網頁最大寬度', 'haoui'),
		'id' => 'site_width',
		'std' => 1200,
		'class' => 'mini',
		'desc' => __('默認：1200，單位：px（像素）', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('jQuery底部加載', 'haoui'),
		'id' => 'jquery_bom',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__('（可提高頁面內容加載速度，但部分依賴jQuery的插件可能失效）', 'haoui'));


	$options[] = array(
		'name' => __('Gravatar 頭像獲取', 'haoui'),
		'id' => 'gravatar_url',
		'std' => "ssl",
		'type' => "radio",
		'options' => array(
			'no' => __('原有方式', 'haoui'),
			'ssl' => __('從Gravatar官方ssl獲取', 'haoui'),
			'duoshuo' => __('從多說服務器獲取', 'haoui')
		));

	$options[] = array(
		'name' => __('JS文件托管（可大幅提速JS加載）', 'haoui'),
		'id' => 'js_outlink',
		'std' => "no",
		'type' => "radio",
		'options' => array(
			'no' => __('不托管', 'haoui'),
			'baidu' => __('百度', 'haoui'),
			'360' => __('360', 'haoui'),
			'he' => __('框架來源站點（分別引入jquery和bootstrap官方站點JS文件）', 'haoui')
		));

	$options[] = array(
		'name' => __('網站整體變灰', 'haoui'),
		'id' => 'site_gray',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__('（支持IE、Chrome，基本上覆蓋了大部分用戶，不會降低訪問速度）', 'haoui'));

	$options[] = array(
		'name' => __('分類url去除category字樣', 'haoui'),
		'id' => 'no_categoty',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__('（主題已內置no-category插件功能，請不要安裝插件；開啟後請去設置-固定連接中點擊保存即可）', 'haoui'));

	$options[] = array(
		'name' => __('品牌文字', 'haoui'),
		'id' => 'brand',
		'std' => "君子不器（Junzibuqi.Com），\n萬事不求人，做最全面的自己",
		'desc' => __('顯示在Logo旁邊的兩個短文字，請換行填寫兩句文字（短文字介紹）', 'haoui'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首頁關鍵字(keywords)', 'haoui'),
		'id' => 'keywords',
		'std' => '設置你的關鍵詞',
		'desc' => __('關鍵字有利於SEO優化，建議個數在5-10之間，用英文逗號隔開', 'haoui'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首頁描述(description)', 'haoui'),
		'id' => 'description',
		'std' => __('設置你網站描述！', 'haoui'),
		'desc' => __('描述有利於SEO優化，建議字數在30-70之間', 'haoui'),
		'settings' => array(
			'rows' => 3
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('網站底部信息', 'haoui'),
		'id' => 'footer_seo',
		'std' => '<a href="'.site_url('/sitemap.xml').'">'.__('網站地圖', 'haoui').'</a> DOBEE01 多樣化新聞發佈中心！'."\n",
		'desc' => __('備案號可寫於此，網站地圖可自行使用sitemap插件自動生成', 'haoui'),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('百度自定義站內搜索', 'haoui'),
		'id' => 'search_baidu',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'id' => 'search_baidu_code',
		'std' => '',
		'desc' => __('此處存放百度自定義站內搜索代碼，請自行去 http://zn.baidu.com/ 設置並獲取', 'haoui'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('PC端滾動時導航固定', 'haoui').'  (v1.3+)',
		'id' => 'nav_fixed',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__('由於網址導航左側菜單的固定，故對網址導航頁面無效', 'haoui'));

	$options[] = array(
		'name' => __('新窗口打開文章', 'haoui'),
		'id' => 'target_blank',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'name' => __('首頁不顯示該分類下文章', 'haoui'),
		'id' => 'notinhome',
		'options' => $options_categories,
		'type' => 'multicheck');

	$options[] = array(
		'name' => __('首頁不顯示以下ID的文章', 'haoui'),
		'id' => 'notinhome_post',
		'std' => "11245\n12846",
		'desc' => __('每行填寫一個文章ID', 'haoui'),
		'settings' => array(
			'rows' => 2
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('分頁無限加載頁數', 'haoui'),
		'id' => 'ajaxpager',
		'std' => 5,
		'class' => 'mini',
		'desc' => __('為0時表示不開啟該功能', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('列表模式', 'haoui'),
		'id' => 'list_type',
		'std' => "thumb",
		'type' => "radio",
		'options' => array(
			'thumb' => __('圖文（縮略圖尺寸：220*150px，默認已自動裁剪）', 'haoui'),
			'text' => __('文字 ', 'haoui')
		));

	$options[] = array(
		'id' => 'list_thumb_out',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('縮略圖使用外鏈圖片 （外鏈是沒有縮略圖的，所以不會是小圖，浩子不建議外鏈圖，但如果你的文章都是外鏈圖片，這個可以幫你實現以上的列表模式） ', 'haoui'));

	$options[] = array(
		'name' => __('文章小部件開啟', 'haoui'),
		'id' => 'post_plugin',
		'std' => array(
			'view' => 1,
			'comm' => 1,
			'date' => 1,
			'author' => 1,
			'cat' => 1
		),
		'type' => "multicheck",
		'options' => array(
			'view' => __('閱讀量（無需安裝插件）', 'haoui'),
			'comm' => __('列表評論數', 'haoui'),
			'date' => __('列表時間', 'haoui'),
			'author' => __('列表作者名', 'haoui'),
			'cat' => __('列表分類鏈接', 'haoui').'  (v1.3+)'
		));

	$options[] = array(
		'name' => __('文章作者名加鏈接', 'haoui'),
		'id' => 'author_link',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__('（列表和文章有作者的地方都會加上鏈接） ', 'haoui'));


	
/*
	$options[] = array(
		'name' => __('評論數只顯示人為評論數量', 'haoui'),
		'id' => 'comment_number_remove_trackback',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__('（部分文章有trackback導致評論數的增加，這個可以過濾掉） ', 'haoui'));
*/

	// ======================================================================================================================
	$options[] = array(
		'name' => __('文章頁', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('相關文章', 'haoui'),
		'id' => 'post_related_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'desc' => __('相關文章標題', 'haoui'),
		'id' => 'related_title',
		'std' => __('相關推薦', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'desc' => __('相關文章顯示數量', 'haoui'),
		'id' => 'post_related_n',
		'std' => 8,
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('文章來源', 'haoui'),
		'id' => 'post_from_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('開啟', 'haoui'));
	
	$options[] = array(
		'id' => 'post_from_h1',
		'std' => __('來源：', 'haoui'),
		'desc' => __('來源顯示字樣', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'id' => 'post_from_link_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('來源加鏈接', 'haoui'));

	$options[] = array(
		'name' => __('內容段落縮進', 'haoui').' (v1.3+)',
		'id' => 'post_p_indent_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__(' 開啟後只對前台文章展示有效，對後台編輯器中的格式無效', 'haoui'));

	$options[] = array(
		'name' => __('文章段落縮進', 'haoui'),
		'id' => 'post_p_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'name' => __('文章頁尾版權提示', 'haoui'),
		'id' => 'post_copyright_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'name' => __('文章頁尾版權提示前綴', 'haoui'),
		'id' => 'post_copyright',
		'std' => __('未經微通網絡（weiton.net）允許，不得轉載本站任何文章：', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('自動添加關鍵字和描述', 'haoui'),
		'id' => 'site_keywords_description_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('開啟', 'haoui').__('（開啟後所有頁面將自動使用主題配置的關鍵字和描述，具體規則可以自行查看頁面源碼得知）', 'haoui'));

	$options[] = array(
		'name' => __('文章關鍵字和描述自定義', 'haoui'),
		'id' => 'post_keywords_description_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui').__('（開啟後你需要在編輯文章的時候書寫關鍵字和描述，如果為空，將自動使用主題配置的關鍵字和描述；開啟這個必須開啟上面的「自動添加關鍵字和描述」）', 'haoui'));



	// ======================================================================================================================
	$options[] = array(
		'name' => __('網址導航', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('網址導航標題下描述', 'haoui'),
		'id' => 'navpage_desc',
		'std' => '這裡顯示的是網址導航的一句話描述...',
		'type' => 'text');

	$options[] = array(
		'name' => __('選擇鏈接分類到網址導航', 'haoui'),
		'id' => 'navpage_cats',
		'options' => $options_linkcats,
		'type' => 'multicheck');


	// ======================================================================================================================
	$options[] = array(
		'name' => __('會員中心', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'id' => 'user_page_s',
		'std' => true,
		'desc' => __('開啟會員中心', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'user_on_notice_s',
		'std' => true,
		'desc' => __('在首頁公告欄顯示會員模塊', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('選擇會員中心頁面', 'haoui'),
		'id' => 'user_page',
		'desc' => '如果沒有合適的頁面作為會員中心，你需要去新建一個頁面再來選擇',
		'options' => $options_pages,
		'type' => 'select');

	$options[] = array(
		'name' => __('選擇找回密碼頁面', 'haoui'),
		'id' => 'user_rp',
		'desc' => '如果沒有合適的頁面作為找回密碼頁面，你需要去新建一個頁面再來選擇',
		'options' => $options_pages,
		'type' => 'select');

	$options[] = array(
		'name' => __('有新投稿郵件通知', 'haoui').' (v1.3+)',
		'id' => 'tougao_mail_send',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'desc' => __('投稿通知接收郵箱', 'haoui').' (v1.3+)',
		'id' => 'tougao_mail_to',
		'type' => 'text');
 
	$options[] = array(
		'name' => __('禁止暱稱關鍵字', 'haoui'),
		'desc' => __('一行一個關鍵字，用戶暱稱將不能使用或包含這些關鍵字，對編輯以下職位有效', 'haoui'),
		'id' => 'user_nickname_out',
		'std' => "賭博\n博彩\n彩票\n性愛\n色情\n做愛\n愛愛\n淫穢\n傻b\n媽的\n媽b\nadmin\ntest",
		'type' => 'textarea');



	// ======================================================================================================================
	$options[] = array(
		'name' => __('微分類', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'id' => 'minicat_s',
		'std' => true,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'minicat_home_s',
		'std' => true,
		'desc' => __('在首頁顯示微分類最新文章', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('首頁模塊前綴', 'haoui'),
		'id' => 'minicat_home_title',
		'desc' => '默認為：今日觀點',
		'std' => '今日觀點',
		'type' => 'text');

	$options[] = array(
		'name' => __('選擇分類設置為微分類', 'haoui'),
		'desc' => __('選擇一個使用微分類展示模版，分類下文章將全文輸出到微分類列表', 'haoui'),
		'id' => 'minicat',
		'options' => $options_categories,
		'type' => 'select');


	// ======================================================================================================================
	$options[] = array(
		'name' => __('全站底部推廣區', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'id' => 'footer_brand_s',
		'std' => true,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('推廣標題', 'haoui'),
		'id' => 'footer_brand_title',
		'desc' => '建議20字內',
		'std' => '微通網絡（weiton.net），萬事不求人，做最全面的自己！',
		'type' => 'text');

	for ($i=1; $i <= 2; $i++) { 
		
	$options[] = array(
		'name' => __('按鈕 ', 'haoui').$i,
		'id' => 'footer_brand_btn_text_'.$i,
		'desc' => '按鈕文字',
		'std' => '聯繫我們',
		'type' => 'text');

	$options[] = array(
		'id' => 'footer_brand_btn_href_'.$i,
		'desc' => __('按鈕鏈接', 'haoui'),
		'std' => 'http://www.yndali.com/',
		'type' => 'text');

	$options[] = array(
		'id' => 'footer_brand_btn_blank_'.$i,
		'std' => true,
		'desc' => __('新窗口打開', 'haoui'),
		'type' => 'checkbox');

	}



	// ======================================================================================================================
	$options[] = array(
		'name' => __('首頁公告', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'id' => 'site_notice_s',
		'std' => true,
		'desc' => __('顯示公告模塊', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('顯示標題', 'haoui'),
		'id' => 'site_notice_title',
		'desc' => '建議4字內，默認：網站公告',
		'std' => '網站公告',
		'type' => 'text');

	$options[] = array(
		'name' => __('選擇分類設置為網站公告', 'haoui'),
		'id' => 'site_notice_cat',
		'options' => $options_categories,
		'type' => 'select');



	// ======================================================================================================================
	$options[] = array(
		'name' => __('首頁焦點圖', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'id' => 'focusslide_s',
		'std' => true,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('排序', 'haoui'),
		'id' => 'focusslide_sort',
		'desc' => '默認：1 2 3 4 5',
		'std' => '1 2 3 4 5',
		'type' => 'text');

	for ($i=1; $i <= 5; $i++) { 
		
	$options[] = array(
		'name' => __('圖', 'haoui').$i,
		'id' => 'focusslide_title_'.$i,
		'desc' => '標題',
		'std' => '微通網絡（weiton.net）分享',
		'type' => 'text');

	$options[] = array(
		'name' => __('鏈接到', 'haoui'),
		'id' => 'focusslide_href_'.$i,
		'desc' => __('鏈接', 'haoui'),
		'std' => 'http://www.yndali.com',
		'type' => 'text');

	$options[] = array(
		'id' => 'focusslide_blank_'.$i,
		'std' => true,
		'desc' => __('新窗口打開', 'haoui'),
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('圖片', 'haoui'),
		'id' => 'focusslide_src_'.$i,
		'desc' => __('圖片，尺寸：', 'haoui').'820*200',
		'std' => '/wp-content/uploads/2016/01/hs-xiu.jpg',
		'type' => 'upload');

	}


	// ======================================================================================================================
	$options[] = array(
		'name' => __('側欄隨動', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('首頁', 'haoui'),
		'id' => 'sideroll_index_s',
		'std' => true,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'sideroll_index',
		'std' => '1 2 3',
		'class' => 'mini',
		'desc' => __('設置隨動模塊，多個模塊之間用空格隔開即可！默認：「1 2」，表示第1和第2個模塊，建議最多3個模塊 ', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('分類/標籤/搜索頁', 'haoui'),
		'id' => 'sideroll_list_s',
		'std' => true,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'sideroll_list',
		'std' => '1 2 3',
		'class' => 'mini',
		'desc' => __('設置隨動模塊，多個模塊之間用空格隔開即可！默認：「1 2」，表示第1和第2個模塊，建議最多3個模塊 ', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('文章頁', 'haoui'),
		'id' => 'sideroll_post_s',
		'std' => true,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');

	$options[] = array(
		'id' => 'sideroll_post',
		'std' => '1 2 3',
		'class' => 'mini',
		'desc' => __('設置隨動模塊，多個模塊之間用空格隔開即可！默認：「1 2」，表示第1和第2個模塊，建議最多3個模塊 ', 'haoui'),
		'type' => 'text');



	// ======================================================================================================================
	$options[] = array(
		'name' => __('直達鏈接', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('在文章列表顯示', 'haoui').' (v1.3+)',
		'id' => 'post_link_excerpt_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'name' => __('在文章頁面顯示', 'haoui'),
		'id' => 'post_link_single_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'name' => __('新窗口打開鏈接', 'haoui'),
		'id' => 'post_link_blank_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'name' => __('鏈接添加 nofollow', 'haoui'),
		'id' => 'post_link_nofollow_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('開啟', 'haoui'));

	$options[] = array(
		'name' => __('自定義顯示文字', 'haoui'),
		'id' => 'post_link_h1',
		'type' => "text",
		'std' => '直達鏈接',
		'desc' => __('默認為「直達鏈接」 ', 'haoui'));


	// ======================================================================================================================
	$options[] = array(
		'name' => __('獨立頁面', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('讀者牆', 'haoui'),
		'id' => 'readwall_limit_time',
		'std' => 200,
		'class' => 'mini',
		'desc' => __('限制在多少月內，單位：月', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'id' => 'readwall_limit_number',
		'std' => 200,
		'class' => 'mini',
		'desc' => __('顯示個數', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('頁面左側菜單設置', 'haoui'),
		'id' => 'page_menu',
		'options' => $options_pages,
		'type' => 'multicheck');

	$options[] = array(
		'name' => __('友情鏈接分類選擇', 'haoui'),
		'id' => 'page_links_cat',
		'options' => $options_linkcats,
		'type' => 'multicheck');

	

	// ======================================================================================================================
	$options[] = array(
		'name' => __('字符', 'haoui'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('首頁最新發佈標題', 'haoui'),
		'id' => 'index_list_title',
		'std' => __('最新發佈', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('首頁最新發佈標題右側', 'haoui'),
		'id' => 'index_list_title_r',
		'std' => '<a href="index.php">自定義欄目</a><a href="index.php">自定義欄目</a><a href="index.php">自定義欄目</a><a href="index.php">自定義欄目</a>',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('評論標題', 'haoui'),
		'id' => 'comment_title',
		'std' => __('評論', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('評論框默認字符', 'haoui'),
		'id' => 'comment_text',
		'std' => __('你的評論可以一針見血', 'haoui'),
		'type' => 'text');

	$options[] = array(
		'name' => __('評論提交按鈕字符', 'haoui'),
		'id' => 'comment_submit_text',
		'std' => __('提交評論', 'haoui'),
		'type' => 'text');


	// ======================================================================================================================
	$options[] = array(
		'name' => __('社交', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('微博', 'haoui'),
		'id' => 'weibo',
		'std' => 'http://weibo.com/wwwbsbds168/home?topnav=1&wvr=6',
		'type' => 'text');

	$options[] = array(
		'name' => __('騰訊微博', 'haoui'),
		'id' => 'tqq',
		'std' => 'http://t.qq.com/cyz360_com',
		'type' => 'text');

	$options[] = array(
		'name' => __('Twitter', 'haoui'),
		'id' => 'twitter',
		'std' => 'cqzx87',
		'type' => 'text');

	$options[] = array(
		'name' => __('Facebook', 'haoui'),
		'id' => 'facebook',
		'std' => 'cqzx87',
		'type' => 'text');

	$options[] = array(
		'name' => __('微信帳號', 'haoui'),
		'id' => 'wechat',
		'std' => 'cqzx87',
		'type' => 'text');
	$options[] = array(
		'id' => 'wechat_qr',
		'std' => '/uploads/2016/01/weixin-qrcode.jpg',
		'desc' => __('微信二維碼，建議圖片尺寸：', 'haoui').'200x200px',
		'type' => 'upload');

	$options[] = array(
		'name' => __('RSS訂閱', 'haoui'),
		'id' => 'feed',
		'std' => get_feed_link(),
		'type' => 'text');


	// ======================================================================================================================
	$options[] = array(
		'name' => __('廣告位', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('文章頁正文結尾文字廣告', 'haoui'),
		'id' => 'ads_post_footer_s',
		'std' => false,
		'desc' => ' 顯示',
		'type' => 'checkbox');
	$options[] = array(
		'desc' => '前標題',
		'id' => 'ads_post_footer_pretitle',
		'std' => '阿里百秀',
		'type' => 'text');
	$options[] = array(
		'desc' => '標題',
		'id' => 'ads_post_footer_title',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'desc' => '鏈接',
		'id' => 'ads_post_footer_link',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'id' => 'ads_post_footer_link_blank',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('開啟', 'haoui') .' ('. __('新窗口打開鏈接', 'haoui').')');


	$options[] = array(
		'name' => __('首頁文章列表上', 'haoui'),
		'id' => 'ads_index_01_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_index_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_index_01_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首頁分頁下', 'haoui'),
		'id' => 'ads_index_02_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_index_02',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_index_02_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('文章頁正文上', 'haoui'),
		'id' => 'ads_post_01_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_post_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_post_01_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('文章頁正文下', 'haoui'),
		'id' => 'ads_post_02_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_post_02',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_post_02_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('文章頁評論上', 'haoui'),
		'id' => 'ads_post_03_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_post_03',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_post_03_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('分類頁列表上', 'haoui'),
		'id' => 'ads_cat_01_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_cat_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_cat_01_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('標籤頁列表上', 'haoui'),
		'id' => 'ads_tag_01_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_tag_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_tag_01_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');

	$options[] = array(
		'name' => __('搜索頁列表上', 'haoui'),
		'id' => 'ads_search_01_s',
		'std' => false,
		'desc' => __('開啟', 'haoui'),
		'type' => 'checkbox');
	$options[] = array(
		'desc' => __('非手機端', 'haoui').' '.$adsdesc,
		'id' => 'ads_search_01',
		'std' => '',
		'type' => 'textarea');
	$options[] = array(
		'id' => 'ads_search_01_m',
		'std' => '',
		'desc' => __('手機端', 'haoui').' '.$adsdesc,
		'type' => 'textarea');



	// ======================================================================================================================
	$options[] = array(
		'name' => __('自定義代碼', 'haoui'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('自定義網站底部內容', 'haoui'),
		'desc' => __('該塊顯示在網站底部版權上方，可已定義放一些鏈接或者圖片之類的內容。', 'haoui'),
		'id' => 'fcode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('自定義CSS樣式', 'haoui'),
		'desc' => __('位於</head>之前，直接寫樣式代碼，不用添加&lt;style&gt;標籤', 'haoui'),
		'id' => 'csscode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('自定義頭部代碼', 'haoui'),
		'desc' => __('位於</head>之前，這部分代碼是在主要內容顯示之前加載，通常是CSS樣式、自定義的<meta>標籤、全站頭部JS等需要提前加載的代碼', 'haoui'),
		'id' => 'headcode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('自定義底部代碼', 'haoui'),
		'desc' => __('位於&lt;/body&gt;之前，這部分代碼是在主要內容加載完畢加載，通常是JS代碼', 'haoui'),
		'id' => 'footcode',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('網站統計代碼', 'haoui'),
		'desc' => __('位於底部，用於添加第三方流量數據統計代碼，如：Google analytics、百度統計、CNZZ、51la，國內站點推薦使用百度統計，國外站點推薦使用Google analytics', 'haoui'),
		'id' => 'trackcode',
		'std' => '',
		'type' => 'textarea');



	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */
/*
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	$options[] = array(
		'name' => __('Default Text Editor', 'options_framework_theme'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_framework_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

*/

	return $options;
}