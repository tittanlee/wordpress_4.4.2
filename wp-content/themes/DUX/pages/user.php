<?php 
/**
 * Template name: User
 * Description:   A user profile page
 */

get_header();

?>

<?php if( !_hui('user_page_s') ) exit('該功能需要開啟！'); ?>
<section class="container">
	<div class="container-user"<?php echo is_user_logged_in()?'':' id="issignshow" style="height:500px;"' ?>>
		<?php if( is_user_logged_in() ){ global $current_user; ?>
		<div class="userside">
			<div class="usertitle">
				<?php echo _get_the_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, true); ?>
				<h2><?php echo $current_user->display_name ?></h2>
			</div>
			<div class="usermenus">	
				<ul class="usermenu">
					<li class="usermenu-post-new"><a href="#post-new">發佈文章</a></li>
					<li class="usermenu-posts"><a href="#posts/all">我的文章</a></li>
					<li class="usermenu-comments"><a href="#comments">我的評論</a></li>
					<li class="usermenu-info"><a href="#info">修改資料</a></li>
					<li class="usermenu-password"><a href="#password">修改密碼</a></li>
					<li class="usermenu-signout"><a href="<?php echo wp_logout_url(home_url()) ?>">退出</a></li>
				</ul>
			</div>
		</div>
		<div class="content" id="contentframe">
			<div class="user-main"></div>
			<div class="user-tips"></div>
		</div>
		<?php } ?>
	</div>
</section>

<?php if( is_user_logged_in() ){ ?>

<script id="temp-postnew" type="text/x-jsrender">
	<form>
	  	<ul class="user-meta user-postnew">
	  		<li><label>標題</label>
				<input type="text" class="form-control" name="post_title" placeholder="文章標題">
	  		</li>
	  		<li><label>內容</label>
				<textarea name="post_content" class="form-control" rows="12" placeholder="文章內容"></textarea>
	  		</li>
	  		<li><label>來源鏈接</label>
				<input type="text" class="form-control" name="post_url" placeholder="文章來源鏈接">
	  		</li>
	  		<li>
	  			<br>
				<input type="button" evt="postnew.submit" class="btn btn-primary" name="submit" value="提交審核">
				<input type="hidden" name="action" value="post.new">
	  		</li>
	  	</ul>
	</form>
</script>

<script id="temp-postmenu" type="text/x-jsrender">
	<a href="#posts/{{>name}}">{{>title}}<small>({{>count}})</small></a>
</script>

<script id="temp-postitem" type="text/x-jsrender">
	<li>
		<img data-src="{{>thumb}}" class="thumb">
		<h2><a target="_blank" href="{{>link}}">{{>title}}</a></h2>
		<p class="note">{{>desc}}</p>
		<p class="text-muted">{{>time}} &nbsp;&nbsp; 分類：{{>cat}} &nbsp;&nbsp; 閱讀({{>view}}) &nbsp;&nbsp; 評論({{>comment}}) &nbsp;&nbsp; 贊({{>like}})</p>
	</li>
</script>

<script id="temp-info" type="text/x-jsrender">
	<form>
	  	<ul class="user-meta">
	  		<li><label>入門時間</label>
				{{>regtime}}
	  		</li>
	  		<li><label>用戶名</label>
				<input type="input" class="form-control" disabled value="{{>logname}}">
	  		</li>
	  		<li><label>郵箱</label>
				<input type="email" class="form-control" disabled value="{{>email}}">
	  		</li>
	  		<li><label>暱稱</label>
				<input type="input" class="form-control" name="nickname" value="{{>nickname}}">
	  		</li>
	  		<li><label>網址</label>
				<input type="input" class="form-control" name="url" value="{{>url}}">
	  		</li>
	  		<li><label>QQ</label>
				<input type="input" class="form-control" name="qq" value="{{>qq}}">
	  		</li>
	  		<li><label>微信號</label>
				<input type="input" class="form-control" name="weixin" value="{{>weixin}}">
	  		</li>
	  		<li><label>微博地址</label>
				<input type="input" class="form-control" name="weibo" value="{{>weibo}}">
	  		</li>
	  		<li>
				<input type="button" evt="info.submit" class="btn btn-primary" name="submit" value="確認修改資料">
				<input type="hidden" name="action" value="info.edit">
	  		</li>
	  	</ul>
	</form>
</script>

<script id="temp-password" type="text/x-jsrender">
	<form>
	  	<ul class="user-meta">
	  		<li><label>原密碼</label>
				<input type="password" class="form-control" name="passwordold">
	  		</li>
	  		<li><label>新密碼</label>
				<input type="password" class="form-control" name="password">
	  		</li>
	  		<li><label>重複新密碼</label>
				<input type="password" class="form-control" name="password2">
	  		</li>
	  		<li>
				<input type="button" evt="password.submit" class="btn btn-primary" name="submit" value="確認修改密碼">
				<input type="hidden" name="action" value="password.edit">
	  		</li>
	  	</ul>
	</form>
</script>

<script id="temp-commentitem" type="text/x-jsrender">
	<li>
		<time>{{>time}}</time>
		<p class="note">{{>content}}</p>
		<p class="text-muted">文章：<a target="_blank" href="{{>post_link}}">{{>post_title}}</a></p>
	</li>
</script>

<?php
}
?>

<?php

get_footer();