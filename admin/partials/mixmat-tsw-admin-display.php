<?php 
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://tradesouthwest.com
 * @since      1.0.0
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/admin/partials
 */
?>

<div id="mxmtWrap" class="wrap">
    <h1><span class="dashicons dashicons-admin-settings">
    </span>
    <?php echo esc_html__( ' MixMat PageMixer', 'mixmat-tsw' ); ?></h1>

    <form action="options.php" method="post">
    <?php 
    settings_fields( 'mixmat_tsw_options' );
    do_settings_sections( 'mixmat-tsw-options' );
    ?>
    <?php submit_button(); ?>

    </form>

    <div class="mixmat-instructions-admin">
        <h2><?php esc_html_e( 'Page Sections Builder Information', 'mixmat' ); ?></h2>
       
    </div>
</div>
