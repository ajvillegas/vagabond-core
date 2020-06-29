<?php
/**
 * Featured Page widget.
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
 * Display and image link to any URL.
 *
 * @link       https://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Vagabond_Core
 * @subpackage Vagabond_Core/widgets
 */
class Vagabond_Featured_Page_Widget extends WP_Widget {
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
			'classname'                   => 'vgb-featured-page',
			'description'                 => esc_html__( 'Display and image link to any URL.', 'vagabond-core' ),
			'customize_selective_refresh' => true,
		);

		$control_ops = array(
			'id_base' => 'vgb-featured-page',
		);

		parent::__construct( 'vgb-featured-page', esc_html__( 'Featured Page', 'vagabond-core' ), $widget_ops, $control_ops );

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
				'title'     => '',
				'image_url' => '',
				'link_url'  => '',
			)
		);

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( $instance['image_url'] && $instance['link_url'] ) {

			$image_url = $instance['image_url'];
			$image_id  = attachment_url_to_postid( $image_url );
			$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$image     = wp_get_attachment_image( $image_id, 'featured-image', false, array( 'alt' => $image_alt ) );

			?>
			<article class="featured-page">
				<header class="entry-header">
					<a href="<?php echo esc_url( $instance['link_url'] ); ?>" class="entry-image">
						<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<?php
					if ( $instance['title'] ) {
						echo '<h3 class="entry-title">';
							echo '<a href="' . esc_url( $instance['link_url'] ) . '">' . esc_html( $instance['title'] ) . '</a>';
						echo '</h3>';
					}
					?>
				</header>
			</article>
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

		$instance              = $old_instance;
		$instance['title']     = wp_strip_all_tags( $new_instance['title'] );
		$instance['image_url'] = esc_url( $new_instance['image_url'] );
		$instance['link_url']  = esc_url( $new_instance['link_url'] );

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
			'title'     => '',
			'image_url' => '',
			'link_url'  => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'vagabond-core' ); ?></label>

			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php echo esc_html__( 'Image:', 'vagabond-core' ); ?></label>

			<input type="text" class="widefat custom-media-url" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>" value="<?php echo esc_url( $instance['image_url'] ); ?>" placeholder="<?php esc_html_e( 'Enter URL or select image', 'vagabond-core' ); ?>" />

			<button type="button" class="button custom-media-button" id="<?php echo esc_attr( $this->get_field_id( 'media_button' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>"><?php esc_html_e( 'Select Image', 'vagabond-core' ); ?></button>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>"><?php echo esc_html__( 'Page URL:', 'vagabond-core' ); ?></label>

			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_url' ) ); ?>" value="<?php echo esc_url( $instance['link_url'] ); ?>" />
		</p>
		<?php

	}
}
