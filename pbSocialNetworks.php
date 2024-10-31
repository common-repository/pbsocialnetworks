<?php
/*
Plugin Name: pbSocialNetworks Pro - The Social Media Plugin
Plugin URI: http://www.pbsocialnetworks.com/
Description: pbSocialNetworks Pro lets you easily integrate popular Social Network Buttons like Twitter, Google+, Facebook like and Pinterest. Additionally you will get great Social Network Widgets for you Blog Sidebar: Twitter Last Tweets, Facebook Recommendations, Facebook LikeBox and Facebook Activity Feed. In the end pbSocialNetworks Pro bring you a great statistics system to see the results of your Social Media Marketing Campaigns.
Version: 1.1.3
Author: Pascal Bajorat
Author URI: http://www.pascal-bajorat.com/
License: GNU General Public License v.3
*/

require_once('pbStats.php');
require_once('pbOptions.php');
require_once('pbWidgets.php');

class pbSocialNetworks extends pbSocialNetworksOptions {
	var $Version = '1.1.2';
	var $Name = 'SocialNetworks Pro';
	var $PluginFolder = 'pbsocialnetworks';
	var $StatsTable = 'pbsocialnetworks_stats';
	var $Referer = false;
	
	// construct function
	function __construct(){
		// Load Localization
		add_action('plugins_loaded', array(&$this, 'lang'));
		
		// register install and uninstall hooks
		register_activation_hook( __FILE__, array(&$this, 'install') );
		register_deactivation_hook( __FILE__, array(&$this, 'uninstall') );
		
		// image size for og
		add_image_size('og-image', 50, 50, true);
		// shortcode
		add_shortcode('pbsn', array(&$this, 'pbsnShortcode'));
		
		// referer url
		$this->Referer = parse_url($_SERVER['HTTP_REFERER']);
		
		// call init function for register scripts and styles
		add_action('init', array(&$this, 'registerStylesAndScripts'));
		
		$general = get_option('pbsn_options_general');
		
		// construct backend
		if( is_admin() ){
			add_action('admin_menu', array(&$this, 'menu'));
			add_action('admin_init', array(&$this, 'initOptions'));
			add_action('admin_print_scripts', array(&$this, 'adminScripts'));
			add_action('admin_print_styles', array(&$this, 'adminStyles'));
			add_action('add_meta_boxes', array(&$this, 'ogMetaBox'));
			add_action('save_post', array(&$this, 'ogMetaBoxSavePostdata'));
			
		// construct frontend
		}else{			
			if( $general['statics'] == 1 ){
				$this->trackStatics($this->Referer['host']);
			}
			
			if( $general['status'] == 1 ){
				add_action('wp_head', array(&$this, 'headscripts'), 1);
				add_action('wp_footer', array(&$this, 'footerscripts'), 9999);

				remove_filter('the_content', 'wpautop');
				add_filter('the_content', array(&$this, 'addButtonContent'), 10);
			}
		}
	}
	
	function lang(){
		load_plugin_textdomain('pbSocialNetworks', false, dirname(plugin_basename( __FILE__ )).'/lang/');
	}
	
	function addUpdateKeys($query){
		$general = get_option('pbsn_options_general');
		$licence = trim($general['licence']);
		$query['licence'] = $licence;
		$query['url'] = get_bloginfo('url');
		$query['version'] = $this->Version;
		
		return $query;
	}
	
	function install(){
		global $wpdb;
		
		add_option('pbSocialNetworksDBversion', $this->Version);
		
		$sql = 'CREATE TABLE `'.$wpdb->prefix.$this->StatsTable.'` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `date` DATE NOT NULL, `facebook` INT NOT NULL, `facebook_btn` INT NOT NULL, `twitter` INT NOT NULL, `twitter_btn` INT NOT NULL, `googleplus` INT NOT NULL, `googleplus_btn` INT NOT NULL, `pinterest` INT NOT NULL, `pinterest_btn` INT NOT NULL, UNIQUE (`date`));';
		
		$wpdb->query($sql);
	}
	
	function uninstall(){
		global $wpdb;
		
		delete_option('pbSocialNetworksDBversion');
		delete_option('pbsn_options_general');
		delete_option('pbsn_options_facebook');
		delete_option('pbsn_options_og');
		delete_option('pbsn_options_twitter');
		delete_option('pbsn_options_googleplus');
		delete_option('pbsn_options_pinterest');
		
		$sql = 'DROP TABLE `'.$wpdb->prefix.$this->StatsTable.'`';
		
		$wpdb->query($sql);
	}
	
