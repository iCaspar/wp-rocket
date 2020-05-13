<?php

return [
	'vfs_dir'   => 'wp-content/cache/critical-css/',

	'test_data' => [
		'non_multisite' => [
			'testShouldBailoutIfNotCachedBefore'     => [
				'config'   => [
					'item_url'      => 'http://www.example.com/?p=1',
					'job_id' => null
				],
				'expected' => [
					'job_id' => null,
				]
			],
			'testShouldGetCachedJobIdIfCachedBefore'     => [
				'config'   => [
					'item_url'      => 'http://www.example.com/?p=2',
					'job_id' => 5
				],
				'expected' => [
					'job_id' => 5,
				]
			],
		],
		'multisite' => []
	],
];
