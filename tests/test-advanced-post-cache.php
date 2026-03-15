<?php
/**
 * Class SampleTest
 *
 * @package Advanced_Post_Cache
 */

/**
 * Sample test case.
 */
class Advanced_Post_Cache_Test extends WP_UnitTestCase {
	public $post_ids;

	public function setUp( ) {
		$this->post_ids = $this->factory->post->create_many( 5 );
	}

	public function test_cache() {
		// Initial query should hit an empty cache
		$query = new WP_Query( array(
			'status' => 'publish',
			'posts_per_page' => 5,
			'orderby' => 'ID',
			'order' => 'ASC',
		) );
		$this->assertFalse( $GLOBALS['advanced_post_cache_object']->all_post_ids );
		$this->assertFalse( $GLOBALS['advanced_post_cache_object']->found_posts );

		// Next query should have APC primed
		$query = new WP_Query( array(
			'status' => 'publish',
			'posts_per_page' => 5,
			'orderby' => 'ID',
			'order' => 'ASC',
		) );
		$this->assertEquals( $this->post_ids, $GLOBALS['advanced_post_cache_object']->all_post_ids );
		$this->assertEquals( 5, $GLOBALS['advanced_post_cache_object']->found_posts );

	}
}
