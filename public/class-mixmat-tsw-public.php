<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tradesouthwest.com
 * @since      1.0.1
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/public
 * @author     Tradesouthwest <tradesouthwest@gmail.com>
 */
class Mixmat_Tsw_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		if ( defined( 'MIXMAT_TSW_VERSION' ) ) {
			$this->version = MIXMAT_TSW_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mixmat-tsw';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Mixmat_Tsw_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mixmat_Tsw_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name .'-public', 
			plugin_dir_url( __FILE__ ) . 'css/mixmat-tsw-public.css', 
			array(), 
			$this->version, 
			'all' 
		);
		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mixmat_Tsw_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mixmat_Tsw_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$styles = $this->display_options_css();
		/* color picker not used 
		wp_enqueue_script( $this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/mixmat-tsw-public.js', 
			array( 'jquery' ), 
			$this->version, 
			false 
		); */
		wp_register_style( 'mixmat-tsw-entry-set', false );
		wp_enqueue_style(   'mixmat-tsw-entry-set' );
		wp_add_inline_style( 'mixmat-tsw-entry-set', $styles );
	}

	/**
	* Send css to head
	* Theme width adjustment options
	* @since 1.0.1
	* `Mixmat_Tsw::display_options_css`
	*/
	public function display_options_css() {
		
		$options   = get_option( 'mixmat_tsw_options' );
        $mxmtcolor = empty($options['mixmat_color_field_0']) ? '' 
                    : $options['mixmat_color_field_0'];
        $mxmtshado = empty($options['mixmat_color_field_1']) ? '' 
                    : $options['mixmat_color_field_1'];
        $mxmtchk   = (empty($options['mixmat_theme_adjustment_option']) ) 
                      ? 0 : $options['mixmat_theme_adjustment_option'];
        $mxmtmrg   = (empty($options['mixmat_theme_margins_option'])) 
                     ? 10 : $options['mixmat_theme_margins_option'];
        
        ob_start();
		echo '[class^="mixmat_"]{';
        
        if( !empty ( $mxmtcolor ) ) : 
        echo 'background: ' . $mxmtcolor . ';';
        else : 
        echo 'background: transparent;';
        endif; 
        
        if( !empty ( $mxmtshado ) ) : 
        echo 'box-shadow: 0 1px 2px ' . $mxmtshado . ';';
        else : 
        echo 'box-shadow: none;';
        endif; 

        echo '}';

        if ( $mxmtchk != 0 ) :  
        echo '@media screen and (min-width: 768px) and (max-width: 992px){
        .mixmat_one_fourth,.mixmat_last_one_fourth{width: 48%;}}';
        endif;

        if ( $mxmtmrg > 0 ) :  
        echo '@media screen and (min-width: 711px){.mixmat_empty_row, .mixmat_one, .mixmat.mixmat_one_fourth, .mixmat_one_third, .mixmat_one_half, .mixmat_two_thirds, .mixmat_three_fourths,
        .mixmat_last_one_fourth, .mixmat_last_one_third, .mixmat_last_one_half,.mixmat_last_two_thirds, 
        .mixmat_last_three_fourths{margin-bottom: '. $mxmtmrg .'px;}}';
        endif;

		$styles = ob_get_clean();
		
		return $styles;
	}
}