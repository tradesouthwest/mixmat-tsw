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

add_action( 'init', 'mixmat_tsw_buttons' );
add_action( 'admin_footer', 'mixmat_render_mce_popup' );
add_action( 'media_buttons', 'mixmat_render_media_buttons' );

//add_filter( 'the_content', 'mixmat_fix_shortcodes', 99 );

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
 *
 * ********* TinyMCE Buttons ***********
 */

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
$plugin_array['column']       = $imgurl . 'mxmtic-1.png';
$plugin_array['columns']      = $imgurl . 'mxmtic-2.png';
$plugin_array['columnsThree'] = $imgurl . 'mxmtic-3.png';
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
                <h3><?php esc_html_e( 'First', 'mixmat-tsw' ); ?></h3>
                <ul>
                <li><?php esc_html_e('Set your cursor, inside of the editor, exactly where you want a section to display.','mixmat'); ?></li>
                <li><?php esc_html_e( 'Be sure you are in the Visual editor tab when you do this step.', 'mixmat-tsw' ); ?></li>
                </ul>
                <h3><?php esc_html_e( 'Then', 'mixmat-tsw' ); ?></h3>
                <ul>
                <li><?php esc_html_e('Select the icon for the column you want in that spot.','mixmat'); ?></li>
                <li><?php esc_html_e('To add images or other content, simply Highlight the (sample) text and select an element to insert.','mixmat'); ?></li>
                <li><strong><?php esc_html_e( 'Borders in editor will not show on the front of your site. These just help sections stand out, visually.', 'mixmat-tsw' ); ?></strong></li>
                </ul>
                <img src="<?php echo esc_url( $imgurl .'mxmt-toolbar.png' ); ?>" />
                <h3><?php esc_html_e( 'Tips', 'mixmat-tsw' ); ?></h3>
                <h4><?php esc_html_e( 'USE MOUSE TO SET CURSOR/CARAT POSITION ON PAGE... not keys please.', 'mixmat-tsw' ); ?></h4>
                <p><?php esc_html_e( 'To add lots of space between rows you can use the Single Column icon and do not add any content (empty row).', 'mixmat' ); ?></p>
                <p><?php esc_html_e( 'You may need to toggle to Text editor tab in order to be sure all your work is clean and has no unneeded spaces or div tags.', 'mixmat' ); ?></p>
                <img src="<?php echo esc_url( $imgurl .'mxmt-admin-activehtml.png' ); ?>" />
                <p><?php esc_html_e( 'You can nest columns inside of other columns. Just be sure to not go too deep with nesting. Maybe two columns insed of a single half column would suffice.', 'mixmat-tsw' ); ?></p>
            </div>

        </div>

    </div>
    <?php

    }