	function registerStylesAndScripts(){
		// register scripts and styles
		wp_register_style('pbSocialNetworks', plugins_url('css/pbSocialNetworks.css', __FILE__), '', $this->Version );
		wp_register_style('pbVisualize', plugins_url('css/visualize.css', __FILE__), '', $this->Version );
		
		wp_register_script('pbExcanvas', plugins_url('js/excanvas.js', __FILE__), array('jquery'), $this->Version );
		wp_register_script('pbVisualize', plugins_url('js/visualize.jQuery.js', __FILE__), array('jquery'), $this->Version );
	}
	
	function adminScripts(){
		global $current_screen;
		$screenID = strtolower($current_screen->id);
		
		if( strstr($screenID, 'pbsocialnetworks') ){
			wp_enqueue_script('jquery');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('pbExcanvas');
			wp_enqueue_script('pbVisualize');
		}
	}
	
	function adminStyles(){
		global $current_screen;
		$screenID = strtolower($current_screen->id);
		
		if( strstr($screenID, 'pbsocialnetworks') ){
			wp_enqueue_style('thickbox');
			wp_enqueue_style('pbVisualize');
		}
	}
	
	function menu(){
		// Admin menu
		add_menu_page('pbSocialNetworks', __('SocialNetworks', 'pbSocialNetworks'), 'manage_options', __FILE__, array(&$this, 'OptionsPage'), plugins_url('/img/icon.png', __FILE__));
		add_submenu_page( __FILE__, __('Facebook - pbSocialNetworks', 'pbSocialNetworks'), __('Facebook', 'pbSocialNetworks'), 'manage_options', plugin_dir_path( __FILE__ ).'facebook.php', array(&$this, 'OptionsPageFB') );
		add_submenu_page( __FILE__, __('Twitter - pbSocialNetworks', 'pbSocialNetworks'), __('Twitter', 'pbSocialNetworks'), 'manage_options', plugin_dir_path( __FILE__ ).'twitter.php', array(&$this, 'OptionsPageTwitter') );
		add_submenu_page( __FILE__, __('Google+ - pbSocialNetworks', 'pbSocialNetworks'), __('Google+', 'pbSocialNetworks'), 'manage_options', plugin_dir_path( __FILE__ ).'googleplus.php', array(&$this, 'OptionsPageGoogle') );
		add_submenu_page( __FILE__, __('Pinterest - pbSocialNetworks', 'pbSocialNetworks'), __('Pinterest', 'pbSocialNetworks'), 'manage_options', plugin_dir_path( __FILE__ ).'pinterest.php', array(&$this, 'OptionsPagePinterest') );
		add_submenu_page( __FILE__, __('Open Graph - pbSocialNetworks', 'pbSocialNetworks'), __('Open Graph', 'pbSocialNetworks'), 'manage_options', plugin_dir_path( __FILE__ ).'opengraph.php', array(&$this, 'OptionsPageOG') );
		add_submenu_page( __FILE__, __('Stats - pbSocialNetworks', 'pbSocialNetworks'), __('Stats', 'pbSocialNetworks'), 'manage_options', plugin_dir_path( __FILE__ ).'stats.php', array(&$this, 'StatsPage') );
		//add_submenu_page( __FILE__, __('Support - pbSocialNetworks', 'pbSocialNetworks'), __('Support', 'pbSocialNetworks'), 'manage_options', plugin_dir_path( __FILE__ ).'support.php', array(&$this, 'SupportPage') );
	}
	
