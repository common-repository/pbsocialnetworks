<?php

/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/**************************** Begin Like Box ****************************/

class pbsn_likebox extends WP_Widget {
	function pbsn_likebox() {
		$widget_ops = array( 'classname' => 'pbsn_likebox', 'description' => __( 'With this Widget you can display the Facebook Like Box in your Blog Sidebar.' ) );
		$this->WP_Widget('pbsn_likebox', __('pbSN Facebook Like Box'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		echo('<iframe src="//www.facebook.com/plugins/likebox.php?href='.urlencode(((!empty($instance['pbsn_fbbox_url']))?$instance['pbsn_fbbox_url']:'http://www.facebook.com/platform')).'&amp;width='.((!empty($instance['pbsn_fbbox_width']))?$instance['pbsn_fbbox_width']:'292').'&amp;height='.((!empty($instance['pbsn_fbbox_height']))?$instance['pbsn_fbbox_height']:'590').'&amp;colorscheme='.((!empty($instance['pbsn_fbbox_color']))?$instance['pbsn_fbbox_color']:'light').'&amp;show_faces='.((!empty($instance['pbsn_fbbox_faces']))?$instance['pbsn_fbbox_faces']:'true').'&amp;border_color='.((!empty($instance['pbsn_fbbox_border_color']))?'%23'.$instance['pbsn_fbbox_border_color']:'%23aaa').'&amp;stream='.((!empty($instance['pbsn_fbbox_stream']))?$instance['pbsn_fbbox_stream']:'true').'&amp;header='.((!empty($instance['pbsn_fbbox_header']))?$instance['pbsn_fbbox_header']:'true').'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.((!empty($instance['pbsn_fbbox_width']))?$instance['pbsn_fbbox_width']:'292').'px; height:'.((!empty($instance['pbsn_fbbox_height']))?$instance['pbsn_fbbox_height']:'590').'px;" allowTransparency="true"></iframe>');
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	function form($instance) {
		echo('<p>'.__('If you need more informations about the Facebook Like Box or a preview visit <a href="https://developers.facebook.com/docs/reference/plugins/like-box/" target="_blank">this site</a>').'</p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_url').'">'.__('Facebook Page URL').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbbox_url').'" name="'.$this->get_field_name('pbsn_fbbox_url').'" type="text" value="'.((!empty($instance['pbsn_fbbox_url']))?$instance['pbsn_fbbox_url']:'http://www.facebook.com/platform').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_width').'">'.__('Width (default: 292)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbbox_width').'" name="'.$this->get_field_name('pbsn_fbbox_width').'" type="text" value="'.((!empty($instance['pbsn_fbbox_width']))?$instance['pbsn_fbbox_width']:'292').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_height').'">'.__('Height (default: 590)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbbox_height').'" name="'.$this->get_field_name('pbsn_fbbox_height').'" type="text" value="'.((!empty($instance['pbsn_fbbox_height']))?$instance['pbsn_fbbox_height']:'590').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_color').'">'.__('Color Scheme').':</label>
		<select id="'.$this->get_field_id('pbsn_fbbox_color').'" name="'.$this->get_field_name('pbsn_fbbox_color').'"><option value="light" '.(($instance['pbsn_fbbox_color']=='light')?'selected="selected"':'').'>light</option><option value="dark" '.(($instance['pbsn_fbbox_color']=='dark')?'selected="selected"':'').'>dark</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_border_color').'">'.__('Border Color (without #)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbbox_border_color').'" name="'.$this->get_field_name('pbsn_fbbox_border_color').'" type="text" value="'.$instance['pbsn_fbbox_border_color'].'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_faces').'">'.__('Show Faces').':</label>
		<select id="'.$this->get_field_id('pbsn_fbbox_faces').'" name="'.$this->get_field_name('pbsn_fbbox_faces').'"><option value="true" '.(($instance['pbsn_fbbox_faces']=='true')?'selected="selected"':'').'>'.__('yes').'</option><option value="false" '.(($instance['pbsn_fbbox_faces']=='false')?'selected="selected"':'').'>'.__('no').'</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_stream').'">'.__('Show Stream').':</label>
		<select id="'.$this->get_field_id('pbsn_fbbox_stream').'" name="'.$this->get_field_name('pbsn_fbbox_stream').'"><option value="true" '.(($instance['pbsn_fbbox_stream']=='true')?'selected="selected"':'').'>'.__('yes').'</option><option value="false" '.(($instance['pbsn_fbbox_stream']=='false')?'selected="selected"':'').'>'.__('no').'</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbbox_header').'">'.__('Show Header').':</label>
		<select id="'.$this->get_field_id('pbsn_fbbox_header').'" name="'.$this->get_field_name('pbsn_fbbox_header').'"><option value="true" '.(($instance['pbsn_fbbox_header']=='true')?'selected="selected"':'').'>'.__('yes').'</option><option value="false" '.(($instance['pbsn_fbbox_header']=='false')?'selected="selected"':'').'>'.__('no').'</option></select></p>');
	}
}

add_action('widgets_init', create_function('', 'return register_widget("pbsn_likebox");'));

/**************************** End Like Box ****************************/
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/**************************** Begin Activity Feed ****************************/

class pbsn_activityfeed extends WP_Widget {
	function pbsn_activityfeed() {
		$widget_ops = array( 'classname' => 'pbsn_activityfeed', 'description' => __( 'With this Widget you can display the Facebook Activity Feed in your Blog Sidebar.' ) );
		$this->WP_Widget('pbsn_activityfeed', __('pbSN Facebook Activity Feed'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		echo('<iframe src="http://www.facebook.com/plugins/activity.php?site='.urlencode(((!empty($instance['pbsn_fbac_url']))?$instance['pbsn_fbac_url']:get_bloginfo('url'))).'&amp;width='.((!empty($instance['pbsn_fbac_width']))?$instance['pbsn_fbac_width']:'300').'&amp;height='.((!empty($instance['pbsn_fbac_height']))?$instance['pbsn_fbac_height']:'300').'&amp;header='.((!empty($instance['pbsn_fbac_header']))?$instance['pbsn_fbac_header']:'true').'&amp;colorscheme='.((!empty($instance['pbsn_fbac_color']))?$instance['pbsn_fbac_color']:'light').'&amp;border_color='.((!empty($instance['pbsn_fbac_border_color']))?'%23'.$instance['pbsn_fbac_border_color']:'%23aaa').'&amp;recommendations='.((!empty($instance['pbsn_fbac_recom']))?$instance['pbsn_fbac_recom']:'true').'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.((!empty($instance['pbsn_fbac_width']))?$instance['pbsn_fbac_width']:'300').'px; height:'.((!empty($instance['pbsn_fbac_height']))?$instance['pbsn_fbac_height']:'300').'px"></iframe>');
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	function form($instance) {
		echo('<p>'.__('If you need more informations about the Facebook Activity Feed or a preview visit <a href="https://developers.facebook.com/docs/reference/plugins/activity/" target="_blank">this site</a>').'</p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_url').'">'.__('Domain').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_url').'" name="'.$this->get_field_name('pbsn_fbac_url').'" type="text" value="'.((!empty($instance['pbsn_fbac_url']))?$instance['pbsn_fbac_url']:get_bloginfo('url')).'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_width').'">'.__('Width (default: 300)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_width').'" name="'.$this->get_field_name('pbsn_fbac_width').'" type="text" value="'.((!empty($instance['pbsn_fbac_width']))?$instance['pbsn_fbac_width']:'300').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_height').'">'.__('Height (default: 300)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_height').'" name="'.$this->get_field_name('pbsn_fbac_height').'" type="text" value="'.((!empty($instance['pbsn_fbac_height']))?$instance['pbsn_fbac_height']:'300').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_border_color').'">'.__('Border Color (without #)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_border_color').'" name="'.$this->get_field_name('pbsn_fbac_border_color').'" type="text" value="'.$instance['pbsn_fbac_border_color'].'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_color').'">'.__('Color Scheme').':</label>
		<select id="'.$this->get_field_id('pbsn_fbac_color').'" name="'.$this->get_field_name('pbsn_fbac_color').'"><option value="light" '.(($instance['pbsn_fbac_color']=='light')?'selected="selected"':'').'>light</option><option value="dark" '.(($instance['pbsn_fbac_color']=='dark')?'selected="selected"':'').'>dark</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_header').'">'.__('Show Header').':</label>
		<select id="'.$this->get_field_id('pbsn_fbac_header').'" name="'.$this->get_field_name('pbsn_fbac_header').'"><option value="true" '.(($instance['pbsn_fbac_header']=='true')?'selected="selected"':'').'>'.__('yes').'</option><option value="false" '.(($instance['pbsn_fbac_header']=='false')?'selected="selected"':'').'>'.__('no').'</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_recom').'">'.__('Recommendations').':</label>
		<select id="'.$this->get_field_id('pbsn_fbac_recom').'" name="'.$this->get_field_name('pbsn_fbac_recom').'"><option value="true" '.(($instance['pbsn_fbac_recom']=='true')?'selected="selected"':'').'>'.__('yes').'</option><option value="false" '.(($instance['pbsn_fbac_recom']=='false')?'selected="selected"':'').'>'.__('no').'</option></select></p>');
		
	}
}

add_action('widgets_init', create_function('', 'return register_widget("pbsn_activityfeed");'));

/**************************** End Activity Feed ****************************/
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/**************************** Begin Recommendations ****************************/

class pbsn_recommendations extends WP_Widget {
	function pbsn_recommendations() {
		$widget_ops = array( 'classname' => 'pbsn_recommendations', 'description' => __( 'With this Widget you can display the Facebook Recommendations Plugin in your Blog Sidebar.' ) );
		$this->WP_Widget('pbsn_recommendations', __('pbSN Facebook Recommendations'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		echo('<iframe src="http://www.facebook.com/plugins/recommendations.php?site='.urlencode(((!empty($instance['pbsn_fbac_url']))?$instance['pbsn_fbac_url']:get_bloginfo('url'))).'&amp;width='.((!empty($instance['pbsn_fbac_width']))?$instance['pbsn_fbac_width']:'300').'&amp;height='.((!empty($instance['pbsn_fbac_height']))?$instance['pbsn_fbac_height']:'300').'&amp;header='.((!empty($instance['pbsn_fbac_header']))?$instance['pbsn_fbac_header']:'true').'&amp;colorscheme='.((!empty($instance['pbsn_fbac_color']))?$instance['pbsn_fbac_color']:'light').'&amp;border_color='.((!empty($instance['pbsn_fbac_border_color']))?'%23'.$instance['pbsn_fbac_border_color']:'%23aaa').'&amp;recommendations='.((!empty($instance['pbsn_fbac_recom']))?$instance['pbsn_fbac_recom']:'true').'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.((!empty($instance['pbsn_fbac_width']))?$instance['pbsn_fbac_width']:'300').'px; height:'.((!empty($instance['pbsn_fbac_height']))?$instance['pbsn_fbac_height']:'300').'px"></iframe>');
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	function form($instance) {
		echo('<p>'.__('If you need more informations about Facebook Recommendations or a preview visit <a href="https://developers.facebook.com/docs/reference/plugins/recommendations/" target="_blank">this site</a>').'</p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_url').'">'.__('Domain').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_url').'" name="'.$this->get_field_name('pbsn_fbac_url').'" type="text" value="'.((!empty($instance['pbsn_fbac_url']))?$instance['pbsn_fbac_url']:get_bloginfo('url')).'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_width').'">'.__('Width (default: 300)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_width').'" name="'.$this->get_field_name('pbsn_fbac_width').'" type="text" value="'.((!empty($instance['pbsn_fbac_width']))?$instance['pbsn_fbac_width']:'300').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_height').'">'.__('Height (default: 300)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_height').'" name="'.$this->get_field_name('pbsn_fbac_height').'" type="text" value="'.((!empty($instance['pbsn_fbac_height']))?$instance['pbsn_fbac_height']:'300').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_border_color').'">'.__('Border Color (without #)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbac_border_color').'" name="'.$this->get_field_name('pbsn_fbac_border_color').'" type="text" value="'.$instance['pbsn_fbac_border_color'].'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_color').'">'.__('Color Scheme').':</label>
		<select id="'.$this->get_field_id('pbsn_fbac_color').'" name="'.$this->get_field_name('pbsn_fbac_color').'"><option value="light" '.(($instance['pbsn_fbac_color']=='light')?'selected="selected"':'').'>light</option><option value="dark" '.(($instance['pbsn_fbac_color']=='dark')?'selected="selected"':'').'>dark</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbac_header').'">'.__('Show Header').':</label>
		<select id="'.$this->get_field_id('pbsn_fbac_header').'" name="'.$this->get_field_name('pbsn_fbac_header').'"><option value="true" '.(($instance['pbsn_fbac_header']=='true')?'selected="selected"':'').'>'.__('yes').'</option><option value="false" '.(($instance['pbsn_fbac_header']=='false')?'selected="selected"':'').'>'.__('no').'</option></select></p>');
		
	}
}

add_action('widgets_init', create_function('', 'return register_widget("pbsn_recommendations");'));

/**************************** End Recommendations ****************************/
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/**************************** Begin Subscribe Button ****************************/

class pbsn_subscribebtn extends WP_Widget {
	function pbsn_subscribebtn() {
		$widget_ops = array( 'classname' => 'pbsn_subscribebtn', 'description' => __( 'With this Widget you can display a Facebook Subscribe Button in your Blog Sidebar.' ) );
		$this->WP_Widget('pbsn_subscribebtn', __('pbSN Subscribe Button'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		echo('<iframe src="//www.facebook.com/plugins/subscribe.php?href='.urlencode(((!empty($instance['pbsn_fbsb_url']))?$instance['pbsn_fbsb_url']:'https://www.facebook.com/plugins/subscribe.php?href=https://www.facebook.com/zuck')).((!empty($instance['pbsn_fbsb_layout']))?'&amp;layout='.$instance['pbsn_fbsb_layout']:'&amp;layout').'&amp;show_faces='.((!empty($instance['pbsn_fbsb_faces']))?$instance['pbsn_fbsb_faces']:'true').'&amp;colorscheme='.((!empty($instance['pbsn_fbsb_color']))?$instance['pbsn_fbsb_color']:'light').'&amp;width='.((!empty($instance['pbsn_fbsb_width']))?$instance['pbsn_fbsb_width']:'450').'&amp;font" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.((!empty($instance['pbsn_fbsb_width']))?$instance['pbsn_fbsb_width']:'450').'px;" allowTransparency="true"></iframe>');
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	function form($instance) {
		echo('<p>'.__('If you need more informations about the Facebook Subscribe Button or a preview visit <a href="https://developers.facebook.com/docs/reference/plugins/subscribe/" target="_blank">this site</a>').'</p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbsb_url').'">'.__('Profile URL').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbsb_url').'" name="'.$this->get_field_name('pbsn_fbsb_url').'" type="text" value="'.$instance['pbsn_fbsb_url'].'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbsb_width').'">'.__('Width (default: 450)').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_fbsb_width').'" name="'.$this->get_field_name('pbsn_fbsb_width').'" type="text" value="'.((!empty($instance['pbsn_fbsb_width']))?$instance['pbsn_fbsb_width']:'450').'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbsb_layout').'">'.__('Layout Style').':</label>
		<select id="'.$this->get_field_id('pbsn_fbsb_layout').'" name="'.$this->get_field_name('pbsn_fbsb_layout').'"><option value="standard" '.(($instance['pbsn_fbsb_layout']=='standard')?'selected="selected"':'').'>standard</option><option value="button_count" '.(($instance['pbsn_fbsb_layout']=='button_count')?'selected="selected"':'').'>button_count</option><option value="box_count" '.(($instance['pbsn_fbsb_layout']=='box_count')?'selected="selected"':'').'>box_count</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbsb_color').'">'.__('Color Scheme').':</label>
		<select id="'.$this->get_field_id('pbsn_fbsb_color').'" name="'.$this->get_field_name('pbsn_fbsb_color').'"><option value="light" '.(($instance['pbsn_fbsb_color']=='light')?'selected="selected"':'').'>light</option><option value="dark" '.(($instance['pbsn_fbsb_color']=='dark')?'selected="selected"':'').'>dark</option></select></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_fbsb_faces').'">'.__('Show Faces').':</label>
		<select id="'.$this->get_field_id('pbsn_fbsb_faces').'" name="'.$this->get_field_name('pbsn_fbsb_faces').'"><option value="true" '.(($instance['pbsn_fbsb_faces']=='true')?'selected="selected"':'').'>'.__('yes').'</option><option value="false" '.(($instance['pbsn_fbsb_faces']=='false')?'selected="selected"':'').'>'.__('no').'</option></select></p>');
		
	}
}

add_action('widgets_init', create_function('', 'return register_widget("pbsn_subscribebtn");'));

/**************************** End Subscribe Button ****************************/
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
/**************************** Begin Last Tweet ****************************/

class pbsn_lasttweet extends WP_Widget {
	function pbsn_lasttweet() {
		$widget_ops = array( 'classname' => 'pbsn_lasttweet', 'description' => __( 'With this Widget you can display an individual styled list of your last Tweets.' ) );
		$this->WP_Widget('pbsn_lasttweet', __('pbSN Last Tweets'), $widget_ops);
	}

	function widget($args, $instance) {
		wp_enqueue_script('jquery');
		extract($args);
		echo $before_widget;
		echo($before_title.$instance['pbsn_lt_title'].$after_title);
		if( !empty($instance['pbsn_lt_account']) && !empty($instance['pbsn_lt_num']) && is_numeric($instance['pbsn_lt_num']) ):
		$divid = 'pbsn_twitter_widget_ajax_'.md5(rand(1,1000));
		echo('<div id="'.$divid.'">');
		?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery.getJSON('https://twitter.com/status/user_timeline/<?php echo($instance['pbsn_lt_account']); ?>.json?callback=?', { count: <?php echo($instance['pbsn_lt_num']); ?> }, function(json){
				i = 0;
				count = json.length;
				
				while(i<=count){
					jQuery('#<?php echo($divid); ?>').append('<div class="pbsn_twitter_widget" id="pbsn_twitter_widget_'+(i+1)+'"><p>'+json[i].text+'<br \/><\/p><\/div>');
					i++;
				}
			});
		});
		</script>
		<?php
		echo('</div>');
		endif;
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	function form($instance) {
		echo('<p>'.__('With this Widget you can display a list with your last Tweets. You can customize it via some parts of CSS.').'</p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_lt_title').'">'.__('Title').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_lt_title').'" name="'.$this->get_field_name('pbsn_lt_title').'" type="text" value="'.$instance['pbsn_lt_title'].'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_lt_account').'">'.__('Twitter Account').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_lt_account').'" name="'.$this->get_field_name('pbsn_lt_account').'" type="text" value="'.$instance['pbsn_lt_account'].'"></p>');
		
		echo('<p><label for="'.$this->get_field_id('pbsn_lt_num').'">'.__('Amount of shown Tweets').':</label>
		<input class="widefat" id="'.$this->get_field_id('pbsn_lt_num').'" name="'.$this->get_field_name('pbsn_lt_num').'" type="text" value="'.((!empty($instance['pbsn_lt_num']))?$instance['pbsn_lt_num']:'5').'"></p>');
		
	}
}

add_action('widgets_init', create_function('', 'return register_widget("pbsn_lasttweet");'));

/**************************** End Last Tweet ****************************/
/****************************************************************************************************************************************/

?>