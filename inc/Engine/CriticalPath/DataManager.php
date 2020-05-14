<?php
namespace WP_Rocket\Engine\CriticalPath;

use WP_Error;

/**
 * Class DataManager
 *
 * @package WP_Rocket\Engine\CriticalPath
 */
class DataManager {

	/**
	 * Base critical CSS path for posts.
	 *
	 * @var string
	 */
	private $critical_css_path;

	/**
	 * DataManager constructor, adjust the critical css path for posts.
	 *
	 * @param string $critical_css_path path for main critical css folder.
	 */
	public function __construct( $critical_css_path ) {
		$this->critical_css_path = $critical_css_path . get_current_blog_id() . DIRECTORY_SEPARATOR;
	}

	/**
	 * Save CPCSS into file.
	 *
	 * @since 3.6
	 *
	 * @param string $path Path for cpcss file related to this web page.
	 * @param string $cpcss CPCSS code to be saved.
	 * @return bool
	 */
	public function save_cpcss( $path, $cpcss ) {
		if ( ! rocket_direct_filesystem()->is_dir( $this->critical_css_path ) ) {
			rocket_mkdir_p( $this->critical_css_path );
		}

		$full_path = $this->critical_css_path . $path;

		return rocket_put_content( $full_path, wp_strip_all_tags( $cpcss, true ) );
	}

	/**
	 * Delete critical css file by path.
	 *
	 * @param string $path critical css file path to be deleted.
	 * @return bool|WP_Error
	 */
	public function delete_cpcss( $path ) {
		$filesystem = rocket_direct_filesystem();

		$full_path = $this->critical_css_path . $path;

		if ( ! $filesystem->exists( $full_path ) ) {
			return new WP_Error(
				'cpcss_not_exists',
				__( 'Critical CSS file does not exist', 'rocket' ),
				[
					'status' => 400,
				]
			);
		}

		if ( ! $filesystem->delete( $full_path ) ) {
			return new WP_Error(
				'cpcss_deleted_failed',
				__( 'Critical CSS file cannot be deleted', 'rocket' ),
				[
					'status' => 400,
				]
			);
		}

		return true;
	}

	/**
	 * Get job_id from cache based on item_url.
	 *
	 * @since 3.6
	 *
	 * @param string $item_url URL for item to be used in error messages.
	 * @return mixed
	 */
	public function get_cache_job_id( $item_url ) {
		$cache_key = $this->get_cache_key_from_url( $item_url );
		return get_transient( $cache_key );
	}

	/**
	 * Set Job_id for Item_url into cache.
	 *
	 * @since 3.6
	 *
	 * @param string $item_url URL for item to be used in error messages.
	 * @param string $job_id ID for the job to get details.
	 * @return bool
	 */
	public function set_cache_job_id( $item_url, $job_id ) {
		$cache_key = $this->get_cache_key_from_url( $item_url );
		return set_transient( $cache_key, $job_id, HOUR_IN_SECONDS );
	}

	/**
	 * Delete job_id from cache based on item_url.
	 *
	 * @since 3.6
	 *
	 * @param string $item_url URL for item to be used in error messages.
	 * @return bool
	 */
	public function delete_cache_job_id( $item_url ) {
		$cache_key = $this->get_cache_key_from_url( $item_url );
		return delete_transient( $cache_key );
	}

	/**
	 * Get cache key from url to be used in caching job_id.
	 *
	 * @since 3.6
	 *
	 * @param string $item_url URL for item to be used in error messages.
	 * @return string
	 */
	private function get_cache_key_from_url( $item_url ) {
		$encoded_url = md5( $item_url );
		return 'rocket_specific_cpcss_job_' . $encoded_url;
	}

}
