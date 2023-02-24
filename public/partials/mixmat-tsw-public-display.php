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
