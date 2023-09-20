<?php
return [
	'services' => [
		'value' => [
                    'searchService' => [
                        'className' => \Silab\SiteCore\Services\BitrixSearchService::class,
                    ],    
		],
		'readonly' => true,
	],
];