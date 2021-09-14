<?php

return [
    'jqadm' => [
        'navbar' => [
            '90'=>'popup'
        ],
        'resource' =>[
            'popup' => [
                'groups' => ['admin', 'editor', 'super'],
               
            ],
            'type' => [
                'popup' =>[
                    'groups' => ['admin', 'editor', 'super'],
                    'key' => 'SF',
                ]
            ],
        ],
        'popup' => [
            'domains' => [
                'text' => 'text',
                'media' => 'media',
            ],
            'subparts' => [
                'media' => 'media',
                'text' => 'text',
            ],
		],
    ],

   
   
    'jsonadm' => [
    ],
];