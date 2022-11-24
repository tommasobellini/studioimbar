<?php

$zoacres_options = get_option( 'zoacres_options' );

/* Zoacres Page Options */
$prefix = 'zoacres_post_';

$fields = array(
	array( 
		'label'	=> esc_html__( 'Post General Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are single post general settings.', 'zoacres' ), 
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Post Layout', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post layout for current post single view.', 'zoacres' ), 
		'id'	=> $prefix.'layout',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'wide' => esc_html__( 'Wide', 'zoacres' ),
			'boxed' => esc_html__( 'Boxed', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Post Content Padding Option', 'zoacres' ),
		'id'	=> $prefix.'content_padding_opt',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'		
	),
	array( 
		'label'	=> esc_html__( 'Post Content Padding', 'zoacres' ), 
		'desc'	=> esc_html__( 'Set the top/right/bottom/left padding of post content.', 'zoacres' ),
		'id'	=> $prefix.'content_padding',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'space',
		'required'	=> array( $prefix.'content_padding_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Template Option', 'zoacres' ),
		'id'	=> $prefix.'template_opt',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'		
	),
	array( 
		'label'	=> esc_html__( 'Post Template', 'zoacres' ),
		'id'	=> $prefix.'template',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'image_select',
		'options' => array(
			'no-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/1.png' ), 
			'right-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/2.png' ), 
			'left-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/3.png' ), 
			'both-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/4.png' ), 
		),
		'default'	=> 'right-sidebar',
		'required'	=> array( $prefix.'template_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Left Sidebar', 'zoacres' ),
		'id'	=> $prefix.'left_sidebar',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'template_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Right Sidebar', 'zoacres' ),
		'id'	=> $prefix.'right_sidebar',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'template_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Sidebar On Mobile', 'zoacres' ),
		'id'	=> $prefix.'sidebar_mobile',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Show', 'zoacres' ),
			'0' => esc_html__( 'Hide', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Featured Slider', 'zoacres' ),
		'id'	=> $prefix.'featured_slider',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Full Width Wrap', 'zoacres' ),
		'id'	=> $prefix.'full_wrap',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Post Items Option', 'zoacres' ),
		'id'	=> $prefix.'items_opt',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'		
	),
	array( 
		'label'	=> esc_html__( 'Post Items', 'zoacres' ),
		'desc'	=> esc_html__( 'Needed single post items drag from disabled and put enabled part.', 'zoacres' ),
		'id'	=> $prefix.'items',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'dragdrop',
		'options' => array ( 
			'all' => array( 'title', 'top-meta', 'thumb', 'content', 'bottom-meta' ),
			'items' => array( 
				'title' 	=> esc_html__( 'Title', 'zoacres' ),
				'top-meta'	=> esc_html__( 'Top Meta', 'zoacres' ),
				'thumb' 	=> esc_html__( 'Thumbnail', 'zoacres' ),
				'content' 	=> esc_html__( 'Content', 'zoacres' ),
				'bottom-meta'		=> esc_html__( 'Bottom Meta', 'zoacres' )
			)
		),
		'default'	=> 'title,top-meta,thumb,content,bottom-meta',
		'required'	=> array( $prefix.'items_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Overlay', 'zoacres' ),
		'id'	=> $prefix.'overlay_opt',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Post Overlay Items', 'zoacres' ),
		'desc'	=> esc_html__( 'Needed overlay post items drag from disabled and put enabled part.', 'zoacres' ),
		'id'	=> $prefix.'overlay_items',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'dragdrop',
		'options' => array ( 
			'all' => array( 'title', 'top-meta', 'bottom-meta' ),
			'items' => array( 
				'title' 	=> esc_html__( 'Title', 'zoacres' ),
				'top-meta'	=> esc_html__( 'Top Meta', 'zoacres' ),
				'bottom-meta'		=> esc_html__( 'Bottom Meta', 'zoacres' )
			)
		),
		'default'	=> 'title',
		'required'	=> array( $prefix.'overlay_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Page Items Option', 'zoacres' ),
		'id'	=> $prefix.'page_items_opt',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'		
	),
	array( 
		'label'	=> esc_html__( 'Post Page Items', 'zoacres' ),
		'desc'	=> esc_html__( 'Needed post page items drag from disabled and put enabled part.', 'zoacres' ),
		'id'	=> $prefix.'page_items',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'dragdrop',
		'options' => array ( 
			'all' => array( 'post-items', 'author-info', 'related-slider', 'post-nav', 'comment' ),
			'items' => array( 
				'post-items' 	=> esc_html__( 'Post Items', 'zoacres' ),
				'author-info'	=> esc_html__( 'Author Info', 'zoacres' ),
				'related-slider'=> esc_html__( 'Related Slider', 'zoacres' ),
				'post-nav' 	=> esc_html__( 'Post Nav', 'zoacres' ),
				'comment' 	=> esc_html__( 'Comment', 'zoacres' )
			)
		),
		'default'	=> 'post-items,author-info,related-slider,post-nav,comment',
		'required'	=> array( $prefix.'page_items_opt', 'custom' )
	),
	//Header
	array( 
		'label'	=> esc_html__( 'Header General Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header general settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Layout', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post layout for current post header layout.', 'zoacres' ), 
		'id'	=> $prefix.'header_layout',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'wide' => esc_html__( 'Wide', 'zoacres' ),
			'boxed' => esc_html__( 'Boxed', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Type', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post layout for current post header type.', 'zoacres' ), 
		'id'	=> $prefix.'header_type',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'default' => esc_html__( 'Default', 'zoacres' ),
			'left-sticky' => esc_html__( 'Left Sticky', 'zoacres' ),
			'right-sticky' => esc_html__( 'Right Sticky', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Background Image', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header background image for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'image',
		'id'	=> $prefix.'header_bg_img',
		'required'	=> array( $prefix.'header_type', 'default' )
	),
	array( 
		'label'	=> esc_html__( 'Header Items Options', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
		'id'	=> $prefix.'header_items_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header general items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'header_items',
		'dd_fields' => array ( 
			'Normal' => array( 
				'header-topbar' 	=> esc_html__( 'Topbar', 'zoacres' ),
				'header-logo'	=> esc_html__( 'Logo Bar', 'zoacres' )
			),
			'Sticky' => array( 
				'header-nav' 	=> esc_html__( 'Navbar', 'zoacres' )
			),
			'disabled' => array()
		),
		'required'	=> array( $prefix.'header_items_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Absolute Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header absolute to change header look transparent.', 'zoacres' ), 
		'id'	=> $prefix.'header_absolute_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header sticky options.', 'zoacres' ), 
		'id'	=> $prefix.'header_sticky_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'sticky' => esc_html__( 'Header Sticky Part', 'zoacres' ),
			'sticky-scroll' => esc_html__( 'Sticky Scroll Up', 'zoacres' ),
			'none' => esc_html__( 'None', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Options', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
		'id'	=> $prefix.'header_topbar_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Height', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar height for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dimension',
		'id'	=> $prefix.'header_topbar_height',
		'property' => 'height',
		'required'	=> array( $prefix.'header_topbar_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Sticky Height', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar sticky height for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dimension',
		'id'	=> $prefix.'header_topbar_sticky_height',
		'property' => 'height',
		'required'	=> array( $prefix.'header_topbar_opt', 'custom' )
	),
	array( 
		'label'	=> '',
		'desc'	=> esc_html__( 'These all are header topbar skin settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header topbar skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'header_topbar_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'header_topbar_font',
		'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'header_topbar_bg',
		'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'header_topbar_link',
		'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'header_topbar_border',
		'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'header_topbar_padding',
		'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Sticky Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header top barsticky skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'header_topbar_sticky_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Sticky Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header top barsticky font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'header_topbar_sticky_font',
		'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Sticky Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header top barsticky background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'header_topbar_sticky_bg',
		'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Sticky Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header top barsticky link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'header_topbar_sticky_link',
		'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Sticky Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header top barsticky border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'header_topbar_sticky_border',
		'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Sticky Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header top barsticky padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'header_topbar_sticky_padding',
		'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Items Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header topbar items enable options.', 'zoacres' ), 
		'id'	=> $prefix.'header_topbar_items_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Top Bar Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header topbar items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'header_topbar_items',
		'dd_fields' => array ( 
			'Left'  => array(
				'header-topbar-date' => esc_html__( 'Date', 'zoacres' ),						
			),
			'Center' => array(),
			'Right' => array(),
			'disabled' => array(
				'header-topbar-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
				'header-topbar-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
				'header-topbar-menu'    => esc_html__( 'Top Bar Menu', 'zoacres' ),
				'header-topbar-social'	=> esc_html__( 'Social', 'zoacres' ),
				'header-topbar-search'	=> esc_html__( 'Search', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'header_topbar_items_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Options', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
		'id'	=> $prefix.'header_logo_bar_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Height', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar height for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dimension',
		'id'	=> $prefix.'header_logo_bar_height',
		'property' => 'height',
		'required'	=> array( $prefix.'header_logo_bar_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Sticky Height', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar sticky height for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dimension',
		'id'	=> $prefix.'header_logo_bar_sticky_height',
		'property' => 'height',
		'required'	=> array( $prefix.'header_logo_bar_opt', 'custom' )
	),
	array( 
		'label'	=> '',
		'desc'	=> esc_html__( 'These all are header logo bar skin settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header logo bar skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'header_logo_bar_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'header_logo_bar_font',
		'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'header_logo_bar_bg',
		'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'header_logo_bar_link',
		'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'header_logo_bar_border',
		'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'header_logo_bar_padding',
		'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Sticky Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header logo bar sticky skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'header_logobar_sticky_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Sticky Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar sticky font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'header_logobar_sticky_font',
		'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Sticky Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar sticky background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'header_logobar_sticky_bg',
		'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Sticky Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar sticky link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'header_logobar_sticky_link',
		'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Sticky Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar sticky border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'header_logobar_sticky_border',
		'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Sticky Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar sticky padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'header_logobar_sticky_padding',
		'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Items Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header logo bar items enable options.', 'zoacres' ), 
		'id'	=> $prefix.'header_logo_bar_items_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Logo Bar Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header logo bar items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'header_logo_bar_items',
		'dd_fields' => array ( 
			'Left'  => array(),
			'Center' => array(
				'header-logobar-logo'	=> esc_html__( 'Logo', 'zoacres' ),
			),
			'Right' => array(),
			'disabled' => array(
				'header-logobar-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
				'header-logobar-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
				'header-logobar-menu'    => esc_html__( 'Main Menu', 'zoacres' ),
				'header-logobar-social'	=> esc_html__( 'Social', 'zoacres' ),
				'header-logobar-search'	=> esc_html__( 'Search', 'zoacres' ),
				'header-logobar-secondary-toggle'	=> esc_html__( 'Secondary Toggle', 'zoacres' ),
				'header-logobar-search-toggle'	=> esc_html__( 'Search Toggle', 'zoacres' ),
				'header-logobar-sticky-logo'	=> esc_html__( 'Stikcy Logo', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'header_logo_bar_items_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Options', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
		'id'	=> $prefix.'header_navbar_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Height', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar height for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dimension',
		'id'	=> $prefix.'header_navbar_height',
		'property' => 'height',
		'required'	=> array( $prefix.'header_navbar_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Sticky Height', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar sticky height for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dimension',
		'id'	=> $prefix.'header_navbar_sticky_height',
		'property' => 'height',
		'required'	=> array( $prefix.'header_navbar_opt', 'custom' )
	),
	array( 
		'label'	=> '',
		'desc'	=> esc_html__( 'These all are header navbar skin settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header navbar skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'header_navbar_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'header_navbar_font',
		'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'header_navbar_bg',
		'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'header_navbar_link',
		'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'header_navbar_border',
		'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'header_navbar_padding',
		'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Sticky Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header navbar sticky skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'header_navbar_sticky_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Sticky Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar sticky font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'header_navbar_sticky_font',
		'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Sticky Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar sticky background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'header_navbar_sticky_bg',
		'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Sticky Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar sticky link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'header_navbar_sticky_link',
		'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Sticky Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar sticky border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'header_navbar_sticky_border',
		'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Sticky Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar sticky padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'header_navbar_sticky_padding',
		'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Items Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header navbar items enable options.', 'zoacres' ), 
		'id'	=> $prefix.'header_navbar_items_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Navbar Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header navbar items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'header_navbar_items',
		'dd_fields' => array ( 
			'Left'  => array(											
				'header-navbar-menu'    => esc_html__( 'Main Menu', 'zoacres' ),
			),
			'Center' => array(
			),
			'Right' => array(
				'header-navbar-search'	=> esc_html__( 'Search', 'zoacres' ),
			),
			'disabled' => array(
				'header-navbar-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
				'header-navbar-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
				'header-navbar-logo'	=> esc_html__( 'Logo', 'zoacres' ),
				'header-navbar-social'	=> esc_html__( 'Social', 'zoacres' ),
				'header-navbar-secondary-toggle'	=> esc_html__( 'Secondary Toggle', 'zoacres' ),
				'header-navbar-search-toggle'	=> esc_html__( 'Search Toggle', 'zoacres' ),
				'header-navbar-sticky-logo'	=> esc_html__( 'Stikcy Logo', 'zoacres' ),
			)
		),
		'required'	=> array( $prefix.'header_navbar_items_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Options', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header sticky part option.', 'zoacres' ), 
		'id'	=> $prefix.'header_stikcy_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Width', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky part width for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dimension',
		'id'	=> $prefix.'header_stikcy_width',
		'property' => 'width',
		'required'	=> array( $prefix.'header_stikcy_opt', 'custom' )
	),
	array( 
		'label'	=> '',
		'desc'	=> esc_html__( 'These all are header sticky skin settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header sticky skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'header_stikcy_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'header_stikcy_font',
		'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'header_stikcy_bg',
		'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'header_stikcy_link',
		'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'header_stikcy_border',
		'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'header_stikcy_padding',
		'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Items Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose header sticky items enable options.', 'zoacres' ), 
		'id'	=> $prefix.'header_stikcy_items_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Header Sticky/Fixed Part Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are header sticky items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'header_stikcy_items',
		'dd_fields' => array ( 
			'Top'  => array(
				'header-fixed-logo' => esc_html__( 'Logo', 'zoacres' )
			),
			'Middle'  => array(
				'header-fixed-menu'	=> esc_html__( 'Menu', 'zoacres' )					
			),
			'Bottom'  => array(
				'header-fixed-social'	=> esc_html__( 'Social', 'zoacres' )					
			),
			'disabled' => array(
				'header-fixed-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
				'header-fixed-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
				'header-fixed-search'	=> esc_html__( 'Search Form', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'header_stikcy_items_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Bar', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title bar settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Post Title Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post title enable or disable.', 'zoacres' ), 
		'id'	=> $prefix.'header_post_title_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Post Title Text', 'zoacres' ),
		'desc'	=> esc_html__( 'If this post title is empty, then showing current post default title.', 'zoacres' ), 
		'id'	=> $prefix.'header_post_title_text',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> '',
		'required'	=> array( $prefix.'header_post_title_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Description', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter post title description.', 'zoacres' ), 
		'id'	=> $prefix.'header_post_title_desc',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'textarea',
		'default'	=> '',
		'required'	=> array( $prefix.'header_post_title_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Background Parallax', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post title background parallax.', 'zoacres' ), 
		'id'	=> $prefix.'header_post_title_parallax',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default',
		'required'	=> array( $prefix.'header_post_title_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Background Video Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post title background video option.', 'zoacres' ), 
		'id'	=> $prefix.'header_post_title_video_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default',
		'required'	=> array( $prefix.'header_post_title_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Background Video', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter youtube video ID. Example: ZSt9tm3RoUU.', 'zoacres' ), 
		'id'	=> $prefix.'header_post_title_video',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> '',
		'required'	=> array( $prefix.'header_post_title_video_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Bar Items Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post title bar items option.', 'zoacres' ), 
		'id'	=> $prefix.'post_title_items_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default',
		'required'	=> array( $prefix.'header_post_title_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Bar Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title bar items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'post_title_items',
		'dd_fields' => array ( 
			'Left'  => array(
				'title' => esc_html__( 'Post Title Text', 'zoacres' ),
			),
			'Center'  => array(
				
			),
			'Right'  => array(
				'breadcrumb'	=> esc_html__( 'Breadcrumb', 'zoacres' )
			),
			'disabled' => array()
		),
		'required'	=> array( $prefix.'post_title_items_opt', 'custom' )
	),
	array( 
		'label'	=> '',
		'desc'	=> esc_html__( 'These all are post title skin settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'label',
		'required'	=> array( $prefix.'header_post_title_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose post title skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'post_title_skin_opt',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default',
		'required'	=> array( $prefix.'header_post_title_opt', '1' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'post_title_font',
		'required'	=> array( $prefix.'post_title_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Background Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'post_title_bg',
		'required'	=> array( $prefix.'post_title_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Background Image', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter post title background image url.', 'zoacres' ), 
		'id'	=> $prefix.'post_title_bg_img',
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> '',
		'required'	=> array( $prefix.'post_title_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'post_title_link',
		'required'	=> array( $prefix.'post_title_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'post_title_border',
		'required'	=> array( $prefix.'post_title_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'post_title_padding',
		'required'	=> array( $prefix.'post_title_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Post Title Overlay', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are post title overlay color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Header', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'post_title_overlay',
		'required'	=> array( $prefix.'post_title_skin_opt', 'custom' )
	),
	//Footer
	array( 
		'label'	=> 'Footer General',
		'desc'	=> esc_html__( 'These all are header footer settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Layout', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer layout for current post.', 'zoacres' ), 
		'id'	=> $prefix.'footer_layout',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'wide' => esc_html__( 'Wide', 'zoacres' ),
			'boxed' => esc_html__( 'Boxed', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Hidden Footer', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose hidden footer option.', 'zoacres' ), 
		'id'	=> $prefix.'hidden_footer',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> '',
		'desc'	=> esc_html__( 'These all are footer skin settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Skin Settings', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer skin settings options.', 'zoacres' ), 
		'id'	=> $prefix.'footer_skin_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'footer_font',
		'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Background Image', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer background image for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'image',
		'id'	=> $prefix.'footer_bg_img',
		'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Background Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'footer_bg',
		'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Background Overlay', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer background overlay color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'footer_bg_overlay',
		'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'footer_link',
		'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'footer_border',
		'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'footer_padding',
		'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Items Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer items enable options.', 'zoacres' ), 
		'id'	=> $prefix.'footer_items_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'footer_items',
		'dd_fields' => array ( 
			'Enabled'  => array(
				'footer-bottom'	=> esc_html__( 'Footer Bottom', 'zoacres' )
			),
			'disabled' => array(
				'footer-top' => esc_html__( 'Footer Top', 'zoacres' ),
				'footer-middle'	=> esc_html__( 'Footer Middle', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'footer_items_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Top',
		'desc'	=> esc_html__( 'These all are footer top settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Top Skin', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer top skin options.', 'zoacres' ), 
		'id'	=> $prefix.'footer_top_skin_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Top Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer top font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'footer_top_font',
		'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Top Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'footer_top_bg',
		'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Top Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer top link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'footer_top_link',
		'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Top Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer top border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'footer_top_border',
		'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Top Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer top padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'footer_top_padding',
		'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Top Columns and Sidebars Settings',
		'desc'	=> esc_html__( 'These all are footer top columns and sidebar settings.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Layout Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer layout option.', 'zoacres' ), 
		'id'	=> $prefix.'footer_top_layout_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Layout', 'zoacres' ),
		'id'	=> $prefix.'footer_top_layout',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'image_select',
		'options' => array(
			'3-3-3-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-1.png', 
			'4-4-4'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-2.png', 
			'3-6-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-3.png', 
			'6-6'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-4.png', 
			'9-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-5.png', 
			'3-9'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-6.png', 
			'12'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-7.png'
		),
		'default'	=> '4-4-4',
		'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer First Column',
		'desc'	=> esc_html__( 'Select footer first column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_top_sidebar_1',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Second Column',
		'desc'	=> esc_html__( 'Select footer second column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_top_sidebar_2',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Third Column',
		'desc'	=> esc_html__( 'Select footer third column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_top_sidebar_3',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Fourth Column',
		'desc'	=> esc_html__( 'Select footer fourth column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_top_sidebar_4',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Middle',
		'desc'	=> esc_html__( 'These all are footer middle settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Middle Skin', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer middle skin options.', 'zoacres' ), 
		'id'	=> $prefix.'footer_middle_skin_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Middle Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer middle font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'footer_middle_font',
		'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Middle Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'footer_middle_bg',
		'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Middle Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer middle link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'footer_middle_link',
		'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Middle Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer middle border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'footer_middle_border',
		'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Middle Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer middle padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'footer_middle_padding',
		'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Middle Columns and Sidebars Settings',
		'desc'	=> esc_html__( 'These all are footer middle columns and sidebar settings.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Layout Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer layout option.', 'zoacres' ), 
		'id'	=> $prefix.'footer_middle_layout_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Layout', 'zoacres' ),
		'id'	=> $prefix.'footer_middle_layout',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'image_select',
		'options' => array(
			'3-3-3-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-1.png', 
			'4-4-4'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-2.png', 
			'3-6-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-3.png', 
			'6-6'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-4.png', 
			'9-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-5.png', 
			'3-9'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-6.png', 
			'12'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-7.png'
		),
		'default'	=> '4-4-4',
		'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer First Column',
		'desc'	=> esc_html__( 'Select footer first column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_middle_sidebar_1',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Second Column',
		'desc'	=> esc_html__( 'Select footer second column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_middle_sidebar_2',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Third Column',
		'desc'	=> esc_html__( 'Select footer third column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_middle_sidebar_3',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Fourth Column',
		'desc'	=> esc_html__( 'Select footer fourth column widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_middle_sidebar_4',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
	),
	array( 
		'label'	=> 'Footer Bottom',
		'desc'	=> esc_html__( 'These all are footer bottom settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Fixed', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer bottom fixed option.', 'zoacres' ), 
		'id'	=> $prefix.'footer_bottom_fixed',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'1' => esc_html__( 'Enable', 'zoacres' ),
			'0' => esc_html__( 'Disable', 'zoacres' )			
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> '',
		'desc'	=> esc_html__( 'These all are footer bottom skin settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Skin', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer bottom skin options.', 'zoacres' ), 
		'id'	=> $prefix.'footer_bottom_skin_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Font Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer bottom font color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'color',
		'id'	=> $prefix.'footer_bottom_font',
		'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Background', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer bottom background color for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'alpha_color',
		'id'	=> $prefix.'footer_bottom_bg',
		'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Link Color', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer bottom link color settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'link_color',
		'id'	=> $prefix.'footer_bottom_link',
		'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Border', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer bottom border settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'color' => 1,
		'border_style' => 1,
		'id'	=> $prefix.'footer_bottom_border',
		'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Padding', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer bottom padding settings for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'space',
		'id'	=> $prefix.'footer_bottom_padding',
		'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Widget Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer bottom widget options.', 'zoacres' ), 
		'id'	=> $prefix.'footer_bottom_widget_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> 'Footer Bottom Widget',
		'desc'	=> esc_html__( 'Select footer bottom widget.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'id'	=> $prefix.'footer_bottom_widget',
		'type'	=> 'sidebar',
		'required'	=> array( $prefix.'footer_bottom_widget_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Items Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose footer bottom items options.', 'zoacres' ), 
		'id'	=> $prefix.'footer_bottom_items_opt',
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Footer Bottom Items', 'zoacres' ),
		'desc'	=> esc_html__( 'These all are footer bottom items for current post.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Footer', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'id'	=> $prefix.'footer_bottom_items',
		'dd_fields' => array ( 
			'Left'  => array(
				'copyright' => esc_html__( 'Copyright Text', 'zoacres' )
			),
			'Center'  => array(
				'menu'	=> esc_html__( 'Footer Menu', 'zoacres' )
			),
			'Right'  => array(),
			'disabled' => array(
				'social'	=> esc_html__( 'Footer Social Links', 'zoacres' ),
				'widget'	=> esc_html__( 'Custom Widget', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'footer_bottom_items_opt', 'custom' )
	),
	//Header Slider
	array( 
		'label'	=> esc_html__( 'Slider', 'zoacres' ),
		'desc'	=> esc_html__( 'This header slider settings.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Slider', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Slider Option', 'zoacres' ),
		'id'	=> $prefix.'header_slider_opt',
		'tab'	=> esc_html__( 'Slider', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'bottom' => esc_html__( 'Below Header', 'zoacres' ),
			'top' => esc_html__( 'Above Header', 'zoacres' ),
			'none' => esc_html__( 'None', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Slider Shortcode', 'zoacres' ),
		'desc'	=> esc_html__( 'This is the place for enter slider shortcode. Example revolution slider shortcodes.', 'zoacres' ), 
		'id'	=> $prefix.'header_slider',
		'tab'	=> esc_html__( 'Slider', 'zoacres' ),
		'type'	=> 'textarea',
		'default'	=> ''
	),
	//Post Format
	array( 
		'label'	=> esc_html__( 'Video', 'zoacres' ),
		'desc'	=> esc_html__( 'This part for if you choosed video format, then you must choose video type and give video id.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Video Modal', 'zoacres' ),
		'id'	=> $prefix.'video_modal',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'onclick' => esc_html__( 'On Click Run Video', 'zoacres' ),
			'overlay' => esc_html__( 'Modal Box Video', 'zoacres' ),
			'direct' => esc_html__( 'Direct Video', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Video Type', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose video type.', 'zoacres' ), 
		'id'	=> $prefix.'video_type',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'' => esc_html__( 'None', 'zoacres' ),
			'youtube' => esc_html__( 'Youtube', 'zoacres' ),
			'vimeo' => esc_html__( 'Vimeo', 'zoacres' ),
			'custom' => esc_html__( 'Custom Video', 'zoacres' )
		),
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Video ID', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter Video ID Example: ZSt9tm3RoUU. If you choose custom video type then you enter custom video url and video must be mp4 format.', 'zoacres' ), 
		'id'	=> $prefix.'video_id',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'type'	=> 'line',
		'tab'	=> esc_html__( 'Format', 'zoacres' )
	),
	array( 
		'label'	=> esc_html__( 'Audio', 'zoacres' ),
		'desc'	=> esc_html__( 'This part for if you choosed audio format, then you must give audio id.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Audio Type', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose audio type.', 'zoacres' ), 
		'id'	=> $prefix.'audio_type',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'' => esc_html__( 'None', 'zoacres' ),
			'soundcloud' => esc_html__( 'Soundcloud', 'zoacres' ),
			'custom' => esc_html__( 'Custom Audio', 'zoacres' )
		),
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Audio ID', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter soundcloud audio ID. Example: 315307209.', 'zoacres' ), 
		'id'	=> $prefix.'audio_id',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'type'	=> 'line',
		'tab'	=> esc_html__( 'Format', 'zoacres' )
	),
	array( 
		'label'	=> esc_html__( 'Gallery', 'zoacres' ),
		'desc'	=> esc_html__( 'This part for if you choosed gallery format, then you must choose gallery images here.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Gallery Modal', 'zoacres' ),
		'id'	=> $prefix.'gallery_modal',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'default' => esc_html__( 'Default Gallery', 'zoacres' ),
			'popup' => esc_html__( 'Popup Gallery', 'zoacres' ),
			'grid' => esc_html__( 'Grid Popup Gallery', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Choose Gallery Images', 'zoacres' ),
		'id'	=> $prefix.'gallery',
		'type'	=> 'gallery',
		'tab'	=> esc_html__( 'Format', 'zoacres' )
	),
	array( 
		'type'	=> 'line',
		'tab'	=> esc_html__( 'Format', 'zoacres' )
	),
	array( 
		'label'	=> esc_html__( 'Quote', 'zoacres' ),
		'desc'	=> esc_html__( 'This part for if you choosed quote format, then you must fill the quote text and author name box.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Quote Modal', 'zoacres' ),
		'id'	=> $prefix.'quote_modal',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'featured' => esc_html__( 'Dark Overlay', 'zoacres' ),
			'theme-overlay' => esc_html__( 'Theme Overlay', 'zoacres' ),
			'theme' => esc_html__( 'Theme Color Background', 'zoacres' ),
			'none' => esc_html__( 'None', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Quote Text', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter quote text.', 'zoacres' ), 
		'id'	=> $prefix.'quote_text',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'textarea',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Quote Author', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter quote author name.', 'zoacres' ), 
		'id'	=> $prefix.'quote_author',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'type'	=> 'line',
		'tab'	=> esc_html__( 'Format', 'zoacres' )
	),
	array( 
		'label'	=> esc_html__( 'Link', 'zoacres' ),
		'desc'	=> esc_html__( 'This part for if you choosed link format, then you must fill the external link box.', 'zoacres' ), 
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'label'
	),
	array( 
		'label'	=> esc_html__( 'Link Modal', 'zoacres' ),
		'id'	=> $prefix.'link_modal',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'featured' => esc_html__( 'Dark Overlay', 'zoacres' ),
			'theme-overlay' => esc_html__( 'Theme Overlay', 'zoacres' ),
			'theme' => esc_html__( 'Theme Color Background', 'zoacres' ),
			'none' => esc_html__( 'None', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Link Text', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter link text to show.', 'zoacres' ), 
		'id'	=> $prefix.'link_text',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'External Link', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter external link.', 'zoacres' ), 
		'id'	=> $prefix.'extrenal_link',
		'tab'	=> esc_html__( 'Format', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	),
	array( 
		'type'	=> 'line',
		'tab'	=> esc_html__( 'Format', 'zoacres' )
	),
	
);

/**
 * Instantiate the class with all variables to create a meta box
 * var $id string meta box id
 * var $title string title
 * var $fields array fields
 * var $page string|array post type to add meta box to
 * var $js bool including javascript or not
 */
 
$post_box = new Custom_Add_Meta_Box( 'zoacres_post_metabox', esc_html__( 'Zoacres Post Options', 'zoacres' ), $fields, 'post', true );


/* Zoacres Page Options */
//$prefix = 'zoacres_page_';

function zoacresMetaboxFields( $prefix ){
	
	$zoacres_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	$zoacres_nav_menus = array( "none" => esc_html__( "None", "zoacres" ) );
	foreach( $zoacres_menus as $menu ){
		$zoacres_nav_menus[$menu->slug] = $menu->name;
	}
			
	$fields = array(
		array( 
			'label'	=> esc_html__( 'Page General Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page general settings.', 'zoacres' ), 
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Page Layout', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page layout for current post single view.', 'zoacres' ), 
			'id'	=> $prefix.'layout',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'wide' => esc_html__( 'Wide', 'zoacres' ),
				'boxed' => esc_html__( 'Boxed', 'zoacres' )			
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Page Content Padding Option', 'zoacres' ),
			'id'	=> $prefix.'content_padding_opt',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'		
		),
		array( 
			'label'	=> esc_html__( 'Page Content Padding', 'zoacres' ), 
			'desc'	=> esc_html__( 'Set the top/right/bottom/left padding of page content.', 'zoacres' ),
			'id'	=> $prefix.'content_padding',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'space',
			'required'	=> array( $prefix.'content_padding_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Background Color', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose color setting for current page background.', 'zoacres' ),
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'main_bg_color'
		),
		array( 
				'label'	=> esc_html__( 'Page Background Image', 'zoacres' ),
				'desc'	=> esc_html__( 'Choose custom logo image for current page.', 'zoacres' ), 
				'tab'	=> esc_html__( 'General', 'zoacres' ),
				'type'	=> 'image',
				'id'	=> $prefix.'main_bg_image'
			),
		array( 
			'label'	=> esc_html__( 'Page Margin', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are margin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'main_margin'
		),
		array( 
			'label'	=> esc_html__( 'Page Template Option', 'zoacres' ),
			'id'	=> $prefix.'template_opt',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'		
		),
		array( 
			'label'	=> esc_html__( 'Page Template', 'zoacres' ),
			'id'	=> $prefix.'template',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'image_select',
			'options' => array(
				'no-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/1.png' ), 
				'right-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/2.png' ), 
				'left-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/3.png' ), 
				'both-sidebar'	=> get_theme_file_uri( '/assets/images/page-layouts/4.png' ), 
			),
			'default'	=> 'right-sidebar',
			'required'	=> array( $prefix.'template_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Left Sidebar', 'zoacres' ),
			'id'	=> $prefix.'left_sidebar',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'template_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Right Sidebar', 'zoacres' ),
			'id'	=> $prefix.'right_sidebar',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'template_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Sidebar On Mobile', 'zoacres' ),
			'id'	=> $prefix.'sidebar_mobile',
			'tab'	=> esc_html__( 'General', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'1' => esc_html__( 'Show', 'zoacres' ),
				'0' => esc_html__( 'Hide', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header General Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header general settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Layout', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page layout for current page header layout.', 'zoacres' ), 
			'id'	=> $prefix.'header_layout',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'wide' => esc_html__( 'Wide', 'zoacres' ),
				'boxed' => esc_html__( 'Boxed', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Type', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page layout for current page header type.', 'zoacres' ), 
			'id'	=> $prefix.'header_type',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'default' => esc_html__( 'Default', 'zoacres' ),
				'left-sticky' => esc_html__( 'Left Sticky', 'zoacres' ),
				'right-sticky' => esc_html__( 'Right Sticky', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Background Image', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header background image for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'image',
			'id'	=> $prefix.'header_bg_img',
			'required'	=> array( $prefix.'header_type', 'default' )
		),
		array( 
			'label'	=> esc_html__( 'Header Items Options', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
			'id'	=> $prefix.'header_items_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header general items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'header_items',
			'dd_fields' => array ( 
				'Normal' => array( 
					'header-topbar' 	=> esc_html__( 'Topbar', 'zoacres' ),
					'header-logo'	=> esc_html__( 'Logo Bar', 'zoacres' )
				),
				'Sticky' => array( 
					'header-nav' 	=> esc_html__( 'Navbar', 'zoacres' )
				),
				'disabled' => array()
			),
			'required'	=> array( $prefix.'header_items_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Absolute Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header absolute to change header look transparent.', 'zoacres' ), 
			'id'	=> $prefix.'header_absolute_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'1' => esc_html__( 'Enable', 'zoacres' ),
				'0' => esc_html__( 'Disable', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header sticky options.', 'zoacres' ), 
			'id'	=> $prefix.'header_sticky_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'sticky' => esc_html__( 'Header Sticky Part', 'zoacres' ),
				'sticky-scroll' => esc_html__( 'Sticky Scroll Up', 'zoacres' ),
				'none' => esc_html__( 'None', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Secondary Space Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose secondary space option for enable secondary menu space for current page.', 'zoacres' ), 
			'id'	=> $prefix.'header_secondary_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'enable' => esc_html__( 'Enable', 'zoacres' ),
				'disable' => esc_html__( 'Disable', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Secondary Space Animate Type', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose secondary space option animate type for current page.', 'zoacres' ), 
			'id'	=> $prefix.'header_secondary_animate',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array(
				'left-push'		=> esc_html__( 'Left Push', 'zoacres' ),
				'left-overlay'	=> esc_html__( 'Left Overlay', 'zoacres' ),
				'right-push'	=> esc_html__( 'Right Push', 'zoacres' ),
				'right-overlay'	=> esc_html__( 'Right Overlay', 'zoacres' ),
				'full-overlay'	=> esc_html__( 'Full Page Overlay', 'zoacres' ),
			),
			'default'	=> 'left-push',
			'required'	=> array( $prefix.'header_secondary_opt', 'enable' )
		),
		array( 
			'label'	=> esc_html__( 'Secondary Space Width', 'zoacres' ),
			'desc'	=> esc_html__( 'Set secondary space width for current page. Example 300', 'zoacres' ), 
			'id'	=> $prefix.'header_secondary_width',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'text',
			'default'	=> '',
			'required'	=> array( $prefix.'header_secondary_opt', 'enable' )
		),
		array( 
			'label'	=> esc_html__( 'Custom Logo', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose custom logo image for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'image',
			'id'	=> $prefix.'custom_logo',
		),
		array( 
			'label'	=> esc_html__( 'Custom Sticky Logo', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose custom sticky logo image for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'image',
			'id'	=> $prefix.'custom_sticky_logo',
		),
		array( 
			'label'	=> esc_html__( 'Select Navigation Menu', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose navigation menu for current page.', 'zoacres' ), 
			'id'	=> $prefix.'nav_menu',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => $zoacres_nav_menus
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Options', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
			'id'	=> $prefix.'header_topbar_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Height', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar height for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dimension',
			'id'	=> $prefix.'header_topbar_height',
			'property' => 'height',
			'required'	=> array( $prefix.'header_topbar_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Sticky Height', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar sticky height for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dimension',
			'id'	=> $prefix.'header_topbar_sticky_height',
			'property' => 'height',
			'required'	=> array( $prefix.'header_topbar_opt', 'custom' )
		),
		array( 
			'label'	=> '',
			'desc'	=> esc_html__( 'These all are header topbar skin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header topbar skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'header_topbar_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'header_topbar_font',
			'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'header_topbar_bg',
			'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'header_topbar_link',
			'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'header_topbar_border',
			'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'header_topbar_padding',
			'required'	=> array( $prefix.'header_topbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Sticky Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header top barsticky skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'header_topbar_sticky_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Sticky Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header top barsticky font color for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'header_topbar_sticky_font',
			'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Sticky Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header top barsticky background color for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'header_topbar_sticky_bg',
			'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Sticky Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header top barsticky link color settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'header_topbar_sticky_link',
			'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Sticky Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header top barsticky border settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'header_topbar_sticky_border',
			'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Sticky Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header top barsticky padding settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'header_topbar_sticky_padding',
			'required'	=> array( $prefix.'header_topbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Items Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header topbar items enable options.', 'zoacres' ), 
			'id'	=> $prefix.'header_topbar_items_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Top Bar Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header topbar items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'header_topbar_items',
			'dd_fields' => array ( 
				'Left'  => array(
					'header-topbar-date' => esc_html__( 'Date', 'zoacres' ),						
				),
				'Center' => array(),
				'Right' => array(),
				'disabled' => array(
					'header-topbar-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
					'header-topbar-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
					'header-topbar-menu'    => esc_html__( 'Top Bar Menu', 'zoacres' ),
					'header-topbar-social'	=> esc_html__( 'Social', 'zoacres' ),
					'header-topbar-search'	=> esc_html__( 'Search', 'zoacres' )
				)
			),
			'required'	=> array( $prefix.'header_topbar_items_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Options', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
			'id'	=> $prefix.'header_logo_bar_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Height', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar height for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dimension',
			'id'	=> $prefix.'header_logo_bar_height',
			'property' => 'height',
			'required'	=> array( $prefix.'header_logo_bar_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Sticky Height', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar sticky height for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dimension',
			'id'	=> $prefix.'header_logo_bar_sticky_height',
			'property' => 'height',
			'required'	=> array( $prefix.'header_logo_bar_opt', 'custom' )
		),
		array( 
			'label'	=> '',
			'desc'	=> esc_html__( 'These all are header logo bar skin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header logo bar skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'header_logo_bar_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'header_logo_bar_font',
			'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'header_logo_bar_bg',
			'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'header_logo_bar_link',
			'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'header_logo_bar_border',
			'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'header_logo_bar_padding',
			'required'	=> array( $prefix.'header_logo_bar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Sticky Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header logo bar sticky skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'header_logobar_sticky_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Sticky Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar sticky font color for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'header_logobar_sticky_font',
			'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Sticky Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar sticky background color for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'header_logobar_sticky_bg',
			'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Sticky Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar sticky link color settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'header_logobar_sticky_link',
			'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Sticky Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar sticky border settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'header_logobar_sticky_border',
			'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Sticky Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar sticky padding settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'header_logobar_sticky_padding',
			'required'	=> array( $prefix.'header_logobar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Items Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header logo bar items enable options.', 'zoacres' ), 
			'id'	=> $prefix.'header_logo_bar_items_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Logo Bar Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header logo bar items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'header_logo_bar_items',
			'dd_fields' => array ( 
				'Left'  => array(),
				'Center' => array(
					'header-logobar-logo'	=> esc_html__( 'Logo', 'zoacres' ),
				),
				'Right' => array(),
				'disabled' => array(
					'header-logobar-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
					'header-logobar-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
					'header-logobar-menu'    => esc_html__( 'Main Menu', 'zoacres' ),
					'header-logobar-social'	=> esc_html__( 'Social', 'zoacres' ),
					'header-logobar-search'	=> esc_html__( 'Search', 'zoacres' ),
					'header-logobar-secondary-toggle'	=> esc_html__( 'Secondary Toggle', 'zoacres' ),
					'header-logobar-search-toggle'	=> esc_html__( 'Search Toggle', 'zoacres' ),
					'header-logobar-sticky-logo'	=> esc_html__( 'Stikcy Logo', 'zoacres' )
				)
			),
			'required'	=> array( $prefix.'header_logo_bar_items_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Options', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header items options for enable header drag and drop items.', 'zoacres' ), 
			'id'	=> $prefix.'header_navbar_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Height', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar height for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dimension',
			'id'	=> $prefix.'header_navbar_height',
			'property' => 'height',
			'required'	=> array( $prefix.'header_navbar_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Sticky Height', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar sticky height for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dimension',
			'id'	=> $prefix.'header_navbar_sticky_height',
			'property' => 'height',
			'required'	=> array( $prefix.'header_navbar_opt', 'custom' )
		),
		array( 
			'label'	=> '',
			'desc'	=> esc_html__( 'These all are header navbar skin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header navbar skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'header_navbar_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'header_navbar_font',
			'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'header_navbar_bg',
			'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'header_navbar_link',
			'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'header_navbar_border',
			'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'header_navbar_padding',
			'required'	=> array( $prefix.'header_navbar_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Sticky Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header navbar sticky skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'header_navbar_sticky_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Sticky Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar sticky font color for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'header_navbar_sticky_font',
			'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Sticky Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar sticky background color for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'header_navbar_sticky_bg',
			'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Sticky Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar sticky link color settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'header_navbar_sticky_link',
			'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Sticky Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar sticky border settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'header_navbar_sticky_border',
			'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Sticky Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar sticky padding settings for current post.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'header_navbar_sticky_padding',
			'required'	=> array( $prefix.'header_navbar_sticky_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Items Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header navbar items enable options.', 'zoacres' ), 
			'id'	=> $prefix.'header_navbar_items_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Navbar Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header navbar items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'header_navbar_items',
			'dd_fields' => array ( 
				'Left'  => array(											
					'header-navbar-menu'    => esc_html__( 'Main Menu', 'zoacres' ),
				),
				'Center' => array(
				),
				'Right' => array(
					'header-navbar-search'	=> esc_html__( 'Search', 'zoacres' ),
				),
				'disabled' => array(
					'header-navbar-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
					'header-navbar-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
					'header-navbar-logo'	=> esc_html__( 'Logo', 'zoacres' ),
					'header-navbar-social'	=> esc_html__( 'Social', 'zoacres' ),
					'header-navbar-secondary-toggle'	=> esc_html__( 'Secondary Toggle', 'zoacres' ),
					'header-navbar-search-toggle'	=> esc_html__( 'Search Toggle', 'zoacres' ),
					'header-navbar-sticky-logo'	=> esc_html__( 'Stikcy Logo', 'zoacres' ),
				)
			),
			'required'	=> array( $prefix.'header_navbar_items_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Options', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header sticky part option.', 'zoacres' ), 
			'id'	=> $prefix.'header_stikcy_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Width', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky part width for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dimension',
			'id'	=> $prefix.'header_stikcy_width',
			'property' => 'width',
			'required'	=> array( $prefix.'header_stikcy_opt', 'custom' )
		),
		array( 
			'label'	=> '',
			'desc'	=> esc_html__( 'These all are header sticky skin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header sticky skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'header_stikcy_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'header_stikcy_font',
			'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'header_stikcy_bg',
			'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'header_stikcy_link',
			'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'header_stikcy_border',
			'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'header_stikcy_padding',
			'required'	=> array( $prefix.'header_stikcy_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Items Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose header sticky items enable options.', 'zoacres' ), 
			'id'	=> $prefix.'header_stikcy_items_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Header Sticky/Fixed Part Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are header sticky items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'header_stikcy_items',
			'dd_fields' => array ( 
				'Top'  => array(
					'header-fixed-logo' => esc_html__( 'Logo', 'zoacres' )
				),
				'Middle'  => array(
					'header-fixed-menu'	=> esc_html__( 'Menu', 'zoacres' )					
				),
				'Bottom'  => array(
					'header-fixed-social'	=> esc_html__( 'Social', 'zoacres' )					
				),
				'disabled' => array(
					'header-fixed-text-1'	=> esc_html__( 'Custom Text 1', 'zoacres' ),
					'header-fixed-text-2'	=> esc_html__( 'Custom Text 2', 'zoacres' ),
					'header-fixed-search'	=> esc_html__( 'Search Form', 'zoacres' )
				)
			),
			'required'	=> array( $prefix.'header_stikcy_items_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Bar', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title bar settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Page Title Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page title enable or disable.', 'zoacres' ), 
			'id'	=> $prefix.'header_page_title_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'1' => esc_html__( 'Enable', 'zoacres' ),
				'0' => esc_html__( 'Disable', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Page Title Text', 'zoacres' ),
			'desc'	=> esc_html__( 'If this page title is empty, then showing current page default title.', 'zoacres' ), 
			'id'	=> $prefix.'header_page_title_text',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'text',
			'default'	=> '',
			'required'	=> array( $prefix.'header_page_title_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Description', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter page title description.', 'zoacres' ), 
			'id'	=> $prefix.'header_page_title_desc',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'textarea',
			'default'	=> '',
			'required'	=> array( $prefix.'header_page_title_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Background Parallax', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page title background parallax.', 'zoacres' ), 
			'id'	=> $prefix.'header_page_title_parallax',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'1' => esc_html__( 'Enable', 'zoacres' ),
				'0' => esc_html__( 'Disable', 'zoacres' )
			),
			'default'	=> 'theme-default',
			'required'	=> array( $prefix.'header_page_title_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Background Video Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page title background video option.', 'zoacres' ), 
			'id'	=> $prefix.'header_page_title_video_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'1' => esc_html__( 'Enable', 'zoacres' ),
				'0' => esc_html__( 'Disable', 'zoacres' )
			),
			'default'	=> 'theme-default',
			'required'	=> array( $prefix.'header_page_title_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Background Video', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter youtube video ID. Example: ZSt9tm3RoUU.', 'zoacres' ), 
			'id'	=> $prefix.'header_page_title_video',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'text',
			'default'	=> '',
			'required'	=> array( $prefix.'header_page_title_video_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Bar Items Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page title bar items option.', 'zoacres' ), 
			'id'	=> $prefix.'page_title_items_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default',
			'required'	=> array( $prefix.'header_page_title_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Bar Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title bar items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'page_title_items',
			'dd_fields' => array ( 
				'Left'  => array(
					'title' => esc_html__( 'Page Title Text', 'zoacres' ),
				),
				'Center'  => array(
					
				),
				'Right'  => array(
					'breadcrumb'	=> esc_html__( 'Breadcrumb', 'zoacres' )
				),
				'disabled' => array(
					'description' => esc_html__( 'Page Title Description', 'zoacres' )
				)
			),
			'required'	=> array( $prefix.'page_title_items_opt', 'custom' )
		),
		array( 
			'label'	=> '',
			'desc'	=> esc_html__( 'These all are page title skin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'label',
			'required'	=> array( $prefix.'header_page_title_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose page title skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'page_title_skin_opt',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default',
			'required'	=> array( $prefix.'header_page_title_opt', '1' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'page_title_font',
			'required'	=> array( $prefix.'page_title_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'page_title_bg',
			'required'	=> array( $prefix.'page_title_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Background Image', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter page title background image url.', 'zoacres' ), 
			'id'	=> $prefix.'page_title_bg_img',
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> '',
			'required'	=> array( $prefix.'page_title_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'page_title_link',
			'required'	=> array( $prefix.'page_title_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'page_title_border',
			'required'	=> array( $prefix.'page_title_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'page_title_padding',
			'required'	=> array( $prefix.'page_title_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Page Title Overlay', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are page title overlay color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Header', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'page_title_overlay',
			'required'	=> array( $prefix.'page_title_skin_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer General',
			'desc'	=> esc_html__( 'These all are header footer settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Layout', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer layout for current page.', 'zoacres' ), 
			'id'	=> $prefix.'footer_layout',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'wide' => esc_html__( 'Wide', 'zoacres' ),
				'boxed' => esc_html__( 'Boxed', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Hidden Footer', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose hidden footer option.', 'zoacres' ), 
			'id'	=> $prefix.'hidden_footer',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'1' => esc_html__( 'Enable', 'zoacres' ),
				'0' => esc_html__( 'Disable', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> '',
			'desc'	=> esc_html__( 'These all are footer skin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Skin Settings', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer skin settings options.', 'zoacres' ), 
			'id'	=> $prefix.'footer_skin_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'footer_font',
			'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Background Image', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer background image for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'image',
			'id'	=> $prefix.'footer_bg_img',
			'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Background Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'footer_bg',
			'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Background Overlay', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer background overlay color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'footer_bg_overlay',
			'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'footer_link',
			'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'footer_border',
			'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'footer_padding',
			'required'	=> array( $prefix.'footer_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Items Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer items enable options.', 'zoacres' ), 
			'id'	=> $prefix.'footer_items_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'footer_items',
			'dd_fields' => array ( 
				'Enabled'  => array(
					'footer-bottom'	=> esc_html__( 'Footer Bottom', 'zoacres' )
				),
				'disabled' => array(
					'footer-top' => esc_html__( 'Footer Top', 'zoacres' ),
					'footer-middle'	=> esc_html__( 'Footer Middle', 'zoacres' )
				)
			),
			'required'	=> array( $prefix.'footer_items_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Top',
			'desc'	=> esc_html__( 'These all are footer top settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Top Skin', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer top skin options.', 'zoacres' ), 
			'id'	=> $prefix.'footer_top_skin_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Top Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer top font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'footer_top_font',
			'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Top Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'footer_top_bg',
			'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Top Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer top link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'footer_top_link',
			'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Top Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer top border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'footer_top_border',
			'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Top Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer top padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'footer_top_padding',
			'required'	=> array( $prefix.'footer_top_skin_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Top Columns and Sidebars Settings',
			'desc'	=> esc_html__( 'These all are footer top columns and sidebar settings.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Layout Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer layout option.', 'zoacres' ), 
			'id'	=> $prefix.'footer_top_layout_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Layout', 'zoacres' ),
			'id'	=> $prefix.'footer_top_layout',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'image_select',
			'options' => array(
				'3-3-3-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-1.png', 
				'4-4-4'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-2.png', 
				'3-6-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-3.png', 
				'6-6'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-4.png', 
				'9-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-5.png', 
				'3-9'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-6.png', 
				'12'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-7.png'
			),
			'default'	=> '4-4-4',
			'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer First Column',
			'desc'	=> esc_html__( 'Select footer first column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_top_sidebar_1',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Second Column',
			'desc'	=> esc_html__( 'Select footer second column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_top_sidebar_2',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Third Column',
			'desc'	=> esc_html__( 'Select footer third column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_top_sidebar_3',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Fourth Column',
			'desc'	=> esc_html__( 'Select footer fourth column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_top_sidebar_4',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_top_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Middle',
			'desc'	=> esc_html__( 'These all are footer middle settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Middle Skin', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer middle skin options.', 'zoacres' ), 
			'id'	=> $prefix.'footer_middle_skin_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Middle Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer middle font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'footer_middle_font',
			'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Middle Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'footer_middle_bg',
			'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Middle Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer middle link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'footer_middle_link',
			'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Middle Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer middle border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'footer_middle_border',
			'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Middle Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer middle padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'footer_middle_padding',
			'required'	=> array( $prefix.'footer_middle_skin_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Middle Columns and Sidebars Settings',
			'desc'	=> esc_html__( 'These all are footer middle columns and sidebar settings.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Layout Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer layout option.', 'zoacres' ), 
			'id'	=> $prefix.'footer_middle_layout_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Layout', 'zoacres' ),
			'id'	=> $prefix.'footer_middle_layout',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'image_select',
			'options' => array(
				'3-3-3-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-1.png', 
				'4-4-4'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-2.png', 
				'3-6-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-3.png', 
				'6-6'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-4.png', 
				'9-3'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-5.png', 
				'3-9'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-6.png', 
				'12'	=> ZOACRES_CORE_URL . '/admin/ReduxCore/assets/img/footer-layouts/footer-7.png'
			),
			'default'	=> '4-4-4',
			'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer First Column',
			'desc'	=> esc_html__( 'Select footer first column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_middle_sidebar_1',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Second Column',
			'desc'	=> esc_html__( 'Select footer second column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_middle_sidebar_2',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Third Column',
			'desc'	=> esc_html__( 'Select footer third column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_middle_sidebar_3',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Fourth Column',
			'desc'	=> esc_html__( 'Select footer fourth column widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_middle_sidebar_4',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_middle_layout_opt', 'custom' )
		),
		array( 
			'label'	=> 'Footer Bottom',
			'desc'	=> esc_html__( 'These all are footer bottom settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Fixed', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer bottom fixed option.', 'zoacres' ), 
			'id'	=> $prefix.'footer_bottom_fixed',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'1' => esc_html__( 'Enable', 'zoacres' ),
				'0' => esc_html__( 'Disable', 'zoacres' )			
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> '',
			'desc'	=> esc_html__( 'These all are footer bottom skin settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Skin', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer bottom skin options.', 'zoacres' ), 
			'id'	=> $prefix.'footer_bottom_skin_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Font Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer bottom font color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'color',
			'id'	=> $prefix.'footer_bottom_font',
			'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Background', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer bottom background color for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'alpha_color',
			'id'	=> $prefix.'footer_bottom_bg',
			'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Link Color', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer bottom link color settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'link_color',
			'id'	=> $prefix.'footer_bottom_link',
			'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Border', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer bottom border settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'color' => 1,
			'border_style' => 1,
			'id'	=> $prefix.'footer_bottom_border',
			'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Padding', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer bottom padding settings for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'space',
			'id'	=> $prefix.'footer_bottom_padding',
			'required'	=> array( $prefix.'footer_bottom_skin_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Widget Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer bottom widget options.', 'zoacres' ), 
			'id'	=> $prefix.'footer_bottom_widget_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> 'Footer Bottom Widget',
			'desc'	=> esc_html__( 'Select footer bottom widget.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'id'	=> $prefix.'footer_bottom_widget',
			'type'	=> 'sidebar',
			'required'	=> array( $prefix.'footer_bottom_widget_opt', 'custom' )
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Items Option', 'zoacres' ),
			'desc'	=> esc_html__( 'Choose footer bottom items options.', 'zoacres' ), 
			'id'	=> $prefix.'footer_bottom_items_opt',
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'custom' => esc_html__( 'Custom', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Footer Bottom Items', 'zoacres' ),
			'desc'	=> esc_html__( 'These all are footer bottom items for current page.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Footer', 'zoacres' ),
			'type'	=> 'dragdrop_multi',
			'id'	=> $prefix.'footer_bottom_items',
			'dd_fields' => array ( 
				'Left'  => array(
					'copyright' => esc_html__( 'Copyright Text', 'zoacres' )
				),
				'Center'  => array(
					'menu'	=> esc_html__( 'Footer Menu', 'zoacres' )
				),
				'Right'  => array(),
				'disabled' => array(
					'social'	=> esc_html__( 'Footer Social Links', 'zoacres' ),
					'widget'	=> esc_html__( 'Custom Widget', 'zoacres' )
				)
			),
			'required'	=> array( $prefix.'footer_bottom_items_opt', 'custom' )
		),
		//Header Slider
		array( 
			'label'	=> esc_html__( 'Slider', 'zoacres' ),
			'desc'	=> esc_html__( 'This header slider settings.', 'zoacres' ), 
			'tab'	=> esc_html__( 'Slider', 'zoacres' ),
			'type'	=> 'label'
		),
		array( 
			'label'	=> esc_html__( 'Slider Option', 'zoacres' ),
			'id'	=> $prefix.'header_slider_opt',
			'tab'	=> esc_html__( 'Slider', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
				'bottom' => esc_html__( 'Below Header', 'zoacres' ),
				'top' => esc_html__( 'Above Header', 'zoacres' ),
				'none' => esc_html__( 'None', 'zoacres' )
			),
			'default'	=> 'theme-default'
		),
		array( 
			'label'	=> esc_html__( 'Slider Shortcode', 'zoacres' ),
			'desc'	=> esc_html__( 'This is the place for enter slider shortcode. Example revolution slider shortcodes.', 'zoacres' ), 
			'id'	=> $prefix.'header_slider',
			'tab'	=> esc_html__( 'Slider', 'zoacres' ),
			'type'	=> 'textarea',
			'default'	=> ''
		),
	);

	return $fields;
}

$page_fields = zoacresMetaboxFields( 'zoacres_page_' );
$page_box = new Custom_Add_Meta_Box( 'zoacres_page_metabox', esc_html__( 'Zoacres Page Options', 'zoacres' ), $page_fields, 'page', true );

/* Property Page Options */
$prefix = 'zoacres_property_';

$property_features = isset( $zoacres_options['property-features'] ) ? $zoacres_options['property-features'] : '';
$property_features_arr = zoacres_trim_array_same_values( $property_features );
$property_structures = isset( $zoacres_options['property-structure'] ) ? $zoacres_options['property-structure'] : '';
$property_structures_arr = zoacres_trim_array_same_values( $property_structures );
$property_ribbon = isset( $zoacres_options['property-ribbon-colors'] ) ? $zoacres_options['property-ribbon-colors'] : '';
$property_ribbon_arr = zoacres_trim_array_color_labels( $property_ribbon );
$property_cf = isset( $zoacres_options['property-custom-fields'] ) ? $zoacres_options['property-custom-fields'] : '';
$property_cf = json_decode( $property_cf, true );
$property_cf_array = array();

//Admin Details
$agent_arr = array();
if (is_admin()){
	require_once ABSPATH . 'wp-includes/pluggable.php';
	$users = get_users( array(
		'role' => 'administrator'
	) );	
	foreach( $users as $user ) {
		$firstName = get_user_meta( $user->ID, 'first_name', true );
		$lastName = get_user_meta( $user->ID, 'last_name', true );
		$agent_arr[$user->ID] = $firstName .' '. $lastName ." (". esc_html__( 'Admin', 'zoacres' ) .")";
	}
}

//Agent Details
$posts = get_posts( array( 'post_type' => 'zoacres-agent', 'posts_per_page' => -1 ) );
foreach ( $posts as $item ){
	$agent_arr[$item->ID] = $item->post_title;
}
$post_type_object = get_post_type_object( 'zoacres-agent' );

if( $property_cf ):
	$cfi = 0;
	foreach( $property_cf as $fields ){
			
		$fld_name = $fields['Field Name'] ? $fields['Field Name'] : '';
		$fld_id = str_replace("-","_", sanitize_title( $fld_name ) );
		$fld_type = $fields['Field Type'] ? $fields['Field Type'] : 'text';
		$fld_type = $fld_type == 'dropdown' ? 'select' : $fld_type;

		$t_array = array(
			'label' => esc_html( $fld_name ),
			'id'	=> $prefix.'custom_'.$fld_id,
			'tab'	=> esc_html__( 'Custom Details', 'zoacres' ),
			'type'	=> $fld_type
		);
		
		if( $fld_type == 'select' ){
			$fld_dd = isset( $fields['Dropdown Values'] ) ? $fields['Dropdown Values'] : '';
			$dd_array = array();
			if( $fld_dd ){
				$dd_values = explode( ",", $fld_dd );
				foreach( $dd_values as $dd_val ){
					$dd_key = sanitize_title( $dd_val );
					$dd_value = esc_html( $dd_val );
					$dd_array[$dd_key] = $dd_value;
				}		
				$t_array['options'] = $dd_array;
			}
			
		}

		$property_cf_array[$cfi++] = $t_array;
	}
endif;

$property_fields = array(	
	array( 
		'label'	=> esc_html__( 'Property Status', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose property status for active/inactive property for site.', 'zoacres' ), 
		'id'	=> $prefix.'active_status',
		'tab'	=> esc_html__( 'Property General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'inactive' => esc_html__( 'Inactive', 'zoacres' ),
			'active' => esc_html__( 'Active', 'zoacres' )
		),
		'default'	=> 'inactive'
	),
	array( 
		'label'	=> esc_html__( 'Property Featured', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose property featured status.', 'zoacres' ), 
		'id'	=> 'zoacres_post_featured_stat',
		'tab'	=> esc_html__( 'Property General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'0' => esc_html__( 'No', 'zoacres' ),
			'1' => esc_html__( 'Yes', 'zoacres' )
		),
		'default'	=> '0'
	),
	array( 
		'label'	=> esc_html__( 'Choose Agent', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose name of the agent for current property..', 'zoacres' ), 
		'id'	=> $prefix.'agent_id',
		'tab'	=> esc_html__( 'Property General', 'zoacres' ),
		'type'	=> 'select',
		'options' => $agent_arr,
		'default'	=> '1'
	),
	array( 
		'label'	=> esc_html__( 'Property Address', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter property address.', 'zoacres' ), 
		'id'	=> $prefix.'address',
		'tab'	=> esc_html__( 'Property General', 'zoacres' ),
		'type'	=> 'textarea',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Property ZIP', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter property area zip code .', 'zoacres' ), 
		'id'	=> $prefix.'zip',
		'tab'	=> esc_html__( 'Property General', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Property Ribbons', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose property status. It is ribbons. You can manage ribbon settings at Theme Options -> Property Settings -> Property General -> Property Ribbon Label & Color', 'zoacres' ), 
		'id'	=> $prefix.'status',
		'tab'	=> esc_html__( 'Property General', 'zoacres' ),
		'type'	=> 'checkbox_group',
		'options'	=> $property_ribbon_arr
	),
	array( 
		'label'	=> esc_html__( 'Property Price', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter price of property with out any dolor, symbol or any special characters. Example 50000', 'zoacres' ), 
		'id'	=> $prefix.'price',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array(
		'id'       => $prefix.'before_price_label',
		'type'     => 'text',
		'label'    => esc_html__( 'Property Before Price Label', 'zoacres' ),
		'desc'     => esc_html__( 'Enter before label for property price. Ex: "per month"', 'zoacres' ),
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'default'  => ''
	),
	array(
		'id'       => $prefix.'after_price_label',
		'type'     => 'text',
		'label'    => esc_html__( 'Property After Price Label', 'zoacres' ),
		'desc'     => esc_html__( 'Enter after label for property price. Ex: "per month"', 'zoacres' ),
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'default'  => ''
	),
	array( 
		'label'	=> esc_html__( 'Property Size', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter size of property by number. Do not use any special characters like comma, dot etc... Example 10000', 'zoacres' ), 
		'id'	=> $prefix.'size',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Property Lot Size', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter lot size of property by number. Do not use any special characters like comma, dot etc... Example 10000', 'zoacres' ), 
		'id'	=> $prefix.'lot_size',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Property Structure Type', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose related structure type of this property. You can manage property structure type settings at Theme Options -> Property Settings -> Property General -> Property Structure Types', 'zoacres' ), 
		'id'	=> $prefix.'structures',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'checkbox_individual_group',
		'options'	=> $property_structures_arr
	),
	array( 
		'label'	=> esc_html__( 'Property Features', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose related features of this property. You can manage property features settings at Theme Options -> Property Settings -> Property General -> Property Feature Names', 'zoacres' ), 
		'id'	=> $prefix.'features',
		'tab'	=> esc_html__( 'Property Features', 'zoacres' ),
		'type'	=> 'checkbox_individual_group',
		'options'	=> $property_features_arr
	),
	array( 
		'label'	=> esc_html__( 'Floor Plans', 'zoacres' ),
		'desc'	=> esc_html__( 'Here mention all the floor plan details.', 'zoacres' ),
		'id'	=> $prefix.'floor_palns',
		'tab'	=> esc_html__( 'Property Features', 'zoacres' ),
		'type'	=> 'repeatable',
		'sanitizer' => array(
			'title' => 'sanitize_text_field',
			'desc' => 'wp_kses_data'
		),
		'repeatable_fields' => array (
			'image' => array(
				'label'	=> esc_html__( 'Plan Image', 'zoacres' ),
				'id'	=> 'plan_image',
				'type'	=> 'image'
			),
			'title' => array(
				'label' => esc_html__( 'Plan Title', 'zoacres' ),
				'id'	=> 'plan_title',
				'type'	=> 'text'
			),
			'size' => array(
				'label' => esc_html__( 'Plan Size', 'zoacres' ),
				'id'	=> 'plan_size',
				'type'	=> 'text'
			),
			'rooms' => array(
				'label' => esc_html__( 'Plan Rooms', 'zoacres' ),
				'id'	=> 'plan_rooms',
				'type'	=> 'text'
			),
			'bathrooms' => array(
				'label' => esc_html__( 'Plan Bathrooms', 'zoacres' ),
				'id'	=> 'plan_bathrooms',
				'type'	=> 'text'
			),
			'desc' => array(
				'label' => esc_html__( 'Plan Description', 'zoacres' ),
				'id'	=> 'plan_desc',
				'type'	=> 'textarea'
			),
			'price' => array(
				'label' => esc_html__( 'Plan Price', 'zoacres' ),
				'id'	=> 'plan_price',
				'type'	=> 'text'
			)
		)
	),
	array( 
		'label'	=> esc_html__( 'Number of Rooms', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter number of rooms in property. Example 5', 'zoacres' ), 
		'id'	=> $prefix.'no_rooms',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Number of Bed Rooms', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter number of bed rooms in property. Example 5', 'zoacres' ), 
		'id'	=> $prefix.'no_bed_rooms',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Number of Bath Rooms', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter number of bath rooms in property. Example 5', 'zoacres' ), 
		'id'	=> $prefix.'no_bath_rooms',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Number of Garages', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter number of garages in property. Example 2', 'zoacres' ), 
		'id'	=> $prefix.'no_garages',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Video Type', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose video type for property. You can explain customers via video about your property features.', 'zoacres' ), 
		'id'	=> $prefix.'video_type',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'none' => esc_html__( 'None', 'zoacres' ),
			'youtube' => esc_html__( 'Youtube', 'zoacres' ),
			'vimeo' => esc_html__( 'Vimeo', 'zoacres' ),
			'custom' => esc_html__( 'Custom Video', 'zoacres' )
		),
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Video ID', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter Video ID Example: ZSt9tm3RoUU. If you choose custom video type then you enter custom video url and video must be mp4 format.', 'zoacres' ), 
		'id'	=> $prefix.'video_id',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'text',
		'required'	=> array( $prefix.'video_type', "none", "!=" ),
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Choose Property Gallery Images', 'zoacres' ),
		'id'	=> $prefix.'gallery',
		'type'	=> 'gallery',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' )
	),
	array( 
		'label'	=> esc_html__( 'Virtual Tour Iframe URL', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter virtual tour iframe src only. Don\'t pu full iframe code just put iframe "src".', 'zoacres' ), 
		'id'	=> $prefix.'vitual_tour',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( '360&deg; Image URL', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter property 360&#176; image url for single property page.', 'zoacres' ), 
		'id'	=> $prefix.'360_image',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'image',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Property Documents', 'zoacres' ),
		'desc'	=> esc_html__( 'Upload Property Documents.', 'zoacres' ), 
		'id'	=> $prefix.'documents',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'file'
	),
	array( 
		'label'	=> esc_html__( 'Property Notes', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter some notes about this property. This notes not visible on front end.', 'zoacres' ), 
		'id'	=> $prefix.'hidden_notes',
		'tab'	=> esc_html__( 'Property Details', 'zoacres' ),
		'type'	=> 'textarea',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Property Location', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose property location by click map on exact your location.', 'zoacres' ), 
		'id'	=> $prefix.'location',
		'tab'	=> esc_html__( 'Property Map', 'zoacres' ),
		'type'	=> 'map',
		'options'	=> array( 'lat' => '-34.397', 'lang' => '150.644' )
	),
	array( 
		'label'	=> esc_html__( 'Latitude', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter latitude number of the property.', 'zoacres' ), 
		'id'	=> $prefix.'latitude',
		'tab'	=> esc_html__( 'Property Map', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Longitude', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter longitude number of the property.', 'zoacres' ), 
		'id'	=> $prefix.'longitude',
		'tab'	=> esc_html__( 'Property Map', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Property Top Meta Items Custom Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose single property top meta items custom option.', 'zoacres' ), 
		'id'	=> $prefix.'topmeta_opt',
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Single Property Top Meta Items', 'zoacres' ),
		'desc'	=> esc_html__( 'Needed single property top meta items drag from disabled and put enabled part. ie: Left or Right.', 'zoacres' ),
		'id'	=> $prefix.'topmeta_items',
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'dd_fields' => array(
			'Left'  => array(
				'agent'	=> esc_html__( 'Agent', 'zoacres' )
			),
			'Right'  => array(
				'social'	=> esc_html__( 'Social Share', 'zoacres' ),
				'favourite'	=> esc_html__( 'Favourite', 'zoacres' ),
				'print'	=> esc_html__( 'Print', 'zoacres' )
			),
			'disabled' => array(
				'date'	=> esc_html__( 'Date', 'zoacres' ),
				'category'	=> esc_html__( 'Category', 'zoacres' ),
				'price'	=> esc_html__( 'Price', 'zoacres' ),
				'likes'	=> esc_html__( 'Likes', 'zoacres' ),
				'views'	=> esc_html__( 'Views', 'zoacres' ),
				'area'	=> esc_html__( 'Area Range', 'zoacres' ),
				'address'	=> esc_html__( 'Address', 'zoacres' ),
				'title'	=> esc_html__( 'Title', 'zoacres' ),
				'breadcrumb'	=> esc_html__( 'Breadcrumb', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'topmeta_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Property Bottom Meta Items Custom Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose single property bottom meta items custom option.', 'zoacres' ), 
		'id'	=> $prefix.'bottommeta_opt',
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Single Property Bottom Meta Items', 'zoacres' ),
		'desc'	=> esc_html__( 'Needed single property bottom meta items drag from disabled and put enabled part. ie: Left or Right.', 'zoacres' ),
		'id'	=> $prefix.'bottommeta_items',
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'dd_fields' => array(
			'Left'  => array(
				'address'	=> esc_html__( 'Address', 'zoacres' )						
			),
			'Right'  => array(
				'price'	=> esc_html__( 'Price', 'zoacres' ),
				'area'	=> esc_html__( 'Area Range', 'zoacres' )						
			),
			'disabled' => array(
				'date'	=> esc_html__( 'Date', 'zoacres' ),
				'category'	=> esc_html__( 'Category', 'zoacres' ),
				'social'	=> esc_html__( 'Social Share', 'zoacres' ),
				'favourite'	=> esc_html__( 'Favourite', 'zoacres' ),
				'print'	=> esc_html__( 'Print', 'zoacres' ),						
				'likes'	=> esc_html__( 'Likes', 'zoacres' ),
				'views'	=> esc_html__( 'Views', 'zoacres' ),						
				'agent'	=> esc_html__( 'Agent', 'zoacres' ),
				'title'	=> esc_html__( 'Title', 'zoacres' ),
				'breadcrumb'	=> esc_html__( 'Breadcrumb', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'bottommeta_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Property Header Items Custom Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose single property header items custom option.', 'zoacres' ), 
		'id'	=> $prefix.'headeritems_opt',
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array(
		'id'      => $prefix.'header_items',
		'type'    => 'dragdrop_multi',
		'label'   => esc_html__( 'Single Property Header Items', 'zoacres' ),
		'desc'    => esc_html__( 'Needed single property header items drag from disabled and put enabled part.', 'zoacres' ),
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'dd_fields' => array(
			'Enabled'  => array(
				'title'	=> esc_html__( 'Title', 'zoacres' ),
				'top-meta'	=> esc_html__( 'Top Meta', 'zoacres' ),
				'bottom-meta'	=> esc_html__( 'Bottom Meta', 'zoacres' )
			),
			'disabled' => array(	
				'thumb'	=> esc_html__( 'Property Image', 'zoacres' ),
				'gallery'	=> esc_html__( 'Property Gallery', 'zoacres' ),		
				'pack'	=> esc_html__( 'Gallery/Map/Street', 'zoacres' ),
				'map'	=> esc_html__( 'Map', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'headeritems_opt', 'custom' )
	),
	array( 
		'label'	=> esc_html__( 'Property Page Items Custom Option', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose single property page items custom option.', 'zoacres' ), 
		'id'	=> $prefix.'pageitems_opt',
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'theme-default' => esc_html__( 'Theme Default', 'zoacres' ),
			'custom' => esc_html__( 'Custom', 'zoacres' )
		),
		'default'	=> 'theme-default'
	),
	array( 
		'label'	=> esc_html__( 'Single Property Page Items', 'zoacres' ),
		'desc'	=> esc_html__( 'Needed single property page items drag from disabled and put enabled part. ie: Left or Right.', 'zoacres' ),
		'id'	=> $prefix.'page_items',
		'tab'	=> esc_html__( 'Layout', 'zoacres' ),
		'type'	=> 'dragdrop_multi',
		'dd_fields' => array(
			'Enabled'  => array(
				'title'	=> esc_html__( 'Property Title', 'zoacres' ),
				'description'	=> esc_html__( 'Description', 'zoacres' ),
				'address'	=> esc_html__( 'Address', 'zoacres' ),
				'details'	=> esc_html__( 'Property Details', 'zoacres' ),
				'info'		=> esc_html__( 'Additional Info', 'zoacres' ),
				'features'	=> esc_html__( 'Features', 'zoacres' ),
				'agent'		=> esc_html__( 'Agent Details', 'zoacres' ),
				'related'	=> esc_html__( 'Similar Properties', 'zoacres' ),
				'comment'	=> esc_html__( 'Property Comments', 'zoacres' )
			),
			'disabled' => array(
				'thumb'	=> esc_html__( 'Property Image', 'zoacres' ),
				'gallery'	=> esc_html__( 'Property Gallery', 'zoacres' ),
				'map'	=> esc_html__( 'Property Nearby', 'zoacres' ),
				'pack'	=> esc_html__( 'Gallery/Map/Street', 'zoacres' ),
				'matterport'	=> esc_html__( 'Matter Port Photo', 'zoacres' ),
				'panorama'	=> esc_html__( 'Panorama', 'zoacres' ),
				'video'		=> esc_html__( 'Video', 'zoacres' ),
				'plans'		=> esc_html__( 'Floor plans', 'zoacres' ),
				'sview'		=> esc_html__( 'Street View', 'zoacres' ),
				'top-meta'	=> esc_html__( 'Top Meta', 'zoacres' ),
				'bottom-meta'	=> esc_html__( 'Bottom Meta', 'zoacres' ),
				'days-view'		=> esc_html__( 'Days View Chart', 'zoacres' ),
				'walk-score'	=> esc_html__( 'Walk Score', 'zoacres' ),
				'trending'	=> esc_html__( 'Trending Properties', 'zoacres' )
			)
		),
		'required'	=> array( $prefix.'pageitems_opt', 'custom' )
	),
);
$property_fields = array_merge( $property_fields, $property_cf_array );

$property_fields = apply_filters( 'zoacres_property_filters_metabox_fileds', $property_fields );

$property_box = new Custom_Add_Meta_Box( 'zoacres_property_metabox', esc_html__( 'Zoacres Property Options', 'zoacres' ), $property_fields, 'zoacres-property', true );
$property_page_box = new Custom_Add_Meta_Box( 'zoacres_property_page_metabox', esc_html__( 'Zoacres Page Options', 'zoacres' ), $page_fields, 'zoacres-property', true );

/* Agent Options */
$prefix = 'zoacres_agent_';

$agency_fields = array(
	array( 
		'label'	=> esc_html__( 'Agent Position', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter position of agent. Example House Broker', 'zoacres' ),
		'id'	=> $prefix.'position',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Agent Type', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose agent type either agency or agent.', 'zoacres' ), 
		'id'	=> $prefix.'type',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'agent' => esc_html__( 'Agent', 'zoacres' ),
			'agency' => esc_html__( 'Agency', 'zoacres' )
		),
		'default'	=> 'agent'
	),
	array( 
		'label'	=> esc_html__( 'Email', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter agent/agency email address.', 'zoacres' ),
		'id'	=> $prefix.'email',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Mobile', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter agent/agency mobile number.', 'zoacres' ),
		'id'	=> $prefix.'mobile',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Telephone', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter agent/agency telephone number.', 'zoacres' ),
		'id'	=> $prefix.'telephone',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Address', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter agent/agency address.', 'zoacres' ), 
		'id'	=> $prefix.'address',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'textarea',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Skype ID', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter agent/agency skype id.', 'zoacres' ),
		'id'	=> $prefix.'skype',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Website', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter agent/agency website url.', 'zoacres' ),
		'id'	=> $prefix.'website',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Rating', 'zoacres' ),
		'desc'	=> esc_html__( 'Rating of agent/agency.', 'zoacres' ),
		'id'	=> $prefix.'rating',
		'tab'	=> esc_html__( 'Agent Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Agent Experience', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter experience of agent. Example 10 years', 'zoacres' ),
		'id'	=> $prefix.'experience',
		'tab'	=> esc_html__( 'Agent Additional Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Agent Languages', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter known languages for agent. Separate by comma(,) Example English, French, Spanish', 'zoacres' ),
		'id'	=> $prefix.'languages',
		'tab'	=> esc_html__( 'Agent Additional Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Agent MLS ID', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter MLS(multiple listing service) id if you have.', 'zoacres' ),
		'id'	=> $prefix.'mlsid',
		'tab'	=> esc_html__( 'Agent Additional Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Agent Schedule', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter your working time as schedule.', 'zoacres' ),
		'id'	=> $prefix.'schedule',
		'tab'	=> esc_html__( 'Agent Additional Details', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Facebook', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter facebook link of agent/agency.', 'zoacres' ),
		'id'	=> $prefix.'fb_link',
		'tab'	=> esc_html__( 'Agent Social Links', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Twitter', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter twitter link of agent/agency.', 'zoacres' ),
		'id'	=> $prefix.'twitter_link',
		'tab'	=> esc_html__( 'Agent Social Links', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Linkedin', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter linkedin link of agent/agency.', 'zoacres' ),
		'id'	=> $prefix.'linkedin_link',
		'tab'	=> esc_html__( 'Agent Social Links', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Youtube', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter youtube link of agent/agency.', 'zoacres' ),
		'id'	=> $prefix.'yt_link',
		'tab'	=> esc_html__( 'Agent Social Links', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Instagram', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter instagram link of agent/agency.', 'zoacres' ),
		'id'	=> $prefix.'instagram_link',
		'tab'	=> esc_html__( 'Agent Social Links', 'zoacres' ),
		'type'	=> 'url',
		'default'	=> ''
	)
);
$agent_box = new Custom_Add_Meta_Box( 'zoacres_agent_metabox', esc_html__( 'Zoacres Agent Options', 'zoacres' ), $agency_fields, 'zoacres-agent', true );

/* Custom Post Type Options */
$zoacres_option = get_option( 'zoacres_options' );

// Testimonial Options
if( isset( $zoacres_option['cpt-opts'] ) && is_array( $zoacres_option['cpt-opts'] ) && in_array( "testimonial", $zoacres_option['cpt-opts'] ) ){
	
	$prefix = 'zoacres_testimonial_';
	$testimonial_fields = array(	
		array( 
			'label'	=> esc_html__( 'Author Designation', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter author designation.', 'zoacres' ), 
			'id'	=> $prefix.'designation',
			'tab'	=> esc_html__( 'Testimonial', 'zoacres' ),
			'type'	=> 'text',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Company Name', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter company name.', 'zoacres' ), 
			'id'	=> $prefix.'company_name',
			'tab'	=> esc_html__( 'Testimonial', 'zoacres' ),
			'type'	=> 'text',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Company URL', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter company URL.', 'zoacres' ), 
			'id'	=> $prefix.'company_url',
			'tab'	=> esc_html__( 'Testimonial', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Rating', 'zoacres' ),
			'desc'	=> esc_html__( 'Set user rating.', 'zoacres' ), 
			'id'	=> $prefix.'rating',
			'tab'	=> esc_html__( 'Testimonial', 'zoacres' ),
			'type'	=> 'rating',
			'default'	=> ''
		)
	);
	
	// CPT Testimonial Options
	$testimonial_box = new Custom_Add_Meta_Box( 'zoacres_testimonial_metabox', esc_html__( 'Zoacres Testimonial Options', 'zoacres' ), $testimonial_fields, 'zoacres-testimonial', true );
	
	// CPT Testimonial Page Options
	$testimonial_page_box = new Custom_Add_Meta_Box( 'zoacres_testimonial_page_metabox', esc_html__( 'Zoacres Page Options', 'zoacres' ), $page_fields, 'zoacres-testimonial', true );
	
} // In theme option CPT option if testimonial exists

// Team Options
if( isset( $zoacres_option['cpt-opts'] ) && is_array( $zoacres_option['cpt-opts'] ) && in_array( "team", $zoacres_option['cpt-opts'] ) ){
	
	$prefix = 'zoacres_team_';
	$team_fields = array(	
		array( 
			'label'	=> esc_html__( 'Member Designation', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter member designation.', 'zoacres' ), 
			'id'	=> $prefix.'designation',
			'tab'	=> esc_html__( 'Team', 'zoacres' ),
			'type'	=> 'text',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Member Email', 'zoacres' ),
			'desc'	=> esc_html__( 'Enter member email.', 'zoacres' ), 
			'id'	=> $prefix.'email',
			'tab'	=> esc_html__( 'Team', 'zoacres' ),
			'type'	=> 'text',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Link Target', 'zoacres' ),
			'id'	=> $prefix.'link_target',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'select',
			'options' => array ( 
				'_blank' => esc_html__( 'New Window', 'zoacres' ),
				'_self' => esc_html__( 'Self Window', 'zoacres' )
			),
			'default'	=> '_blank'
		),
		array( 
			'label'	=> esc_html__( 'Facebook', 'zoacres' ),
			'desc'	=> esc_html__( 'Facebook profile link.', 'zoacres' ), 
			'id'	=> $prefix.'facebook',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Twitter', 'zoacres' ),
			'desc'	=> esc_html__( 'Twitter profile link.', 'zoacres' ), 
			'id'	=> $prefix.'twitter',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Instagram', 'zoacres' ),
			'desc'	=> esc_html__( 'Instagram profile link.', 'zoacres' ), 
			'id'	=> $prefix.'instagram',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Linkedin', 'zoacres' ),
			'desc'	=> esc_html__( 'Linkedin profile link.', 'zoacres' ), 
			'id'	=> $prefix.'linkedin',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Pinterest', 'zoacres' ),
			'desc'	=> esc_html__( 'Pinterest profile link.', 'zoacres' ), 
			'id'	=> $prefix.'pinterest',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Dribbble', 'zoacres' ),
			'desc'	=> esc_html__( 'Dribbble profile link.', 'zoacres' ), 
			'id'	=> $prefix.'dribbble',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Flickr', 'zoacres' ),
			'desc'	=> esc_html__( 'Flickr profile link.', 'zoacres' ), 
			'id'	=> $prefix.'flickr',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Youtube', 'zoacres' ),
			'desc'	=> esc_html__( 'Youtube profile link.', 'zoacres' ), 
			'id'	=> $prefix.'youtube',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		),
		array( 
			'label'	=> esc_html__( 'Vimeo', 'zoacres' ),
			'desc'	=> esc_html__( 'Vimeo profile link.', 'zoacres' ), 
			'id'	=> $prefix.'vimeo',
			'tab'	=> esc_html__( 'Social', 'zoacres' ),
			'type'	=> 'url',
			'default'	=> ''
		)
	);
	
	// CPT Team Options
	$team_box = new Custom_Add_Meta_Box( 'zoacres_team_metabox', esc_html__( 'Zoacres Team Options', 'zoacres' ), $team_fields, 'zoacres-team', true );
	
	// CPT Team Page Options
	$team_page_box = new Custom_Add_Meta_Box( 'zoacres_team_page_metabox', esc_html__( 'Zoacres Page Options', 'zoacres' ), $page_fields, 'zoacres-team', true );
	
} // In theme option CPT option if team exists

// Package Options

$currency = 'USD';
if( isset( $zoacres_options['package-currencies'] ) ){
	if( $zoacres_options['package-currencies'] != 'custom' ){
		$currency = $zoacres_options['package-currencies'];
	}else if( $zoacres_options['package-currencies'] == 'custom' ){
		$currency = isset( $zoacres_options['package-custom-currency'] ) && $zoacres_options['package-custom-currency'] != '' ? $zoacres_options['package-custom-currency'] : 'USD';
	}
}

$prefix = 'zoacres_package_';
$package_fields = array(	
	array( 
		'label'	=> esc_html__( 'Package Time Limit', 'zoacres' ),
		'desc'	=> esc_html__( 'Choose package time limit by day/week/month or year.', 'zoacres' ), 
		'id'	=> $prefix.'time_limit',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'days' => esc_html__( 'Days', 'zoacres' ),
			'week' => esc_html__( 'Week', 'zoacres' ),
			'month' => esc_html__( 'Month', 'zoacres' ),
			'year' => esc_html__( 'Year', 'zoacres' )
		),
		'default'	=> 'days'
	),
	array( 
		'label'	=> esc_html__( 'Package Time x Units', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter package units in number.', 'zoacres' ), 
		'id'	=> $prefix.'time_units',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Listing Count Status', 'zoacres' ),
		'id'	=> $prefix.'listing_count_stat',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'lim' => esc_html__( 'Limited', 'zoacres' ),
			'ul' => esc_html__( 'Unlimited', 'zoacres' )
		),
		'default'	=> 'ul'
	),
	array( 
		'label'	=> esc_html__( 'Listing Count', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter listing count for current package.', 'zoacres' ), 
		'id'	=> $prefix.'listing_count',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> '',
		'required'	=> array( $prefix.'listing_count_stat', 'lim' )
	),
	array( 
		'label'	=> esc_html__( 'Listing Featured Count', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter count for featured properties.', 'zoacres' ), 
		'id'	=> $prefix.'featured_count',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Images Maximum Limit Status', 'zoacres' ),
		'id'	=> $prefix.'image_max_stat',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'select',
		'options' => array ( 
			'lim' => esc_html__( 'Limited', 'zoacres' ),
			'ul' => esc_html__( 'Unlimited', 'zoacres' )
		),
		'default'	=> 'ul'
	),
	array( 
		'label'	=> esc_html__( 'Images Maximum Limit', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter maximum image limit for one listing.', 'zoacres' ), 
		'id'	=> $prefix.'image_max',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> '',
		'required'	=> array( $prefix.'image_max_stat', 'lim' )
	),
	array( 
		'label'	=> esc_html__( 'Package Price in ', 'zoacres' ) . $currency,
		'desc'	=> esc_html__( 'Enter price in value. Example 100', 'zoacres' ), 
		'id'	=> $prefix.'price',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
	array( 
		'label'	=> esc_html__( 'Package For', 'zoacres' ),
		'id'	=> $prefix.'for',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'multiselect',
		'multiple'	=> true,
		'options' => array ( 
			'agent' => esc_html__( 'Agent', 'zoacres' ),
			'agency' => esc_html__( 'Agency', 'zoacres' )
		)
	),
	array( 
		'label'	=> esc_html__( 'Package Slug', 'zoacres' ),
		'desc'	=> esc_html__( 'Enter package unique id for transaction', 'zoacres' ), 
		'id'	=> $prefix.'stripe_id',
		'tab'	=> esc_html__( 'General', 'zoacres' ),
		'type'	=> 'text',
		'default'	=> ''
	),
);

// CPT Package Options
$package_box = new Custom_Add_Meta_Box( 'zoacres_package_metabox', esc_html__( 'Zoacres Package Options', 'zoacres' ), $package_fields, 'zoacres-package', true );
