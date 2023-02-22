<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tradesouthwest.com
 * @since      1.0.0
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/admin
 * @see Based On https://github.com/mandiwise/wp-plugin-settings-framework
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mixmat_Tsw
 * @subpackage Mixmat_Tsw/admin
 * @author     Tradesouthwest <tradesouthwest@gmail.com>
 */
class Mixmat_Tsw_Admin {

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
       * The settings sections.
       *
       * @since    1.0.0
       * @access   private
       * @var      array    $sections    The array of settings sections.
       */
      private $sections;

      /**
       * The checkbox-based settings.
       *
       * @since    1.0.0
       * @access   private
       * @var      array    $checkboxes    The array of checkbox-based settings.
       */
      private $checkboxes;

      /**
       * The settings fields.
       *
       * @since    1.0.0
       * @access   private
       * @var      array    $settings    The array of settings fields.
       */
      private $settings;

      /**
       * The domain specified for this plugin.
       *
       * @since    1.0.0
       * @access   private
       * @var      string    $domain    The domain identifier for this plugin.
       */
      private $domain;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->domain      = 'mixmat-tsw';
        $this->settings    = array();
        $this->checkboxes  = array();
        $this->get_settings();

        // Create the settings sections
        $this->sections['general'] = __( 'General Settings', $this->domain );
        $this->sections['extra'] = ''; //__( 'Instructions and Help', $this->domain );

