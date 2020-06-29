<?php
/**
 * CTA Form widget.
 *
 * @since      1.0.0
 *
 * @package    Vagabond_Core
 * @subpackage Vagabond_Core/widgets
 * @link       https://www.alexisvillegas.com
 */

/**
 * CTA Form widget.
 *
 * Provides a call-to-action wrapper for a form shortcode.
 *
 * @link       https://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Vagabond_Core
 * @subpackage Vagabond_Core/widgets
 */
class Vagabond_CTA_Form_Widget extends WP_Widget {
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
			'classname'                   => 'vgb-cta-form',
			'description'                 => esc_html__( 'Provides a call-to-action wrapper for a form shortcode.', 'vagabond-core' ),
			'customize_selective_refresh' => true,
		);

		$control_ops = array(
			'id_base' => 'vgb-cta-form',
		);

		parent::__construct( 'vgb-cta-form', esc_html__( 'CTA Form', 'vagabond-core' ), $widget_ops, $control_ops );
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
				'title'       => '',
				'text'        => '',
				'shortcode'   => '',
				'privacy_url' => '',
			)
		);

		$text = apply_filters( 'widget_text_content', wp_kses_post( $instance['text'] ), $instance, $this );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $instance['shortcode'] ) {
			?>
			<div class="form-cta">
				<fieldset>
					<div class="form-wrap">
						<?php
						if ( $instance['title'] ) {
							?>
							<h3 class="heading"><?php echo esc_html( $instance['title'] ); ?></h3>
							<?php
						}

						if ( $instance['text'] ) {
							echo wp_kses_post( $text );
						}

						echo do_shortcode( $instance['shortcode'] );
						?>

						<p class="disclaimer">
							<?php
							echo sprintf(
								/* translators: 1: privacy policy URL opening tag, 2: privacy policy URL closing tag */
								esc_html__( '*Your privacy is %1$sour policy%2$s.', 'vagabond' ),
								'<a href="' . esc_url( $instance['privacy_url'] ) . '">',
								'</a>'
							);
							?>
						</p>
					</div>
				</fieldset>
			</div>
			<?php
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
		$instance                = $old_instance;
		$instance['title']       = wp_strip_all_tags( $new_instance['title'] );
		$instance['shortcode']   = wp_strip_all_tags( $new_instance['shortcode'] );
		$instance['privacy_url'] = esc_url( $new_instance['privacy_url'] );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = wp_kses_post( $new_instance['text'] );
		}

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
			'title'       => '',
			'text'        => '',
			'shortcode'   => '',
			'privacy_url' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'vagabond-core' ); ?></label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php echo esc_html__( 'Body Text:', 'stunt-park-core' ); ?></label>
			<textarea class="widefat" rows="6" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'shortcode' ) ); ?>"><?php echo esc_html__( 'Form Shortcode:', 'vagabond-core' ); ?></label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'shortcode' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shortcode' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['shortcode'] ); ?>"/>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'privacy_url' ) ); ?>"><?php echo esc_html__( 'Privacy Page URL:', 'vagabond-core' ); ?></label>

			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'privacy_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'privacy_url' ) ); ?>" value="<?php echo esc_url( $instance['privacy_url'] ); ?>" />
		</p>
		<?php
	}
}
