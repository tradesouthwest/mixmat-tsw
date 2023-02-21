<?php 
/**
 * Utility to add MCE Popup fired by custom Media Buttons button
 * @param $tgh string Text goes here translatable text string.
 * 
 * @since 1.0.1
 * @hook admin_footer
 */
 
/**
 * The plugin form rendering file
 *
 * @since             1.0.0
 * @package           Mixmat
 * @subpackage        Mixmat/includes
 *
*/
//add_theme_support( 'editor-styles' );

// move wpautop filter to AFTER shortcode is processed
//remove_filter( 'the_content', 'wpautop' );
//add_filter( 'the_content', 'wpautop' , 99);
//add_filter( 'the_content', 'shortcode_unautop', 100 );
add_action( 'init', 'mixmat_tsw_buttons' );
add_action( 'admin_footer', 'mixmat_render_mce_popup' );
add_action( 'media_buttons', 'mixmat_render_media_buttons' );

/**
 * Utility to add MCE Popup button to the Media Buttons section which lies directly
 * above the Visual / Text Editor
 *
 * @hook media_buttons
 */
function mixmat_render_media_buttons() {

    ?>
    <a href = "#TB_inline?width=540&height=820&inlineId=mxmt_refer_pagemixer"
    class = "button thickbox mxmt_doin_media_link" id = "add_div_pagemixer"
    title = "<?php esc_attr_e( 'Layout Selection', 'mixmat' ); ?>">
    <?php esc_attr_e( 'PageMixer', 'mixmat' ); ?></a>
    <?php
}

/**
 * @see https://madebydenis.com/adding-custom-buttons-in-tinymce-editor-in-wordpress/
 *//*
if ( ! function_exists( 'mixmat_tsw_theme_add_editor_styles' ) ) {
	function mixmat_tsw_theme_add_editor_styles() {
	    //add_editor_style( 'mixmat-tsw-admin-editor' );
        //return false;
	}
} */

/********* TinyMCE Buttons ***********/
if ( ! function_exists( 'mixmat_tsw_buttons' ) ) {
	function mixmat_tsw_buttons() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
	        return;
        }
        add_filter( 'mce_buttons', 'mixmat_tsw_render_mixers' );
        add_filter( 'mce_external_plugins', 'mixmat_tsw_add_mixers' );
    }
}

function mixmat_tsw_add_mixers($plugin_array){
$imgurl = plugin_dir_url( __FILE__ ) . 'imgs/';
$plugin_array['column']   = $imgurl . 'mxmtic-1.png';
$plugin_array['columns']  = $imgurl . 'mxmtic-2.png';
$plugin_array['columnsThree']  = $imgurl . 'mxmtic-3.png';
$plugin_array['columnsFour']  = $imgurl . 'mxmtic-4.png';
 

	    return $plugin_array;

}
function mixmat_tsw_render_mixers($buttons){
    array_push( $buttons, 'column', 'columns', 'columnsThree', 'columnsFour' );
	    return $buttons;

}

function mixmat_render_mce_popup() {
    /** Check if user have permission */
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    $tgh = __( 'Start content here', 'mixmat' );
    $imgurl = plugin_dir_url( __FILE__ ) . 'imgs/';
    ?>
    <div id="mxmt_refer_pagemixer" style="display:none;">

        <div class="mxmt-tsw-mcepopup">
            <div class="mxmt-popup-wrap">
            <h4><?php esc_html_e('Mixmat PageMixer ','mixmat'); ?> <?php esc_html_e('Follow these steps please','mixmat'); ?></h4>
                <h3>First</h3>
                <h3>Then</h3>
                <h3>Last Step</h3>
                
                <p><?php esc_html_e( 'Empty row .', 'mixmat' ); ?></p>
                <p><?php esc_html_e( 'Copy/paste .', 'mixmat' ); ?></p>
            </div>

        </div>

    </div>
    <?php

    }
