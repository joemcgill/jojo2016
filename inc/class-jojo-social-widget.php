<?php

class Jojo_Social_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$args = array(
			'classname' => 'jojo_social_widget',
			'description' => 'Social Widget',
		);
		parent::__construct( 'jojo_social_widget', 'Social Widget', $args );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
		}

		echo '<div class="social-icons">
			<ul class="icon-list list-inline">
				<li class="list-item"><a href="https://twitter.com/jojotastic/" target="_blank"><div class="icon icon-twitter"><span class="icon-text">twitter</span></div></a></li>
				<li class="list-item"><a href="https://www.facebook.com/jojotastic.blog" target="_blank"><div class="icon icon-facebook"><span class="icon-text">facebook</span></div></a></li>
				<li class="list-item"><a href="https://www.instagram.com/jojotastic/" target="_blank"><div class="icon icon-instagram"><span class="icon-text">instagram</span></div></a></li>
				<li class="list-item"><a href="https://www.youtube.com/channel/UCbnOYblAmcnPdBNMo2c_T3g" target="_blank"><div class="icon icon-youtube"><span class="icon-text">youtube</span></div></a></li>
				<li class="list-item"><a href="https://pinterest.com/jojotastic/" target="_blank"><div class="icon icon-pinterest"><span class="icon-text">Pinterest</span></div></a></li>
				<li class="list-item"><a href="https://www.snapchat.com/add/jojotastic/" target="_blank"><div class="icon icon-snapchat"><span class="icon-text">snapchat</span></div></a></li>
			</ul>
		</div>';

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
