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
                <ul>
                    <li>Open <strong>Text</strong> tab in editor 
                    <img src="<?php echo esc_url( $imgurl .'mxmt-admin-activehtml.png' ); ?>" />
                    </li>
                </ul>
                <h3>Next</h3>
                <ul>
                <li>Determine layout and <strong>find code</strong> to use inside the Editor.</li>
                </ul>
                <details>
                <summary>View Layout Choices</summary>
                <table class="widefat" id="mxmtListC">
                    <thead><tr><th>columns</th><th>cols</th><th>copy (CTRL+C)</th></tr></thead>
                <tbody><tr><td>[________]</td><td>1</td><td>&lt;div class="mixmat_one"&gt;Text goes here&lt;/div></td></tr>
                <tr><td>[___][___]</td>
                <td>2</td><td>&lt;div class="mixmat_one_half"&gt;<?php print($tgh); ?>&lt;/div>
                    &lt;div class="mixmat_last_one_half"&gt;<?php print($tgh); ?>&lt;/div>
                </td></tr>
                <tr><td>[__][__][__]</td>
                <td>3</td><td>&lt;div class="mixmat_one_third"&gt;<?php print($tgh); ?>&lt;/div>
                    &lt;div class="mixmat_one_third"&gt;<?php print($tgh); ?>&lt;/div>
                    &lt;div class="mixmat_last_one_third"&gt;<?php print($tgh); ?>&lt;/div>
                </td></tr>
                <tr><td>[_][_][_][_]</td>
                <td>4</td><td>&lt;div class="mixmat_one_forth"&gt;<?php print($tgh); ?>&lt;/div>
                    &lt;div class="mixmat_one_forth"&gt;<?php print($tgh); ?>&lt;/div>
                    &lt;div class="mixmat_one_forth"&gt;<?php print($tgh); ?>&lt;/div>
                    &lt;div class="mixmat_last_one_forth"&gt;<?php print($tgh); ?>&lt;/div>
                    </td></tr></tbody>
                </table>
</details>
                <h3>Then</h3>
                <ul>
                <li>Paste the code (CTRL+V) into the <strong>Text Editor</strong>
                    <img src="<?php echo esc_url( $imgurl .'mxmt-admin-activehtml.png' ); ?>" /></li>
                </ul>
                <table class="widefat" id="mxmtListD"><tbody>
                <tr><td>&lt;div class="mixmat_one_half"&gt;Example two columns&lt;/div>
                    &lt;div class="mixmat_last_one_half"&gt;Last one half column&lt;/div>
                    </td>
                </tr></tbody></table>
                <h3>Last Step</h3>
                <ul>
                    <li>Switch to <strong>Visual</strong> Editor tab to add content. Save.
                    <div class="wp-editor-tabs">
                        <button type="button" id="" class="wp-switch-editor switch-tmce" 
                        style="background:#fefefe">Visual</button>
                        <button type="button" id="" class="wp-switch-editor switch-html" >
                        Text</button>
                    </div></li>
                </ul>
                <table class="widefat" id="mxmtListD"><tbody><tr><td>
                Start content here<br>
                Start content here<br>
                Start content here... Tip: type directly over these 3 words to keep pagemixer boxes in place.
                </td></tr></tbody></table>

                <div style="padding:15px;"><!--
                    <input type="button" class="button-primary" value="Insert Shortcode"
                    onclick="InsertContainer()" name="submit" />&nbsp;&nbsp;&nbsp; -->
                    <a class="button" href="#" onclick="tb_remove();
                            return false;"><?php esc_html_e('Close', 'mixmat'); ?></a>
                </div>
                <div class="mxmt-footer">
                    <h5><?php esc_html_e( 'Examples', 'mixmat' ); ?></h5><!--
<p style="line-height: 1; margin: 6px 0;">1/2 + last_1/2 = 1 ----- one = 1</p>
<p style="line-height: 1; margin: 6px 0;">1/3 + last_2/3 = 1 ----- 1/3 + 1/3 + last_1/3 = 1</p>
<p style="line-height: 1; margin: 6px 0;">1/4 + last_3/4 = 1 ----- 1/4 + 1/4 + 1/4 + last_1/4 = 1</p>
<p style="line-height: 1; margin: 6px 0;">3/4 + last_1/4 = 1 ----- 1/2 + 1/4 + last_1/4 = 1</p>
<p><?php esc_html_e( 'Empty row [empty_row][/empty_row] is a spacer with border on top.', 'mixmat' ); ?></p>
<p><?php esc_html_e( 'As an alternative to copy/paste, you may type in shortcode', 'mixmat' ); ?></p>
-->
</div>

            </div>

    </div>
    <?php

    }
