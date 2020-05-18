<?php

$cpcss_content = <<<HTML
<p class="cpcss_generate ">
	Generate specific Critical Path CSS for this post.<a href="" target="_blank" rel="noopener noreferrer">
	More info</a>
</p>
<p class="cpcss_regenerate hidden">
	This post uses specific Critical Path CSS.<a href="" target="_blank" rel="noopener noreferrer">
	More info</a>
</p>
<div class="components-panel__row cpcss_generate cpcss_regenerate">
	<button id="rocket-generate-post-cpss" class="button components-button is-secondary"  disabled='disabled'>
		<span style="display: none;" class="spinner">
		</span>
		<span class="rocket-generate-post-cpss-btn-txt">
			Generate Specific CPCSS</span>
	</button>
</div>
<div class="components-panel__row cpcss_regenerate hidden">
	<button id="rocket-delete-post-cpss" class="button components-button is-secondary"  disabled='disabled'>
	<span>
		Revert back to the default CPCSS</span>
	</button>
</div>
HTML;

$cpcss_content_not_disabled = <<<HTML
<p class="cpcss_generate ">
	Generate specific Critical Path CSS for this post.<a href="" target="_blank" rel="noopener noreferrer">
	More info</a>
</p>
<p class="cpcss_regenerate hidden">
	This post uses specific Critical Path CSS.<a href="" target="_blank" rel="noopener noreferrer">
	More info</a>
</p>
<div class="components-panel__row cpcss_generate cpcss_regenerate">
	<button id="rocket-generate-post-cpss" class="button components-button is-secondary" >
		<span style="display: none;" class="spinner">
		</span>
		<span class="rocket-generate-post-cpss-btn-txt">
			Generate Specific CPCSS</span>
	</button>
</div>
<div class="components-panel__row cpcss_regenerate hidden">
	<button id="rocket-delete-post-cpss" class="button components-button is-secondary" >
	<span>
		Revert back to the default CPCSS</span>
	</button>
</div>
HTML;

$script = <<<SCRIPTS
<script>
	var cpcss_rest_url       = 'http://example.org/wp-json/wp-rocket/v1/cpcss/post/1';
	var cpcss_rest_nonce     = 'wp_rest_nonce';
	var cpcss_generate_btn   = 'Generate Specific CPCSS';
	var cpcss_regenerate_btn = 'Regenerate specific CPCSS';
</script>
SCRIPTS;