        add_action( 'admin_menu', array( $this, 'add_menu' ) );
        add_action( 'admin_init', array( $this, 'admin_init' ), 9 );
        add_action( 'admin_init', array( $this, 'editor_styles' ) );
        if ( ! get_option( 'mixmat_tsw_options' ) ) {
            $this->initialize_settings();
        }
        require_once plugin_dir_path( dirname( __FILE__ ) ) 
			. 'admin/partials/mixmat-tsw-admin-editor-tools.php'; 
        
	}

    /**
	 * Register the stylesheets for the tinymce editor area.
	 *
	 * @since    1.0.1
	 */
    public function editor_styles() {
        add_theme_support( 'editor-styles' );
        add_editor_style( plugin_dir_url( __FILE__ ) . 'css/mixmat-tsw-theme-editor-v1.css' );
    }

	/**
	* Get a plugin options by its key (to be used in other plugin files).
	* This schema saves all data as serialized data
    *
	* @since 1.0.0
    * @param string $options The main serialized option set to this plugin.
	*/
	public function mixmat_tsw_option( $option ) {
		$options = get_option( 'mixmat_tsw_options' );

		if ( isset( $options[$option] ) ) {
			return $options[$option];
		} else {
			return false;
		}
	}

	/**
	 * Register the stylesheets for the admin area.
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
        wp_enqueue_style( $this->plugin_name .'-admin', 
			plugin_dir_url( __FILE__ ) . 'css/mixmat-tsw-admin.css', 
			array(), 
			$this->version 
		); 
        wp_enqueue_style( $this->plugin_name .'-theme-editor', 
			plugin_dir_url( __FILE__ ) . 'css/mixmat-tsw-theme-editor.css', 
			array(), 
			time() 
		); 
        
        $css_src = includes_url('css/') . 'editor.css';
        wp_register_style('tinymce_css', $css_src);
        wp_enqueue_style( 'tinymce_css' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
     * @see https://wordpress.stackexchange.com/questions/175307/tinymce-is-not-defined-when-not-using-wp-editor
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Mixmat_Tsw_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mixmat_Tsw_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/mixmat-tsw-admin.js', 
			array( 'jquery' ), 
			time(), 
			true 
		);
        $js_src = includes_url('js/tinymce/') . 'tinymce.min.js';
        wp_enqueue_script( 'tinymce_script_min', $js_src );

	}

    /**
	 * Register the tinymce buttons and addons
	 *
	 * @since    1.0.1
     * TinyMCE Buttons
	 */
    public function mixmat_tsw_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }
        add_filter( 'mce_buttons', 'mixmat_tsw_render_mixers' );
        add_filter( 'mce_external_plugins', 'mixmat_tsw_add_mixers' );
    }

	/**
     * Initialize the sections and their settings.
     *
     * @since    1.0.0
     */
    public function admin_init() {

        register_setting( 'mixmat_tsw_options', 'mixmat_tsw_options', array( 
                            &$this, 'validate_settings' ) );

        foreach ( $this->sections as $slug => $title ) {
            if ( $slug == 'general' ) {
               add_settings_section( $slug, $title, array( 
                                    &$this, 'display_general_section' ), 'mixmat-tsw-options' );
            } elseif ( $slug == 'extra' ) {
               add_settings_section( $slug, $title, array( 
                                    &$this, 'display_extra_section' ), 'mixmat-tsw-options' );
            } else {
               add_settings_section( $slug, $title, array( 
                                    &$this, 'display_section' ), 'mixmat-tsw-options' );
            }
        }

        $this->get_settings();

        foreach ( $this->settings as $id => $setting ) {
            $setting['id'] = $id;
            $this->create_setting( $setting );

        }
    }  
	
	/**
     * Add the submenu page.
     *
     * @since    1.0.0
     */
    public function add_menu() {
        add_menu_page(
            __( 'mixmat tsw settings', $this->domain ),
            __( 'MixMat TSW', $this->domain ),
            'manage_options',
            'mixmat-tsw-options',
            array( $this, 'plugin_settings_page' ),
            'dashicons-admin-settings',
            61
        );
    }

    /**
     * Create settings field default args.
     *
     * @param    array    The default args for a given setting.
     * @since    1.0.0
     */
    public function create_setting( $args = array() ) {

        $defaults = array(
            'id'      => 'default_field',
            'title'   => __( 'Default Field', $this->domain ),
            'desc'    => '',
            'std'     => '',
            'type'    => 'text',
            'section' => 'general',
            'choices' => array(),
            'class'   => '',
			'cssid'   => '',
            'step'    => '',
            'min'     => '0',
            'max'     => ''
        );

        extract( wp_parse_args( $args, $defaults ) );

        $field_args = array(
            'type'      => $type,
            'id'        => $id,
            'desc'      => $desc,
            'std'       => $std,
            'choices'   => $choices,
            'label_for' => $id,
            'class'     => $class,
		    'cssid'     => $cssid,
            'step'      => $step,
            'min'       => $min,
            'max'       => $max
        );
		if ( $type == 'checkbox' ) {
            $this->checkboxes[] = $id;
        }

        add_settings_field( $id, $title, array( $this, 'display_setting' ), 
                            'mixmat-tsw-options', $section, $field_args );
    }

	/**
     * Initialize the settings to their default values.
     *
     * @since    1.0.0
     */
    public function initialize_settings() {

        $default_settings = array();
        foreach ( $this->settings as $id => $setting ) {
            $default_settings[$id] = $setting['std'];
        }

        update_option( 'mixmat_tsw_options', $default_settings );

    }
	
	/**
     * Callback for the "General" sample section.
     *
     * @since    1.0.0
     */
    public function display_general_section() {
        echo '<p>These settings do general things for the plugin.</p>';
    }
	
	/**
     * Callback for the "Extra" sample section.
     *
     * @since    1.0.0
     */
    public function display_extra_section() {
        //echo '<p>These settings do extra things for the plugin.</p>';
        return false;
    }

    /**
     * Callback for future sections that don't have descriptions.
     *
     * @since    1.0.0
     */
    public function display_section() {
        // The default echos nothing for the description...
	    echo '<p>To do</p>';
    }

    /**
     * Display the plugin settings page if the user has sufficient privileges.
     *
     * @since    1.0.0
     */
    public function plugin_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Sorry! You don\'t have sufficient permissions to access this page.', $this->domain ) );
        }

        include( sprintf( "%s/partials/mixmat-tsw-admin-display.php", 
			dirname( __FILE__ ) ) 
		);
    }

	/**
     * Define all settings for the plugin and their defaults.
     *
     * @since    1.0.0
     */
    public function get_settings() {

        // This is where the settings are created...

        $this->settings['mixmat_color_field_0'] = array(
            'section' => 'general',
            'title'   => __( 'Select Background Color', $this->domain ),
            'desc'    => '',
            'type'    => 'color',
            'std'     => '#ffffff',
			'cssid'   => 'mixmat_color'
        );
        $this->settings['mixmat_color_field_1'] = array(
            'section' => 'general',
            'title'   => __( 'Select BoxShadow Color', $this->domain ),
            'desc'    => '',
            'type'    => 'color',
            'std'     => '#cccccc',
			'cssid'   => 'mixmat_shado'
        );
        // mixmat_theme_adjustment_option
        $this->settings['mixmat_theme_margins_option'] = array(
            'section' => 'general',
            'title'   => __( 'Alternate Margins', $this->domain ),
            'desc'    => ' Adjustment (in pxs) to make less or more space between boxes.',
            'type'    => 'number',
            'std'     => '',
            'min'     => '-30',
            'max'     => '120',
            'step'    => 1
        );
        $this->settings['mixmat_theme_adjustment_option'] = array(
            'section' => 'general',
            'title'   => __( 'Alternate Theme Adjustment', $this->domain ),
            'desc'    => __( 'Some themes may render the four box width ([one_fourth]) too thin. Try this to make them two wide.', $this->domain ),
            'type'    => 'checkbox',
            'std'     => 1 
        );
         $this->settings['example_select'] = array(
            'section' => 'general',
            'title'   => __( 'Example Select', $this->domain ),
            'desc'    => __( 'This is a description for the drop-down.', $this->domain ),
            'type'    => 'select',
            'std'     => '',
            'choices' => array(
               'choice1' => __( 'Other Choice 1', $this->domain ),
               'choice2' => __( 'Other Choice 2', $this->domain ),
               'choice3' => __( 'Other Choice 3', $this->domain )
            )
        );

    }

    /**
     * Create the HTML output for each possible type of setting
     *
     * @param    array    The default args for a given setting.
     * @since    1.0.0
     */
    public function display_setting( $args = array() ) {

        extract( $args );
        $options = get_option( 'mixmat_tsw_options' );

        if ( ! isset( $options[$id] ) && $type != 'checkbox' ) {
            $options[$id] = $std;
        } elseif ( ! isset( $options[$id] ) ) {
            $options[$id] = 0;
        }

        $field_class = '';

        if ( $class != '' ) {
            $field_class = ' ' . $class;
        }

		$css_id = '';

        if ( $cssid != '' ) {
            $css_id = ' ' . $cssid;
        }
        $steps = '';

        if ( $step != '' ) {
            $steps = ' ' . $step;
        }

        switch ( $type ) {

            case 'checkbox':
                echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="mixmat_tsw_options[' . $id . ']" value="1" ' . checked( $options[$id], 1, false ) . ' /> <label for="' . $id . '">' . $desc . '</label>';
            break;

            case 'select':
                echo '<select class="select' . $field_class . '" name="mixmat_tsw_options[' . $id . ']">';
                foreach ( $choices as $value => $label ) {
                    echo '<option value="' . esc_attr( $value ) . '"' . selected( $options[$id], $value, false ) . '>' . $label . '</option>';
                }
                echo '</select>';

                if ( $desc != '' ) {
                    echo '<p class="description">' . $desc . '</p>';
                }
            break;

            case 'radio':
                $i = 0;
                foreach ( $choices as $value => $label ) {
                    echo '<input class="radio' . $field_class . '" type="radio" name="mixmat_tsw_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr( $value ) . '" ' . checked( $options[$id], $value, false ) . '> <label for="' . $id . $i . '">' . $label . '</label>';
                    if ( $i < count( $options ) - 1 )
                        echo '<br />';
                    $i++;
                }

                if ( $desc != '' ) {
                    echo '<p class="description">' . $desc . '</p>';
                }
            break;

            case 'textarea':
                echo '<textarea class="' . $field_class . '" id="' . $id . '" name="mixmat_tsw_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre( $options[$id] ) . '</textarea>';

                if ( $desc != '' ) {
                    echo '<p class="description">' . $desc . '</p>';
                }
            break;

            case 'password':
                echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="mixmat_tsw_options[' . $id . ']" value="' . esc_attr( $options[$id] ) . '" />';

                if ( $desc != '' ) {
                    echo '<p class="description">' . $desc . '</p>';
                }
            break;

            case 'color':
                echo '<input class="wp-color-picker' . $field_class . '" type="color" 
                    id="' . $id . ' ' . $cssid . '" name="mixmat_tsw_options[' . $id . ']" 
                    value="' . esc_attr( $options[$id] ) . '" size="30">
                    <span> ' . esc_attr( $options[$id] ) . '</span>';

                if ( $desc != '' ) {
                    echo '<p class="description">' . $desc . '</p>';
                }
            break;

            case 'number':
                echo '<input class="regular-number ' . $field_class . '" type="number" 
                    id="' . $id . ' ' . $cssid . '" name="mixmat_tsw_options[' . $id . ']" 
                    value="' . esc_attr( $options[$id] ) . '" min="' . $min . '" max="' . $max . '" 
                    step="' . $step . '" size="30"><span> ' . esc_attr( $options[$id] ) . '</span>';

                if ( $desc != '' ) {
                    echo '<p class="description">' . $desc . '</p>';
                }
            break;

            case 'text':
            default:
                echo '<input class="regular-text' . $field_class . '" type="text" 
				    id="' . $id . '" name="mixmat_tsw_options[' . $id . ']" 
                    placeholder="' . $std . '" value="' . esc_attr( $options[$id] ) . '" />';

                if ( $desc != '' ) {
                    echo '<p class="description">' . $desc . '</p>';
                }
            break;
        }

    }

    /**
     * Perform custom validation on the settings prior to saving.
     *
     * @param    array    $input    The array of settings to be saved.
     * @since    1.0.0
     */
    public function validate_settings( $input ) {

        // Create array for storing the validated options
        $output = array();

        // Loop through each of the incoming options
        foreach( $input as $key => $value ) {

            // Check to see if the current option has a value and then process it
            if( isset( $input[$key] ) ) {
               $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
            }

        }

        return apply_filters( 'validate_settings', $output, $input );
    }

}
