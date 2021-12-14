<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => base_path('public/media/backend/fonts/'),
	'font_data' => [
		'acme' => [
			'R'  => 'Acme-Regular.ttf',    // regular font
		],
		'poppins' => [
			'R'  => 'Poppins-SemiBold.ttf',    // regular font
		]
		// ...add as many as you want.
	]
];