	function headscripts(){
		global $wp_query;
		$general = get_option('pbsn_options_general');
		$postId = $wp_query->post->ID;
		$postType = $wp_query->post->post_type;
		$og = get_option('pbsn_options_og');
		
		echo("\n\r\n\r<!-- This Websites uses pbSocialNetworks Pro by Pascal-Bajorat.com to include and display Social Media Buttons: visit pbSocialNetworks.Pascal-Bajorat.com -->\n\r\n\r");
		
		if( $general['css'] == 1 ){
			wp_enqueue_style('pbSocialNetworks');
		}
		
		wp_enqueue_script('jquery');
		
		if( $og['status'] == 1 ){
			$ogType = trim(get_post_meta($postId, 'ogtype', true));
			$ogTitle = trim(get_post_meta($postId, 'ogtitle', true));
			$ogDescription = trim(get_post_meta($postId, 'ogdescription', true));
			$ogimage = trim(get_post_meta($postId, 'ogimage', true));
			
			// tags only for the homepage
			if( is_front_page() == true ){
				if( !empty($ogTitle) ){
					echo('<meta property="og:title" content="'.$ogTitle.'" />'."\n\r");
				}elseif( !empty($og['hometitle']) ){
					echo('<meta property="og:title" content="'.$og['hometitle'].'" />'."\n\r");
				}else{
					echo('<meta property="og:title" content="'.get_bloginfo('slogan').'" />'."\n\r");
				}
				
				if( !empty($og['type']) ){
					echo('<meta property="og:type" content="'.((!empty($ogType))?$ogType:$og['type']).'" />'."\n\r");
				}
				
				if( !empty($og['homedesc']) ){
					echo('<meta property="og:description" content="'.((!empty($ogDescription))?$ogDescription:$og['homedesc']).'" />'."\n\r");
				}
				
				if( !empty($og['img']) ){
					echo('<meta property="og:image" content="'.((!empty($ogimage))?$ogimage:$og['img']).'" />'."\n\r");
				}
				
				echo('<meta property="og:url" content="'.home_url('/').'" />'."\n\r");
				
			}elseif( $postType == 'post' || $postType == 'page' ){
				echo('<meta property="og:title" content="'.((!empty($ogTitle))?$ogTitle:$wp_query->post->post_title).'" />'."\n\r");
				if(!empty($ogType)){
					echo('<meta property="og:type" content="'.$ogType.'" />'."\n\r");
				}else{
					echo('<meta property="og:type" content="'.(($postType=='post')?$og['articletype']:$og['pagetype']).'" />'."\n\r");
				}
				
				if(!empty($ogDescription)){
					echo('<meta property="og:description" content="'.$ogDescription.'" />'."\n\r");
				}else{
					echo('<meta property="og:description" content="'.strip_tags(substr($wp_query->post->post_content, 0, 140)).'" />'."\n\r");
				}
				
				echo('<meta property="og:url" content="'.get_permalink($postId).'" />'."\n\r");
				if(!empty($ogimage)){
					echo('<meta property="og:image" content="'.$ogimage.'" />'."\n\r");
				}elseif( has_post_thumbnail($postId) ){
					$img = wp_get_attachment_image_src( get_post_thumbnail_id($postId), 'og-image' );
					$ogIMG = $img[0];
					echo('<meta property="og:image" content="'.$ogIMG.'" />'."\n\r");
				}elseif( !empty($og['img']) ){
					echo('<meta property="og:image" content="'.$og['img'].'" />'."\n\r");
				}
			}
			
			// this tags will be shown on each page
			if( !empty($og['sitename']) ){
				echo('<meta property="og:site_name" content="'.$og['sitename'].'" />'."\n\r");
			}
			if( !empty($og['latitude']) ){
				echo('<meta property="og:latitude" content="'.$og['latitude'].'" />'."\n\r");
			}
			if( !empty($og['longitude']) ){
				echo('<meta property="og:longitude" content="'.$og['longitude'].'" />'."\n\r");
			}
			if( !empty($og['street']) ){
				echo('<meta property="og:street-address" content="'.$og['street'].'" />'."\n\r");
			}
			if( !empty($og['locality']) ){
				echo('<meta property="og:locality" content="'.$og['locality'].'" />'."\n\r");
			}
			if( !empty($og['region']) ){
				echo('<meta property="og:region" content="'.$og['region'].'" />'."\n\r");
			}
			if( !empty($og['postalcode']) ){
				echo('<meta property="og:postal-code" content="'.$og['postalcode'].'" />'."\n\r");
			}
			if( !empty($og['country']) ){
				echo('<meta property="og:country" content="'.$og['country'].'" />'."\n\r");
			}
			if( !empty($og['email']) ){
				echo('<meta property="og:country" content="'.$og['email'].'" />'."\n\r");
			}
			if( !empty($og['phone']) ){
				echo('<meta property="og:phone_number" content="'.$og['phone'].'" />'."\n\r");
			}
			if( !empty($og['fax']) ){
				echo('<meta property="og:fax_number" content="'.$og['fax'].'" />'."\n\r");
			}
			if( !empty($og['adminid']) ){
				echo('<meta property="fb:admins" content="'.$og['adminid'].'" />'."\n\r");
			}
			if( !empty($og['appid']) ){
				echo('<meta property="fb:app_id" content="'.$og['appid'].'" />'."\n\r");
			}
			
			echo("\n\r");
		}
	}
	
