<?php

return [
	'vfs_dir'   => 'wp-content/cache/critical-css/',

	'test_data' => [
		'non_multisite' => [
			'testShouldBailoutIfResponse400'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=1',
					'response_data' => [
						'code' => 400,
						'body' => '{}',
					]
				],
				'expected' => [
					'code'    => 'cpcss_generation_failed',
					'message' => 'Critical CSS for http://www.example.com/?p=1 not generated.',
					'data'    => [ 'status' => 400 ],
				],
			],
			'testShouldBailoutIfResponseCodeNotExpected'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=2',
					'response_data' => [
						'code' => 403,
						'body' => '{}',
					]
				],
				'expected' => [
					'code'    => 'cpcss_generation_failed',
					'message' => 'Critical CSS for http://www.example.com/?p=2 not generated. Error: The API returned an invalid response code.',
					'data'    => [ 'status' => 403 ],
				],
			],
			'testShouldBailoutIfResponseBodyEmpty'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=3',
					'response_data' => [
						'code' => 200,
						'body' => '{}',
					]
				],
				'expected' => [
					'code'    => 'cpcss_generation_failed',
					'message' => 'Critical CSS for http://www.example.com/?p=3 not generated. Error: The API returned an empty response.',
					'data'    => [ 'status' => 400 ],
				],
			],
			'testShouldSucceed'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=4',
					'response_data' => [
						'code' => 200,
						'body' => '{"success":true,"data":{"id":1}}',
					]
				],
				'expected' => [
					'success'    => true,
					'data'    => [ 'id' => 1 ],
				],
			],
		],
		'multisite'     => [
			'testShouldBailoutIfResponse400'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=1',
					'response_data' => [
						'code' => 400,
						'body' => '{}',
					],
					'site_id'      => 2
				],
				'expected' => [
					'code'    => 'cpcss_generation_failed',
					'message' => 'Critical CSS for http://www.example.com/?p=1 not generated.',
					'data'    => [ 'status' => 400 ],
				],
			],
			'testShouldBailoutIfResponseCodeNotExpected'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=2',
					'response_data' => [
						'code' => 403,
						'body' => '{}',
					],
					'site_id'      => 2
				],
				'expected' => [
					'code'    => 'cpcss_generation_failed',
					'message' => 'Critical CSS for http://www.example.com/?p=2 not generated. Error: The API returned an invalid response code.',
					'data'    => [ 'status' => 403 ],
				],
			],
			'testShouldBailoutIfResponseBodyEmpty'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=3',
					'response_data' => [
						'code' => 200,
						'body' => '{}',
					],
					'site_id'      => 2
				],
				'expected' => [
					'code'    => 'cpcss_generation_failed',
					'message' => 'Critical CSS for http://www.example.com/?p=3 not generated. Error: The API returned an empty response.',
					'data'    => [ 'status' => 400 ],
				],
			],
			'testShouldSucceed'     => [
				'config'   => [
					'item_url'     => 'http://www.example.com/?p=4',
					'response_data' => [
						'code' => 200,
						'body' => '{"success":true,"data":{"id":1}}',
					],
					'site_id'      => 2
				],
				'expected' => [
					'success'    => true,
					'data'    => [ 'id' => 1 ],
				],
			],
		],
	],
];
