<?php
/**
 * Admin ShortCode Settings
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Favorite_Posts_Counter_ShortCode {

	/**
	 * ShortCode Display(Button).
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array  $args
	 * @return  string $html
	 */
	public function short_code_display_button ( $args ) {
		extract( shortcode_atts( array (
			'post_id' => ""
		), $args ) );

		$instance = array(
			'post_id' => $post_id
		);
		$html = '';
		return (string) $html;
	}

	/**
	 * ShortCode Display(Counter).
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array  $args
	 * @return  string $html
	 */
	public function short_code_display_counter ( $args ) {
		extract( shortcode_atts( array (
				'post_id' => ""
		), $args ) );

		$instance = array(
				'post_id' => $post_id
		);
		$html = '';
		return (string) $html;
	}
}