	function footerscripts(){
		$fb = get_option('pbsn_options_facebook');
		$twitter = get_option('pbsn_options_twitter');
		$gplus = get_option('pbsn_options_googleplus');
		$pinterest = get_option('pbsn_options_pinterest');
		
		if( $fb['status'] == 1 ){
			$facebookCode = '
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/'.(( !empty($fb['lang']) )?$fb['lang']:'en_US').'/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, \'script\', \'facebook-jssdk\'));</script>
			';
		}
		
		if( $twitter['status'] == 1 ){
			$twitterCode = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		}
		
		if( $gplus['status'] == 1 ){
			$googleplusCode = '
			<script type="text/javascript">
			  '.((!empty($gplus['lang']))?'window.___gcfg = {lang: \''.$gplus['lang'].'\'};':'').'
			
			  (function() {
			    var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
			    po.src = \'https://apis.google.com/js/plusone.js\';
			    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
			';		
		}
		
		if( $pinterest['status'] == 1 ){
			$pinterestCode = '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
		}
		
		echo($facebookCode.$twitterCode.$googleplusCode.$pinterestCode);
	}
	
	function ogMetaBox(){
		add_meta_box( 
	        'pbsn_opengraph_metabox',
	        __( 'pbSocialNetworks OpenGraph', 'pbSocialNetworks' ),
	        array(&$this, 'ogMetaBoxContent'),
	        'post' 
	    );
	    add_meta_box(
	        'pbsn_opengraph_metabox',
	        __( 'pbSocialNetworks OpenGraph', 'pbSocialNetworks' ), 
	        array(&$this, 'ogMetaBoxContent'),
	        'page'
	    );
	}
	
	function ogMetaBoxContent( $post ) {

		wp_nonce_field( plugin_basename( __FILE__ ), 'pbsn_opengraph_metabox_noncename' );
		
		$post_id = $post->ID;
		
		$ogType = trim(get_post_meta($post->ID, 'ogtype', true));
		$ogTitle = trim(get_post_meta($post->ID, 'ogtitle', true));
		$ogDescription = trim(get_post_meta($post->ID, 'ogdescription', true));
		$ogimage = trim(get_post_meta($post->ID, 'ogimage', true));
		
		echo('<label for="ogtype">'.__('Type', 'pbSocialNetworks').':</label>');
		$this->optionsField(array(
	  		'id' => 'ogtype',
	  		'section' => '',
	  		'type' => 'ogtype',
	  		'default' => ((!empty($ogType))?$ogType:'article'),
	  		'desc'=> __('You find more informations about types <a href="https://developers.facebook.com/docs/opengraphprotocol/#types" target="_blank">here</a>', 'pbSocialNetworks')
	  	));
	  	echo('<br class="clearfix" />');
	  	
	  	echo('<label for="ogtitle">'.__('Title', 'pbSocialNetworks').':</label>');
		$this->optionsField(array(
	  		'id' => 'ogtitle',
	  		'section' => '',
	  		'type' => 'text',
	  		'default' => $ogTitle,
	  		'desc'=> __('Enter title only if you don\'t want to use the article / page title.', 'pbSocialNetworks')
	  	));
	  	echo('<br class="clearfix" />');
	  	
	  	echo('<label for="ogdescription">'.__('Description', 'pbSocialNetworks').':</label>');
		$this->optionsField(array(
	  		'id' => 'ogdescription',
	  		'section' => '',
	  		'type' => 'text',
	  		'default' => $ogDescription,
	  		'desc'=> __('Enter description only if you don\'t want to use the article / page excerpt.', 'pbSocialNetworks')
	  	));
	  	echo('<br class="clearfix" />');
	  	
	  	echo('<label for="ogimage">'.__('Image', 'pbSocialNetworks').':</label>');
		$this->optionsField(array(
	  		'id' => 'ogimage',
	  		'section' => '',
	  		'type' => 'file',
	  		'default' => $ogimage,
	  		'desc'=> __('Upload a preview image or leave blank to use the post thumbnail', 'pbSocialNetworks')
	  	));
	  	echo('<br class="clearfix" />');
	  	
	  	$this->OptionPageFooter();
	}
	
	function ogMetaBoxSavePostdata($post_id){
		// verify if this is an auto save routine. 
		// If it is our form has not been submitted, so we dont want to do anything
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
		
		if( !wp_verify_nonce( $_POST['pbsn_opengraph_metabox_noncename'], plugin_basename( __FILE__ ) ) )
			return;
		
		  
		if( 'page' == $_POST['post_type'] ){
		    if ( !current_user_can( 'edit_page', $post_id ) )
		        return;
		}else{
		    if( !current_user_can( 'edit_post', $post_id ))
		        return;
		}
		
		$ogType = trim($_POST['ogtype']);
		$ogTitle = trim($_POST['ogtitle']);
		$ogDescription = trim($_POST['ogdescription']);
		$ogimage = trim($_POST['ogimage']);
		
		add_post_meta($post_id, 'ogtype', $ogimage, true) or update_post_meta($post_id, 'ogtype', $ogimage);
		add_post_meta($post_id, 'ogtitle', $ogTitle, true) or update_post_meta($post_id, 'ogtitle', $ogTitle);
		add_post_meta($post_id, 'ogdescription', $ogDescription, true) or update_post_meta($post_id, 'ogdescription', $ogDescription);
		add_post_meta($post_id, 'ogimage', $ogimage, true) or update_post_meta($post_id, 'ogimage', $ogimage);
	}
	
	function facebookLikeButton($url,$usegivenurl=false){
		$fb = get_option('pbsn_options_facebook');
		
		// url
		if( !empty($fb['url']) && $usegivenurl==false ){
			$url = $fb['url'];
		}
		
		// send button
		if( $fb['sendbutton'] == 1 ){
			$send = 'data-send="true"';
		}else{ $send = ''; }
		
		// layout
		if( !empty($fb['layout']) ){
			$layout = 'data-layout="'.$fb['layout'].'"';
		}else{ $layout = ''; }
		
		// width
		if( !empty($fb['width']) && is_numeric($fb['width']) ){
			$width = 'data-width="'.$fb['width'].'"';
		}else{ $width = 'data-width="100"'; }
		
		// faces
		if( $fb['faces'] == 1 ){
			$faces = 'data-show-faces="true"';
		}else{ $faces = 'data-show-faces="false"'; }
		
		// verb
		if( !empty($fb['verb']) ){
			$verb = 'data-action="'.$fb['verb'].'"';
		}else{ $verb = 'data-action="like"'; }
		
		// color
		if( !empty($fb['color']) ){
			$color = 'data-colorscheme="'.$fb['color'].'"';
		}else{ $color = 'data-colorscheme="light"'; }
		
		// font
		if( !empty($fb['font']) && $fb['font'] != 'standard' ){
			$font = 'data-font="'.$fb['font'].'"';
		}else{ $font = ''; }
		
		$buttoncode = '<div class="pbFacebook"><div class="fb-like" data-href="'.$url.'" '.$send.' '.$layout.' '.$width.' '.$faces.' '.$verb.' '.$color.' '.$font.'></div></div>';
		
		return($buttoncode);
	}
	
	function twitterButton($url,$usegivenurl=false,$title=false,$usegiventitle=false){
		$twitter = get_option('pbsn_options_twitter');
		
		// url
		if( !empty($twitter['url']) && $usegivenurl==false ){
			$url = $twitter['url'];
		}
		
		// title
		if( !empty($twitter['title']) && $usegiventitle==false ){
			$title = $twitter['title'];
		}
		
		// count
		if( $twitter['count'] != 1 ){
			$count = 'data-count="none"';
		}else{ $count = ''; }
		
		$buttoncode = '<div class="pbTwitter"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$url.'" '.((!empty($title))?'data-text="'.$title.'"':'').' '.$count.' '.((!empty($twitter['via']))?'data-via="'.$twitter['via'].'"':'').' '.((!empty($twitter['lang']))?'data-lang="'.$twitter['lang'].'"':'').'>Twitter</a></div>';
		
		return($buttoncode);
	}
	
	function gplusButton($url,$usegivenurl=false){
		$gplus = get_option('pbsn_options_googleplus');
		
		// url
		if( !empty($gplus['url']) && $usegivenurl==false ){
			$url = $gplus['url'];
		}
		
		$buttoncode = '<div class="pbGplusone"><div class="g-plusone" '.((!empty($gplus['size']) && $gplus['size'] !='standard') ? 'data-size="'.$gplus['size'].'"':'').' '.((!empty($gplus['annotation']))?'data-annotation="'.$gplus['annotation'].'"':'').' '.((!empty($gplus['width']))?'data-width="'.$gplus['width'].'"':'').' data-href="'.$url.'"></div></div>';
		
		return($buttoncode);
	}
	
	function pinterestButton($url,$usegivenurl=false,$title=false,$usegiventitle=false,$img=false,$usegivenimg=false){
		$pinterest = get_option('pbsn_options_pinterest');
		
		// url
		if( !empty($pinterest['url']) && $usegivenurl==false ){
			$url = $pinterest['url'];
		}
		
		// title
		if( !empty($pinterest['title']) && $usegiventitle==false ){
			$title = $pinterest['title'];
		}

		// img
		if( !empty($pinterest['img']) && $usegivenimg==false ){
			$img = $pinterest['img'];
		}
		
		$buttoncode = '<div class="pbPinterest"><a href="http://pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($img).'&description='.urlencode($title).'" class="pin-it-button" count-layout="'.((!empty($pinterest['countlayout']))?$pinterest['countlayout']:'none').'"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>';
		
		return($buttoncode);
	}
	
	function addButtonContent($content){
		global $wp_query;
		
		$general = get_option('pbsn_options_general');
		$fb = get_option('pbsn_options_facebook');
		$twitter = get_option('pbsn_options_twitter');
		$gplus = get_option('pbsn_options_googleplus');
		$pinterest = get_option('pbsn_options_pinterest');
		
		$postID = $wp_query->post->ID;
		$postType = $wp_query->post->post_type;
		$postTitle = $wp_query->post->post_title;
		
		$postThumbID = get_post_thumbnail_id($postID);
		$postImage = wp_get_attachment_image_src($postThumbID);

		$url = parse_url(get_permalink($postID));
		$query = trim($url['query']);
		
		if( empty($query) ){
			$url = get_permalink($postID).'?pbsn=';
		}else{
			$url = get_permalink($postID).'&pbsn=';
		}
		
		$likebutton = $this->facebookLikeButton($url.'facebook');
		$twitterbutton = $this->twitterButton($url.'twitter',false,$postTitle);
		$gplusbutton = $this->gplusButton($url.'googleplus');
		$pinterestButton = $this->pinterestButton($url.'pinterest',false,$postTitle,false,$postImage[0]);
		
		if( ( $postType == 'post' && $general['articles']==1 ) || ( $postType == 'page' && $general['pages']==1 ) ){
			$buttoncode = '<div class="pbSocialNetworks">'.(($fb['status']==1)?$likebutton:'').(($twitter['status']==1)?$twitterbutton:'').(($gplus['status']==1)?$gplusbutton:'').(($pinterest['status']==1)?$pinterestButton:'').'</div>';
			
			if( $general['position'] == 'below' ){
				return(wpautop($content).$buttoncode);
			}else{
				return($buttoncode.wpautop($content));
			}
		}else{
			return(wpautop($content));
		}
	}
	
	function pbsnShortcode($atts){
		extract( shortcode_atts( array(
			'type' => false,
			'url' => false
		), $atts ) );
		
		if($type==false){
			return('<p><strong>[-> '.__('Hey, I miss some parameters here, try this example and replace me', 'pbSocialNetworks').':<br />[pbsn type="facebook"] <-]</strong></p>');
		}else{
			if( $url == false ){
				$url = parse_url(get_permalink(get_the_ID()));
			}
			
			$query = trim($url['query']);
			
			if( empty($query) ){
				$url = get_permalink($postID).'?pbsn=';
			}else{
				$url = get_permalink($postID).'&pbsn=';
			}
			
			$likebutton = $this->facebookLikeButton($url.'facebook', true);
			$twitterbutton = $this->twitterButton($url.'twitter', true, $postTitle);
			$gplusbutton = $this->gplusButton($url.'googleplus', true);
			$pinterestButton = $this->pinterestButton($url.'pinterest', true, $postTitle);
			
			if( $type == 'googleplus' ){
				return($gplusbutton);
			}elseif( $type == 'twitter' ){
				return($twitterbutton);
			}elseif( $type == 'pinterest' ){
				return($pinterestButton);
			}else{
				return($likebutton);
			}
		}
	}
	
}

new pbSocialNetworks;
?>