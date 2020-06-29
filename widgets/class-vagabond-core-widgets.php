<?php
/**
 * The widget functionality of the plugin.
 *
 * @link       http://www.alexisvillegas.com/
 * @since      1.0.0
 *
 * @package    Vagabond_Core
 * @subpackage Vagabond_Core/widget
 */

/**
 * The widget functionality of the plugin. This class is responsible for registering
 * all the widgets and all widget related functionality.
 *
 * @package    Vagabond_Core
 * @subpackage Vagabond_Core/widgets
 * @author     Alexis J. Villegas <alexis@ajvillegas.com>
 */
class Vagabond_Core_Widgets {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name The name of this plugin.
	 * @param    string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->load_widget_classes();

	}

	/**
	 * Load widget classes.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_widget_classes() {

		/**
		 * The class responsible for defining the Featured Page widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/class-vagabond-featured-page-widget.php';

		/**
		 * The class responsible for defining the Subscribe Form widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/class-vagabond-cta-form-widget.php';

	}

	/**
	 * Register the JavaScript for the widget's admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param string $hook The WordPress admin page hook.
	 */
	public function enqueue_scripts( $hook ) {

		// Load script on widgets page only.
		if ( 'widgets.php' !== $hook ) {
			return;
		}

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Image uploader scripts.
		wp_enqueue_media();

		wp_enqueue_script( 'vagabond-image-upload', plugin_dir_url( __FILE__ ) . "js/image-upload{$suffix}.js", array( 'jquery' ), $this->version, true );

		wp_localize_script(
			'vagabond-image-upload',
			'vagabondImageUpload',
			array(
				'frame_title'  => __( 'Choose or Upload Image', 'vagabond-core' ),
				'frame_button' => __( 'Insert Image', 'vagabond-core' ),
			)
		);

	}

	/**
	 * Register all widgets.
	 *
	 * @since   1.0.0
	 **/
	public function register_widgets() {

		// Register the CTA Form widget.
		register_widget( 'Vagabond_CTA_Form_Widget' );

		// Register the Featured Page widget.
		register_widget( 'Vagabond_Featured_Page_Widget' );

	}

}