return [

	'testShouldDisplayAllWarnings' => [
		'config' => [
			'options'            => [
				'async_css' => 0,
			],
			'post'               => (object) [
				'ID'          => 1,
				'post_status' => 'draft',
				'post_type'   => 'post',
			],
			'is_option_excluded' => true,
		],

		'expected' => [
			// For Unit Test: the data the "generate" method should receive.
			'data'               => [
				'disabled_description' => 'Publish the post, Enable Optimize CSS delivery in WP Rocket settings, and Enable Optimize CSS delivery in the options above to use this feature.',
				'cpcss_rest_url'       => 'http://example.org/wp-rocket/v1/cpcss/post/1',
				'cpcss_rest_nonce'     => 'wp_rest_nonce',
			],

			// For the integration test.
			'html' => <<<HTML
 <div class="inside">
	<h3>Critical Path CSS</h3>
	<div id="rocket-metabox-cpcss-content">
		{$cpcss_content}
	</div>
</div>
<div id="cpcss_response_notice" class="components-notice is-notice is-warning">
	<div class="components-notice__content">
		<p>Publish the post, Enable Optimize CSS delivery in WP Rocket settings, and Enable Optimize CSS delivery in the options above to use this feature.</p>
	</div>
</div>
{$script}
HTML
		,
		],
	],

	'testShouldDisplayPostNotPublishedAndOptionExcludedWarning' => [
		'config'   => [
			'options'            => [
				'async_css' => 1,
			],
			'post'               => (object) [
				'ID'          => 1,
				'post_status' => 'draft',
				'post_type'   => 'post',
			],
			'is_option_excluded' => true,
		],
		'expected' => [
			// For Unit Test: the data the "generate" method should receive.
			'data'               => [
				'disabled_description' => 'Publish the post and Enable Optimize CSS delivery in the options above to use this feature.',
				'cpcss_rest_url'       => 'http://example.org/wp-rocket/v1/cpcss/post/1',
				'cpcss_rest_nonce'     => 'wp_rest_nonce',
			],

			// For the integration test.
			'html' => <<<HTML
<div class="inside">
	<h3>Critical Path CSS</h3>
	<div id="rocket-metabox-cpcss-content">
		{$cpcss_content}
	</div>
</div>
<div id="cpcss_response_notice" class="components-notice is-notice is-warning">
	<div class="components-notice__content">
	<p>Publish the post and Enable Optimize CSS delivery in the options above to use this feature.</p>
	</div>
</div>
{$script}
HTML
		,
		],
	],

	'testShouldDisplayPostNotPublishedWarning' => [
		'config'   => [
			'options'            => [
				'async_css' => 1,
			],
			'post'               => (object) [
				'ID'          => 1,
				'post_status' => 'draft',
				'post_type'   => 'post',
			],
			'is_option_excluded' => false,
		],
		'expected' => [
			// For Unit Test: the data the "generate" method should receive.
			'data'               => [
				'disabled_description' => 'Publish the post to use this feature.',
				'cpcss_rest_url'       => 'http://example.org/wp-rocket/v1/cpcss/post/1',
				'cpcss_rest_nonce'     => 'wp_rest_nonce',
			],

			// For the integration test.
			'html' => <<<HTML
<div class="inside">
	<h3>Critical Path CSS</h3>
	<div id="rocket-metabox-cpcss-content">
		{$cpcss_content}
	</div>
</div>
<div id="cpcss_response_notice" class="components-notice is-notice is-warning">
	<div class="components-notice__content">
	<p>Publish the post to use this feature.</p>
	</div>
</div>
{$script}
HTML
		,
		],
	],

	'testShouldDisplayOptionExcludedFromPostWarning' => [
		'config'   => [
			'options'            => [
				'async_css' => 1,
			],
			'post'               => (object) [
				'ID'          => 1,
				'post_status' => 'publish',
				'post_type'   => 'post',
			],
			'is_option_excluded' => true,
		],
		'expected' => [
			// For Unit Test: the data the "generate" method should receive.
			'data'               => [
				'disabled_description' => 'Enable Optimize CSS delivery in the options above to use this feature.',
				'cpcss_rest_url'       => 'http://example.org/wp-rocket/v1/cpcss/post/1',
				'cpcss_rest_nonce'     => 'wp_rest_nonce',
			],

			// For the integration test.
			'html' => <<<HTML
<div class="inside">
	<h3>Critical Path CSS</h3>
	<div id="rocket-metabox-cpcss-content">
		{$cpcss_content}
	</div>
</div>
<div id="cpcss_response_notice" class="components-notice is-notice is-warning">
	<div class="components-notice__content">
	<p>Enable Optimize CSS delivery in the options above to use this feature.</p>
	</div>
</div>
{$script}
HTML
		,
			],
	],

	'testShouldNoWarning' => [
		'config' => [
			'options'            => [
				'async_css' => 1,
			],
			'post'               => (object) [
				'ID'          => 1,
				'post_status' => 'publish',
				'post_type'   => 'post',
			],
			'is_option_excluded' => false,
		],

		'expected' => [
			// For Unit Test: the data the "generate" method should receive.
			'data' => [
				'disabled_description' => '',
				'cpcss_rest_url'       => 'http://example.org/wp-rocket/v1/cpcss/post/1',
				'cpcss_rest_nonce'     => 'wp_rest_nonce',
			],

			// For the integration test.
			'html' => <<<HTML
<div class="inside">
	<h3>Critical Path CSS</h3>
	<div id="rocket-metabox-cpcss-content">
		{$cpcss_content_not_disabled}
	</div>
</div>
<div id="cpcss_response_notice" class="components-notice is-notice is-warning hidden">
	<div class="components-notice__content"></div>
</div>
{$script}
HTML
			,
		],
	],

];
