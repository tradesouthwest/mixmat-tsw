<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://tradesouthwest.com
 * @since      1.0.0
 * @deprecated Not using shortcodes
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/public/partials
 */

// ---------------- Filters ---------------- //
// #F1
add_filter( 'the_content', 'mixmat_tsw_remove_empties_from_paragraphs' ); 

/** @id= F1
 * Removes empty paragraph tags from shortcodes in WordPress.
 */
function mixmat_tsw_remove_empties_from_paragraphs( $content ) {

    $toFix = array( 
        '<p>['    => '[', 
        ']</p>'   => ']', 
        ']<br />' => ']'
    ); 
    return strtr( $content, $toFix );
}

if ( !function_exists('mixmat_fix_shortcodes') ) {
    function mixmat_fix_shortcodes($content){
        $array = array (
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }
    add_filter('the_content', 'mixmat_fix_shortcodes');
} 

/**
 * HTML mark-up for an enclosing shortcode
 * make sure they are all loaded before calling into js
 * @wp do_shortcode()
 * @array .mxmt-xs-3, .mxmt-xs-4, .mxmt-xs-6, .mxmt-xs-8, .mxmt-xs-9, .mxmt-xs-12
 * @facevalue  1/4    1/3    1/2    2/3    3/4    one
 *
 * Custom shortcode callback function
 *
 * @param array  $atts
 * @param string $content
 * @return string
 */

function mixmat_shortcode_callback_one( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_one">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

// 1/2
function mixmat_shortcode_callback_one_half( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_one_half">' . shortcode_unautop ( $content ) . '</div>';
    return $output;
}

//1/4
function mixmat_shortcode_callback_one_fourth( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_one_fourth">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

//1/3
function mixmat_shortcode_callback_one_third( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_one_third">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

//2/3
function mixmat_shortcode_callback_two_thirds( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_two_thirds">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}
//add_action( 'init',  'mixmat_shortcode_callback_one_third' );



//3/4
function mixmat_shortcode_callback_three_fourths( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_three_fourths">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}
//add_action( 'init',  'mixmat_shortcode_callback_three_fourths' );



//last one half
function mixmat_shortcode_callback_last_one_half( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_last_one_half">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

//last_one_fourth
function mixmat_shortcode_callback_last_one_fourth( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_last_one_fourth">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

// last 1/3
function mixmat_shortcode_callback_last_one_third( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_last_one_third">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

//2/3
function mixmat_shortcode_callback_last_two_thirds( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_last_two_thirds">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

//3/4
function mixmat_shortcode_callback_last_three_fourths( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_last_three_fourths">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}

//0/0
function mixmat_shortcode_callback_empty_row( $atts = null, $content = null ) {
    $defaults = array();
    $settings = shortcode_atts( $defaults, wp_parse_args( $atts ) );

    $output = '<div class="mxmt_empty_row">' . shortcode_unautop( $content ) . '</div>';
    return $output;
}
