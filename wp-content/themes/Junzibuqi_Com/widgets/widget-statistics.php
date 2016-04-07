<?php

class widget_ui_statistics extends WP_Widget {
	function widget_ui_statistics() {
		$widget_ops = array( 'classname' => 'widget_ui_statistics', 'description' => '' );
		$this->WP_Widget( 'widget_ui_statistics', 'D-網站統計', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$code  = $instance['code'];

		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<ul>';
		global $wpdb;
		
		if( $instance['post'] ){
			$count_posts = wp_count_posts();
			echo '<li><strong>日誌總數：</strong>'.$count_posts->publish.'</li>';
		}

		if( $instance['comment'] ){
			$comments = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");
			echo '<li><strong>評論總數：</strong>'.$comments.'</li>';
		}

		if( $instance['tag'] ){
			echo '<li><strong>標籤總數：</strong>'.wp_count_terms('post_tag').'</li>';
		}

		if( $instance['page'] ){
			$count_pages = wp_count_posts('page');
			echo '<li><strong>頁面總數：</strong>'.$count_pages->publish.'</li>';
		}

		if( $instance['cat'] ){
			echo '<li><strong>分類總數：</strong>'.wp_count_terms('category').'</li>';
		}

		if( $instance['link'] ){
			$links = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'");
			echo '<li><strong>鏈接總數：</strong>'.$links.'</li>';
		}

		if( $instance['user'] ){
			$users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
			echo '<li><strong>用戶總數：</strong>'.$users.'</li>';
		}

		if( $instance['last'] ){
			$last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");
			$last = date('Y-m-d', strtotime($last[0]->MAX_m));
			echo '<li><strong>最後更新：</strong>'.$last.'</li>';
		}

		echo '</ul>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 
			'title' => '網站統計',
			'post' => '',
			'comment' => '',
			'tag' => '',
			'page' => '',
			'cat' => '',
			'link' => '',
			'user' => '',
			'last' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>
		<p>
			<label>
				標題：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['post'], 'on' ); ?> id="<?php echo $this->get_field_id('post'); ?>" name="<?php echo $this->get_field_name('post'); ?>">顯示日誌總數
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['comment'], 'on' ); ?> id="<?php echo $this->get_field_id('comment'); ?>" name="<?php echo $this->get_field_name('comment'); ?>">顯示評論總數
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['tag'], 'on' ); ?> id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>">顯示標籤總數
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['page'], 'on' ); ?> id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>">顯示頁面總數
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['cat'], 'on' ); ?> id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>">顯示分類總數
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['link'], 'on' ); ?> id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>">顯示鏈接總數
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['user'], 'on' ); ?> id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>">顯示用戶總數
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['last'], 'on' ); ?> id="<?php echo $this->get_field_id('last'); ?>" name="<?php echo $this->get_field_name('last'); ?>">顯示最後更新
			</label>
		</p>
<?php
	}
}
