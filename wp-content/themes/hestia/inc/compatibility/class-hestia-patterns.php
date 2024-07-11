<?php
/**
 * Patterns Compatibility.
 *
 * @package hestia
 */

/**
 * Class Patterns
 *
 * @package hestia
 */
class Hestia_Patterns {
	/**
	 * Define list of the patterns to load.
	 *
	 * @var string[] Patterns list.
	 */
	private $patterns = array(
		'team-cards',
		'team-columns',
		'team-card-columns',
		'pricing-plan-columns',
		'call-to-action',
		'testimonial-columns',
		'content-with-alternating-image-and-text',
		'image-and-text-columns',
		'latest-posts-row',
		'latest-posts-wide',
	);

	/**
	 * Load patterns.
	 */
	public function define_patterns() {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}
		foreach ( $this->patterns as $pattern ) {
			register_block_pattern(
				'hestia/' . $pattern,
				require __DIR__ . '/block-patterns/' . $pattern . '.php'
			);
		}
	}

}
