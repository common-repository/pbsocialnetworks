<?php
class pbSocialNetworksOptions extends pbStats {
	function initOptions(){
		if( !defined('WPLANG') ){
			define('WPLANG', 'en_US');
		}
		$gpluslang = explode('_', WPLANG);
		$gpluslang = $gpluslang[0];
	
		/******************** General Options ********************/
		if( get_option( 'pbsn_options_general' ) == false ) {
			add_option( 'pbsn_options_general' );
		}
		
		add_settings_section(
			'pbsn_options_general_section',
			__('pbSocialNetworks › General', 'pbSocialNetworks'),
			array(&$this, 'generalSectionCB'),
			'pbsn_options_general'
		);
		
		/*add_settings_field(
			'licence',
			__('Licence Key', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_general',
			'pbsn_options_general_section',
			array(
				'id' => 'licence',
				'section' => 'pbsn_options_general',
				'type' => 'text',
				'default' => false,
				'desc'=> sprintf(__('Enter your Item Purchase Code, you will find it in your <a href="%1$s" target="_blank">Licence Certificate</a>.', 'pbSocialNetworks'), plugins_url('img/purchase_code.png', __FILE__))
			)
		);*/
		
		add_settings_field(
			'status',
			__('Activate SocialNetworks', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_general',
			'pbsn_options_general_section',
			array(
				'id' => 'status',
				'section' => 'pbsn_options_general',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('This is the general setting to disable or enable pbSocialNetworks', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'statics',
			__('Activate Statics', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_general',
			'pbsn_options_general_section',
			array(
				'id' => 'statics',
				'section' => 'pbsn_options_general',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Here you can enable the static system to track your social network traffic', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'css',
			__('Include pbSocialNetworks CSS Styles', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_general',
			'pbsn_options_general_section',
			array(
				'id' => 'css',
				'section' => 'pbsn_options_general',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('This will include the default CSS for the Social Buttons, if you disable it you need to write your own styles', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'articles',
			__('Show Buttons on Article Pages', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_general',
			'pbsn_options_general_section',
			array(
				'id' => 'articles',
				'section' => 'pbsn_options_general',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Activate this checkbox to automatically include the Social Buttons on Article Pages', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'pages',
			__('Show Buttons on Pages', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_general',
			'pbsn_options_general_section',
			array(
				'id' => 'pages',
				'section' => 'pbsn_options_general',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Activate this checkbox to automatically include the Social Buttons on Pages', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'position',
			__('Button Position', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_general',
			'pbsn_options_general_section',
			array(
				'id' => 'position',
				'section' => 'pbsn_options_general',
				'type' => 'select',
				'default' => 'below',
				'desc'=> __('Display the Buttons below or above the content', 'pbSocialNetworks'),
				'selectbox' => array(
					'below' => __('below the content', 'pbSocialNetworks'),
					'above' => __('above the content', 'pbSocialNetworks')
				)
			)
		);
		
		register_setting('pbsn_options_general', 'pbsn_options_general');
		
		/******************** Facebook Options ********************/
		if( get_option( 'pbsn_options_facebook' ) == false ) {
			add_option( 'pbsn_options_facebook' );
		}
		
		add_settings_section(
			'pbsn_options_facebook_section',
			__('pbSocialNetworks › Facebook', 'pbSocialNetworks'),
			array(&$this, 'FacebookSectionCB'),
			'pbsn_options_facebook'
		);
		
		add_settings_field(
			'status',
			__('Activate Facebook Like Button', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'status',
				'section' => 'pbsn_options_facebook',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Activate Facebook Like Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'lang',
			__('Plugin Language', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'lang',
				'section' => 'pbsn_options_facebook',
				'type' => 'text',
				'default' => WPLANG,
				'desc'=> __('Language Code of the Facebook Plugin e.g. <code>en_US</code> for more details have a look <a href="https://developers.facebook.com/docs/internationalization/" target="_blank">here</a>', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'url',
			__('URL to Like', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'url',
				'section' => 'pbsn_options_facebook',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Leave blank to use the permalink of each article (<strong>recommended</strong>) or type a specific url to like', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'sendbutton',
			__('Send Button', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'sendbutton',
				'section' => 'pbsn_options_facebook',
				'type' => 'checkbox',
				'default' => 0,
				'desc'=> __('Activate Facebook Send Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'layout',
			__('Layout Style', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'layout',
				'section' => 'pbsn_options_facebook',
				'type' => 'select',
				'default' => 'button_count',
				'desc'=> __('Layout Style of the Like Button', 'pbSocialNetworks'),
				'selectbox' => array(
					'standard' => __('standard'),
					'button_count' => __('Button Count'),
					'box_count' => __('Box Count')
				)
			)
		);
		
		add_settings_field(
			'width',
			__('Width', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'width',
				'section' => 'pbsn_options_facebook',
				'type' => 'text',
				'default' => 100,
				'desc'=> __('width of the plugin, in pixels', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'faces',
			__('Show Faces', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'faces',
				'section' => 'pbsn_options_facebook',
				'type' => 'checkbox',
				'default' => 0,
				'desc'=> __('Show Profile Pictures below the Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'verb',
			__('Verb to display', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'verb',
				'section' => 'pbsn_options_facebook',
				'type' => 'select',
				'default' => 'like',
				'desc'=> __('The verb to display in the button', 'pbSocialNetworks'),
				'selectbox' => array(
					'like' => __('like', 'pbSocialNetworks'),
					'recommend' => __('recommend', 'pbSocialNetworks')
				)
			)
		);
		
		add_settings_field(
			'color',
			__('Color Scheme', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'color',
				'section' => 'pbsn_options_facebook',
				'type' => 'select',
				'default' => 'light',
				'desc'=> __('The verb to display in the button', 'pbSocialNetworks'),
				'selectbox' => array(
					'light' => __('light', 'pbSocialNetworks'),
					'dark' => __('dark', 'pbSocialNetworks')
				)
			)
		);
		
		add_settings_field(
			'font',
			__('Font', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_facebook',
			'pbsn_options_facebook_section',
			array(
				'id' => 'font',
				'section' => 'pbsn_options_facebook',
				'type' => 'select',
				'default' => 'standard',
				'desc'=> __('The font of the plugin', 'pbSocialNetworks'),
				'selectbox' => array(
					'standard' => __('standard', 'pbSocialNetworks'),
					'arial' => __('arial', 'pbSocialNetworks'),
					'lucida grande' => __('lucida grande', 'pbSocialNetworks'),
					'segoe ui' => __('segoe ui', 'pbSocialNetworks'),
					'tahoma' => __('tahoma', 'pbSocialNetworks'),
					'trebuchet ms' => __('trebuchet ms', 'pbSocialNetworks'),
					'verdana' => __('verdana', 'pbSocialNetworks')
				)
			)
		);
		
		register_setting('pbsn_options_facebook', 'pbsn_options_facebook');
		
		/******************** Open Graph Options ********************/
		if( get_option( 'pbsn_options_og' ) == false ) {
			add_option( 'pbsn_options_og' );
		}
		
		add_settings_section(
			'pbsn_options_og_section',
			__('pbSocialNetworks › Open Graph Protocol', 'pbSocialNetworks'),
			array(&$this, 'ogSectionCB'),
			'pbsn_options_og'
		);
		
		add_settings_field(
			'status',
			__('Activate Open Graph protocol', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'status',
				'section' => 'pbsn_options_og',
				'type' => 'checkbox',
				'default' => 0,
				'desc'=> __('Learn more about the <a href="http://ogp.me/" target="_blank">Open Graph protocol</a> at Facebooks <a href="https://developers.facebook.com/docs/opengraphprotocol/" target="_blank">Developer Page</a>', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'appid',
			__('AppId', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'appid',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('Your Facebook AppId', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'adminid',
			__('AdminId', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'adminid',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('Your Facebook Profile ID', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'sitename',
			__('Sitename', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'sitename',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => get_bloginfo('name'),
				'desc'=> ''
			)
		);
		
		add_settings_field(
			'type',
			__('Site-Type', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'type',
				'section' => 'pbsn_options_og',
				'type' => 'ogtype',
				'default' => 'website',
				'desc'=> __('You find more informations about types <a href="https://developers.facebook.com/docs/opengraphprotocol/#types" target="_blank">here</a>', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'pagetype',
			__('Page-Type', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'pagetype',
				'section' => 'pbsn_options_og',
				'type' => 'ogtype',
				'default' => 'website',
				'desc'=> __('You find more informations about types <a href="https://developers.facebook.com/docs/opengraphprotocol/#types" target="_blank">here</a>', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'articletype',
			__('Article-Type', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'articletype',
				'section' => 'pbsn_options_og',
				'type' => 'ogtype',
				'default' => 'article',
				'desc'=> __('You find more informations about types <a href="https://developers.facebook.com/docs/opengraphprotocol/#types" target="_blank">here</a>', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'hometitle',
			__('Home Title', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'hometitle',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => get_bloginfo('slogan'),
				'desc'=> __('Title for your homepage', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'homedesc',
			__('Home Description', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'homedesc',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('Description for your homepage', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'img',
			__('Image', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'img',
				'section' => 'pbsn_options_og',
				'type' => 'file',
				'default' => '',
				'desc'=> __('This is the default image for the homepage and all pages without article images', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'latitude',
			__('Latitude', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'latitude',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. 37.416343', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'longitude',
			__('Longitude', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'longitude',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. -122.153013', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'street',
			__('Street', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'street',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. 1601 S California Ave', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'locality',
			__('Locality', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'locality',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. Palo Alto', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'region',
			__('Region', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'region',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. CA', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'postalcode',
			__('Postal Code', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'postalcode',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. 94304', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'country',
			__('Country', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'country',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. USA', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'email',
			__('Email', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'email',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. me@gmail.com', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'phone',
			__('Phone', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'phone',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. +1-650-123-4567', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'fax',
			__('Fax', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_og',
			'pbsn_options_og_section',
			array(
				'id' => 'fax',
				'section' => 'pbsn_options_og',
				'type' => 'text',
				'default' => '',
				'desc'=> __('e.g. +1-415-123-4567', 'pbSocialNetworks')
			)
		);
				
		register_setting('pbsn_options_og', 'pbsn_options_og');
		
		/******************** Twitter Options ********************/
		if( get_option( 'pbsn_options_twitter' ) == false ) {
			add_option( 'pbsn_options_twitter' );
		}
		
		add_settings_section(
			'pbsn_options_twitter_section',
			__('pbSocialNetworks › Twitter', 'pbSocialNetworks'),
			array(&$this, 'TwitterSectionCB'),
			'pbsn_options_twitter'
		);
		
		add_settings_field(
			'status',
			__('Activate Twitter Button', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_twitter',
			'pbsn_options_twitter_section',
			array(
				'id' => 'status',
				'section' => 'pbsn_options_twitter',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Activate Twitter Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'count',
			__('Tweet count', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_twitter',
			'pbsn_options_twitter_section',
			array(
				'id' => 'count',
				'section' => 'pbsn_options_twitter',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Activate to show the Tweet count beside the button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'url',
			__('URL to share', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_twitter',
			'pbsn_options_twitter_section',
			array(
				'id' => 'url',
				'section' => 'pbsn_options_twitter',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Leave blank to use the permalink of each article (<strong>recommended</strong>) or type a specific url to share', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'tweet',
			__('Tweet Text to share', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_twitter',
			'pbsn_options_twitter_section',
			array(
				'id' => 'tweet',
				'section' => 'pbsn_options_twitter',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Leave blank to use the title of each article (<strong>recommended</strong>) or type a specific text to share', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'via',
			__('Via', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_twitter',
			'pbsn_options_twitter_section',
			array(
				'id' => 'via',
				'section' => 'pbsn_options_twitter',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Your Twitter Account for the <code>via @YourAccount</code> Part - without @', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'lang',
			__('Language', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_twitter',
			'pbsn_options_twitter_section',
			array(
				'id' => 'lang',
				'section' => 'pbsn_options_twitter',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Twitter detects the client language automatically, if you don\'t like this enter a fixed language code like <code>en</code>', 'pbSocialNetworks')
			)
		);
		
		register_setting('pbsn_options_twitter', 'pbsn_options_twitter');
		
		/******************** Google+ Options ********************/
		if( get_option( 'pbsn_options_googleplus' ) == false ) {
			add_option( 'pbsn_options_googleplus' );
		}
		
		add_settings_section(
			'pbsn_options_googleplus_section',
			__('pbSocialNetworks › Google+', 'pbSocialNetworks'),
			array(&$this, 'GoogleSectionCB'),
			'pbsn_options_googleplus'
		);
		
		add_settings_field(
			'status',
			__('Activate Google+ Button', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_googleplus',
			'pbsn_options_googleplus_section',
			array(
				'id' => 'status',
				'section' => 'pbsn_options_googleplus',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Activate Google+ Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'size',
			__('Button Size', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_googleplus',
			'pbsn_options_googleplus_section',
			array(
				'id' => 'size',
				'section' => 'pbsn_options_googleplus',
				'type' => 'select',
				'default' => 'medium',
				'desc'=> __('select the size of your g+ Button', 'pbSocialNetworks'),
				'selectbox' => array(
					'small' => __('small (15px)', 'pbSocialNetworks'),
					'medium' => __('medium (20px)', 'pbSocialNetworks'),
					'standard' => __('standard (24px)', 'pbSocialNetworks'),
					'tall' => __('tall (60px)', 'pbSocialNetworks')
					
				)
			)
		);
		
		add_settings_field(
			'annotation',
			__('Annotation', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_googleplus',
			'pbsn_options_googleplus_section',
			array(
				'id' => 'annotation',
				'section' => 'pbsn_options_googleplus',
				'type' => 'select',
				'default' => 'bubble',
				'desc'=> __('select the size of your g+ Button', 'pbSocialNetworks'),
				'selectbox' => array(
					'bubble' => __('bubble', 'pbSocialNetworks'),
					'inline' => __('inline', 'pbSocialNetworks'),
					'none' => __('none', 'pbSocialNetworks')
					
				)
			)
		);
		
		add_settings_field(
			'width',
			__('Width', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_googleplus',
			'pbsn_options_googleplus_section',
			array(
				'id' => 'width',
				'section' => 'pbsn_options_googleplus',
				'type' => 'text',
				'default' => 120,
				'desc'=> __('width of the g+ Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'lang',
			__('Language', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_googleplus',
			'pbsn_options_googleplus_section',
			array(
				'id' => 'lang',
				'section' => 'pbsn_options_googleplus',
				'type' => 'text',
				'default' => $gpluslang,
				'desc'=> __('language of your g+ Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'url',
			__('URL to Like', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_googleplus',
			'pbsn_options_googleplus_section',
			array(
				'id' => 'url',
				'section' => 'pbsn_options_googleplus',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Leave blank to use the permalink of each article (<strong>recommended</strong>) or type a specific url to like', 'pbSocialNetworks')
			)
		);
		
		register_setting('pbsn_options_googleplus', 'pbsn_options_googleplus');
		
		/******************** Pinterest Options ********************/
		if( get_option( 'pbsn_options_pinterest' ) == false ) {
			add_option( 'pbsn_options_pinterest' );
		}
		
		add_settings_section(
			'pbsn_options_pinterest_section',
			__('pbSocialNetworks › Pinterest', 'pbSocialNetworks'),
			array(&$this, 'PinterestSectionCB'),
			'pbsn_options_pinterest'
		);
		
		add_settings_field(
			'status',
			__('Activate Pin It Button', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_pinterest',
			'pbsn_options_pinterest_section',
			array(
				'id' => 'status',
				'section' => 'pbsn_options_pinterest',
				'type' => 'checkbox',
				'default' => 1,
				'desc'=> __('Activate Pin It Button', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'countlayout',
			__('Count Layout', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_pinterest',
			'pbsn_options_pinterest_section',
			array(
				'id' => 'countlayout',
				'section' => 'pbsn_options_pinterest',
				'type' => 'select',
				'default' => 'horizontal',
				'desc'=> __('select the count layout', 'pbSocialNetworks'),
				'selectbox' => array(
					'horizontal' => __('horizontal', 'pbSocialNetworks'),
					'vertical' => __('vertical', 'pbSocialNetworks'),
					'none' => __('none', 'pbSocialNetworks')
					
				)
			)
		);
		
		add_settings_field(
			'url',
			__('URL to pin', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_pinterest',
			'pbsn_options_pinterest_section',
			array(
				'id' => 'url',
				'section' => 'pbsn_options_pinterest',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Leave blank to use the permalink of each article (<strong>recommended</strong>) or type a specific url to pin', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'title',
			__('Pin Text to share', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_pinterest',
			'pbsn_options_pinterest_section',
			array(
				'id' => 'tweet',
				'section' => 'pbsn_options_pinterest',
				'type' => 'text',
				'default' => false,
				'desc'=> __('Leave blank to use the title of each article (<strong>recommended</strong>) or type a specific text to share', 'pbSocialNetworks')
			)
		);
		
		add_settings_field(
			'img',
			__('Image', 'pbSocialNetworks'),
			array(&$this, 'optionsField'),
			'pbsn_options_pinterest',
			'pbsn_options_pinterest_section',
			array(
				'id' => 'img',
				'section' => 'pbsn_options_pinterest',
				'type' => 'file',
				'default' => '',
				'desc'=> __('This is the default image for all pages without article images', 'pbSocialNetworks')
			)
		);
		
		register_setting('pbsn_options_pinterest', 'pbsn_options_pinterest');
	}
	
	function optionsField ($args){
		$options = get_option($args['section']);
		
		if( $args['type'] == 'text' ){
			if( empty($options[$args['id']]) ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			$html = '<input type="text" id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" class="regular-text" value="'.$val.'" />'; 
			if( !empty($args['desc']) ){
				$html .= '<p class="description">'.$args['desc'].'</p>';
			}
		}elseif( $args['type'] == 'checkbox' ){
			if( $options[$args['id']] === false ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			$html = '<input type="checkbox" id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" value="1" '.checked(1, $val, false).'/>'; 
			$html .= '<label for="'.$args['id'].'"> '.$args['desc'].'</label>'; 
		}elseif( $args['type'] == 'file' ){
			$html ='
			<label for="'.$args['id'].'" class="medialabel">
			<input id="'.$args['id'].'" type="text" size="36" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" value="'.$options[$args['id']].'" />
			<input id="'.$args['id'].'_button" rel="'.$args['id'].'" class="fileupload button" type="button" value="'.__('upload').'" />
			<br />'.$args['desc'].'
			</label>';
		}elseif( $args['type'] == 'colorpicker' ){
			if( empty($options[$args['id']]) ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			$html = '<label for="'.$args['id'].'"><input type="text" id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" class="color" value="'.$val.'" /> '.$args['desc'].'</label>
			<div id="ilctabscolorpicker" rel="'.$args['id'].'" class="ilctabscolorpicker"></div>';
		}elseif( $args['type'] == 'select' ){
			if( empty($options[$args['id']]) ){
				$selectedVal = $args['default'];
			}else{
				$selectedVal = $options[$args['id']];
			}
			
			$html = '<select id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'">';
			foreach( $args['selectbox'] as $key => $val ){
				if( $key == $selectedVal ){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
				$html .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
			}
			$html .= '</select>';
			if( !empty($args['desc']) ){
				$html .= '<p class="description">'.$args['desc'].'</p>';
			}
		}elseif( $args['type'] == 'ogtype' ){
			if( empty($options[$args['id']]) ){
				$selectedVal = $args['default'];
			}else{
				$selectedVal = $options[$args['id']];
			}
			
			$args['selectbox'] = array(
				'activity' => 'activity',
				'sport' => 'sport',
				'bar' => 'bar',
				'company' => 'company',
				'cafe' => 'cafe',
				'hotel' => 'hotel',
				'restaurant' => 'restaurant',
				'cause' => 'cause',
				'sports_league' => 'sports_league',
				'sports_team' => 'sports_team',
				'band' => 'band',
				'government' => 'government',
				'non_profit' => 'non_profit',
				'school' => 'school',
				'university' => 'university',
				'actor' => 'actor',
				'athlete' => 'athlete',
				'author' => 'author',
				'director' => 'director',
				'musician' => 'musician',
				'politician' => 'politician',
				'public_figure' => 'public_figure',
				'city' => 'city',
				'country' => 'country',
				'landmark' => 'landmark',
				'state_province' => 'state_province',
				'album' => 'album',
				'book' => 'book',
				'drink' => 'drink',
				'food' => 'food',
				'game' => 'game',
				'product' => 'product',
				'song' => 'song',
				'movie' => 'movie',
				'tv_show' => 'tv_show',
				'blog' => 'blog',
				'website' => 'website',
				'article' => 'article'
			);
			
			$html = '<select id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'">';
			foreach( $args['selectbox'] as $key => $val ){
				if( $key == $selectedVal ){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
				$html .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
			}
			$html .= '</select>';
			if( !empty($args['desc']) ){
				$html .= '<p class="description">'.$args['desc'].'</p>';
			}
		}
	
		echo $html;
	}
	
	function generalSectionCB() {
		_e('<p>In the general section you can change the basic configuration of pbSocialNetworks. Please Note: Before you activate pbSocialNetworks with the <code>Activate SocialNetworks</code> checkbox, <br /> you need to configure each Social Button, you find the different settings in the tabs Facebook, Twitter and Google+.</p><p><strong>Shortcodes:</strong><br />With pbSocialNetworks you get a helpful Shortcode to include Social Network Buttons in your Articles or Pages:<br />Use this Shortcode in your Articles or Pages: <code>[pbsn type="facebook" url="http://www.pascal-bajorat.com/"]</code><br />Values for <code>type:</code> facebook, twitter, googleplus or pinterest<br />Values for <code>url:</code> You don`t need to specify the url if you want use automatically the Article / Page Permalink or you can set a fixed url.<br />Use this PHP Code to run pbsn Shortcode in your Theme: <code>&lt;?php echo do_shortcode(\'[pbsn type="facebook" url="http://www.pascal-bajorat.com/"]\'); ?&gt;</code></p>', 'pbSocialNetworks');
	}
	
	function FacebookSectionCB() {
		_e('<p>In this section you can configure the Facebook Like Button. If you enable or disable some features you need to adjust the width too.</p>', 'pbSocialNetworks');
	}
	
	function TwitterSectionCB() {
		_e('<p>In this section you can configure the Twitter Button.</p>', 'pbSocialNetworks');
	}
	
	function GoogleSectionCB() {
		_e('<p>In this section you can configure the Google+ Button.</p>', 'pbSocialNetworks');
	}
	
	function PinterestSectionCB() {
		_e('<p>In this section you can configure the Pin It Button. You can modify the submitted data to Pinterest with Open Graph e.g. Description and image to pin.</p>', 'pbSocialNetworks');
	}
	
	function ogSectionCB() {
		_e('<p>In this section you can configure the Open Graph Protocol. Leave fields blank to hide them in the sourcecode. <strong>But it\'s important that you fill AppId or AdminId</strong></p>', 'pbSocialNetworks');
	}
	
	function OptionsPageHeader($active='general'){
		$general = get_option('pbsn_options_general');
		//$licence = trim($general['licence']);
	?>
	<div class="icon32"><a href="http://www.pascal-bajorat.com" target="_blank"><img src="<?php echo plugins_url('/img/icon_36.png', __FILE__) ?>" alt="Pascal-Bajorat.com" title="Pascal-Bajorat.com" /></a></div><h2><?php _e($this->Name); ?></h2>
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo('admin.php?page='.$this->PluginFolder.'/pbSocialNetworks.php'); ?>" class="nav-tab <?php if($active=='general'){echo('nav-tab-active');} ?>"><?php _e('General', 'pbSocialNetworks'); ?></a>
		<a href="<?php echo('admin.php?page='.$this->PluginFolder.'/facebook.php'); ?>" class="nav-tab <?php if($active=='facebook'){echo('nav-tab-active');} ?>"><?php _e('Facebook', 'pbSocialNetworks'); ?></a>
		<a href="<?php echo('admin.php?page='.$this->PluginFolder.'/twitter.php'); ?>" class="nav-tab <?php if($active=='twitter'){echo('nav-tab-active');} ?>"><?php _e('Twitter', 'pbSocialNetworks'); ?></a>
		<a href="<?php echo('admin.php?page='.$this->PluginFolder.'/googleplus.php'); ?>" class="nav-tab <?php if($active=='googleplus'){echo('nav-tab-active');} ?>"><?php _e('Google+', 'pbSocialNetworks'); ?></a>
		<a href="<?php echo('admin.php?page='.$this->PluginFolder.'/pinterest.php'); ?>" class="nav-tab <?php if($active=='pinterest'){echo('nav-tab-active');} ?>"><?php _e('Pinterest', 'pbSocialNetworks'); ?></a>
		<a href="<?php echo('admin.php?page='.$this->PluginFolder.'/opengraph.php'); ?>" class="nav-tab <?php if($active=='opengraph'){echo('nav-tab-active');} ?>"><?php _e('Open Graph', 'pbSocialNetworks'); ?></a>
		<a href="<?php echo('admin.php?page='.$this->PluginFolder.'/stats.php'); ?>" class="nav-tab <?php if($active=='stats'){echo('nav-tab-active');} ?>"><?php _e('Stats', 'pbSocialNetworks'); ?></a>
		<!--a href="<?php echo('admin.php?page='.$this->PluginFolder.'/support.php'); ?>" class="nav-tab <?php if($active=='support'){echo('nav-tab-active');} ?>"><?php _e('Support', 'pbSocialNetworks'); ?></a-->
	</h2>
	<?php /* if( empty($licence) ): ?>
	<div class="error below-h2"><p><strong><?php _e('Please enter a valid Licence key / Item Purchase Code to receive further updates of this Plugin!', 'pbSocialNetworks'); ?></strong></p></div>
	<?php
	endif;*/
	}
	
	function OptionPageFooter(){
	?>
	<script language="JavaScript">
	var wpMediaUploadHelper = false;
	jQuery(document).ready(function() {
		var formfield;
		
		jQuery('.fileupload').click(function() {
			wpMediaUploadHelper = jQuery(this).attr('rel');
			formfield = jQuery('#'+wpMediaUploadHelper).attr('name');
			tb_show('', 'media-upload.php?type=image&TB_iframe=true');

			window.pbsocialnetworks_original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html){
				if (formfield){
					imgurl = jQuery('img',html).attr('src');
					jQuery('#'+wpMediaUploadHelper).val(imgurl);
					formfield = false;
					tb_remove();

					window.send_to_editor = window.pbsocialnetworks_original_send_to_editor;
				}else{
					window.pbsocialnetworks_original_send_to_editor(html);
				}
			}

			return false;
		});
		
		jQuery('.ilctabscolorpicker').each(function(){
			var relID = '#'+jQuery(this).attr('rel');
			var $this = jQuery(this);
			
			$this.hide();
			$this.farbtastic(relID);
			jQuery(relID).click(function(){$this.slideDown('slow')});
			
			jQuery(document).mousedown(function(){
				$this.slideUp('slow');
			});
		});
		
	});
	</script>
	<?php
	}
	
	function OptionsPage (){
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader(); ?>
	
	<?php settings_errors(); ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'pbsn_options_general' ); ?>
		<?php do_settings_sections( 'pbsn_options_general' ); ?>
		<?php submit_button(); ?>
	</form>
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
	
	function OptionsPageFB (){
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader('facebook'); ?>
	
	<?php settings_errors(); ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'pbsn_options_facebook' ); ?>
		<?php do_settings_sections( 'pbsn_options_facebook' ); ?>
		<?php submit_button(); ?>
	</form>
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
	
	function OptionsPageOG (){
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader('opengraph'); ?>
	
	<?php settings_errors(); ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'pbsn_options_og' ); ?>
		<?php do_settings_sections( 'pbsn_options_og' ); ?>
		<?php submit_button(); ?>
	</form>
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
	
	function OptionsPageTwitter (){
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader('twitter'); ?>
	
	<?php settings_errors(); ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'pbsn_options_twitter' ); ?>
		<?php do_settings_sections( 'pbsn_options_twitter' ); ?>
		<?php submit_button(); ?>
	</form>
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
	
	function OptionsPageGoogle (){
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader('googleplus'); ?>
	
	<?php settings_errors(); ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'pbsn_options_googleplus' ); ?>
		<?php do_settings_sections( 'pbsn_options_googleplus' ); ?>
		<?php submit_button(); ?>
	</form>
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
	
	function OptionsPagePinterest (){
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader('pinterest'); ?>
	
	<?php settings_errors(); ?>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'pbsn_options_pinterest' ); ?>
		<?php do_settings_sections( 'pbsn_options_pinterest' ); ?>
		<?php submit_button(); ?>
	</form>
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
	
	function SupportPage (){
	?>
	<div class="wrap">
	<?php $this->OptionsPageHeader(); ?>
	<h3><?php _e('pbSocialNetworks › Support', 'pbSocialNetworks'); ?></h3>
	<iframe src="<?php _e('http://www.pascal-bajorat.com/en/pbsocialnetworks-support/'); ?>" frameborder="0" width="100%" height="750" scrolling="auto"></iframe>
	
	<?php $this->OptionPageFooter(); ?>
	</div>
	<?php
	}
}
?>