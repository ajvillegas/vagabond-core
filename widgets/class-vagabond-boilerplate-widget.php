<?php
/**
 * Boilerplate widget.
 *
 * @since      1.0.0
 *
 * @package    Vagabond_Core
 * @subpackage Vagabond_Core/widgets
 * @link       https://www.alexisvillegas.com
 */

/**
 * Boilerplate widget.
 *
 * Boilerplate widget description.
 *
 * @link       https://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Vagabond_Core
 * @subpackage Vagabond_Core/widgets
 */
class Vagabond_Boilerplate_Widget extends WP_Widget {
	/**
	 * Constructor
	 *
	 * Specifies the class name and description, instantiates the widget,
	 * loads localization files, and includes any necessary stylesheets and JavaScript.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'vagabond-boilerplate',
			'description'                 => esc_html__( 'Boilerplate widget description.', 'vagabond-core' ),
			'customize_selective_refresh' => true,
		);

		$control_ops = array(
			'id_base' => 'vagabond-boilerplate',
		);

		parent::__construct( 'vagabond-boilerplate', esc_html__( 'Boilerplate Widget', 'vagabond-core' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     The array of form elements.
	 * @param array $instance The current instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
			)
		);

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $instance['title'] ) {
			echo $args['before_title'] . apply_filters( 'widget_title', esc_html( $instance['title'] ) ) . $args['after_title'];  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance The new instance of values to be generated via the update.
	 * @param array $old_instance The previous instance of values before the update.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = wp_strip_all_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {
		$defaults = array(
			'title' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'vagabond-core' ); ?></label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<?php
	}
}
