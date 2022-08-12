<?php
/*	-----------------------------------------------------------------------------------------------
	Theme Support
--------------------------------------------------------------------------------------------------- */



 if(! function_exists('blocktheme_support')) :

	function blocktheme_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style('style.css');

	}

 endif;

add_action('after_setup_theme', 'blocktheme_support');

/*	-----------------------------------------------------------------------------------------------
	Enqueue Stylesheet & Scripts
--------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'blocktheme_styles_scripts' ) ) :


	function blocktheme_styles_scripts() {
		$theme_version  = wp_get_theme()->get( 'Version' );
		$version_string = is_string( $theme_version ) ? $theme_version : false;
		$in_footer = true;

		wp_enqueue_style('blocktheme-style',get_theme_file_uri('/style.css'),$version_string);
		wp_enqueue_script('blocktheme-app',get_theme_file_uri('/assets/js/app.js'),array(),$theme_version,$in_footer);


	}

endif;

add_action('wp_enqueue_scripts', 'blocktheme_styles_scripts');


/*	-----------------------------------------------------------------------------------------------
	Enqeuue Blocks Styles
--------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'blocktheme_block_styles' ) ) :

	function blocktheme_block_styles() {
		$theme_version  = wp_get_theme()->get( 'Version' );
		$version_string = is_string( $theme_version ) ? $theme_version : false;

		wp_enqueue_script('blocktheme-block-styles',get_theme_file_uri( '/assets/js/block-styles.js' ),array( 'wp-blocks' ),$theme_version,true);

	}

endif;

add_action( 'enqueue_block_editor_assets', 'blocktheme_block_styles' );

/*	-----------------------------------------------------------------------------------------------
	Modify Excerpt
--------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'blocktheme_excerpt_more' ) ) :

function blocktheme_excerpt_more( $more ) {
	return '&hellip;';
}
endif;

add_filter( 'excerpt_more', 'blocktheme_excerpt_more' );

/*	-----------------------------------------------------------------------------------------------
	Register Patterns Categories
--------------------------------------------------------------------------------------------------- */
if ( ! function_exists( 'blocktheme_register_block_patterns' ) ) :

function blocktheme_register_block_patterns() {
	if( ! function_exists( 'register_block_pattern_category' ) ) return;

	// The block pattern categories included in Poe.
	$blocktheme_block_pattern_categories = apply_filters( 'blocktheme_block_pattern_categories', array(
		'blocktheme-general' => array( 'label' => __( 'blocktheme General', 'blocktheme' ) ),
		'blocktheme-footer'   => array( 'label' => __( 'blocktheme Footer', 'blocktheme' ) ),
		'blocktheme-header'   => array( 'label' => __( 'blocktheme Header', 'blocktheme' ) ),
		'blocktheme-hero'    => array( 'label' => __( 'blocktheme Hero', 'blocktheme' ) ),
		'blocktheme-cta'    => array( 'label' => __( 'blocktheme CTA', 'blocktheme' ) ),
		'blocktheme-section-label'    => array( 'label' => __( 'blocktheme Section Label', 'blocktheme' ) ),
	));

	// Sort the block pattern categories alphabetically based on the label value, to ensure alphabetized order when the strings are localized.
	uasort( $blocktheme_block_pattern_categories, function( $a, $b ) {
		return strcmp( $a["label"], $b["label"] ); }
	);

	// Register block pattern categories.
	foreach ( $blocktheme_block_pattern_categories as $slug => $settings ) {
		register_block_pattern_category( $slug, $settings );
	}

}
endif;

add_action( 'init', 'blocktheme_register_block_patterns' );