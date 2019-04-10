<?php
/**
 * Favorite Posts Counter Admin Setting
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Favorite_Posts_Counter_Admin_Setting {

	/**
	 * Variable definition Text Domain.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain;

	/**
	 * Variable definition Key Name.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $key_name = 'favorite_posts_counter_id';

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   String $text_domain
	 */
	public function __construct ( $text_domain ) {
		$this->text_domain = $text_domain;

		/**
		 * Update Status
		 *
		 * "ok" : Successful update
		 */
		$status = "";

		/** Set Default Parameter for Array */
		$options = array(
			"save_term" => 7
		);

		$this->page_render( $options, $status );
	}

	/**
	 * Setting Page of the Admin Screen.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   array  $options
	 * @param   string $status
	 */
	private function page_render ( array $options, $status ) {
		$html  = '';
		$html .= '<div class="wrap">';
		$html .= '<h1>' . esc_html__( 'Favorite Posts Counter Settings', $this->text_domain ) . '</h1>';
		echo $html;

		switch ( $status ) {
			case "ok":
				$this->information_render();
				break;
			default:
				break;
		}

		$html  = '<hr>';
		$html .= '<form method="post" action="">';
		$html .= '<table class="wp-favorite-posts-counter-admin-table" id="wp-favorite-posts-counter-type-cookie">';
		$html .= '<caption>' . esc_html__( 'Type: Cookie settings', $this->text_domain ) . '</caption>';
		$html .= '<tr><th><label for="save_term">' . esc_html__( 'Save Term', $this->text_domain ) . ':</label></th><td>';
		$html .= '<input type="number" name="save_term" id="save_term" required class="small-text" min="1" max="30" value="';
		$html .= esc_attr( $options['save_term'] ) . '">' . esc_html__( 'day', $this->text_domain );
		$html .= '</td></tr>';
		$html .= '</table>';
		echo $html;

		submit_button();

		$html  = '</form></div>';
		echo $html;
	}

	/**
	 * Information Message Render
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private function information_render () {
		$html  = '<div id="message" class="updated notice notice-success is-dismissible below-h2">';
		$html .= '<p>Favorite Posts Counter Information Update.</p>';
		$html .= '<button type="button" class="notice-dismiss">';
		$html .= '<span class="screen-reader-text">Favorite Posts Counter Information Update.</span>';
		$html .= '</button>';
		$html .= '</div>';

		echo $html;
	}
}