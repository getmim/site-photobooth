<?php

return [
    '__name' => 'site-photobooth',
    '__version' => '0.1.0',
    '__git' => 'git@github.com:getmim/site-photobooth.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'app/site-photobooth' => ['install','remove'],
        'modules/site-photobooth' => ['install','update','remove'],
        'theme/site/photobooth' => ['install','updated']
    ],
    '__dependencies' => [
        'required' => [
            [
                'photobooth' => NULL
            ],
            [
                'site' => NULL
            ],
            [
                'site-meta' => NULL
            ],
            [
                'lib-formatter' => NULL
            ],
            [
                'lib-pagination' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-event' => NULL
            ],
            [
                'lib-cache-output' => NULL
            ],
            [
                'site-setting' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'SitePhotobooth\\Controller' => [
                'type' => 'file',
                'base' => ['app/site-photobooth/controller','modules/site-photobooth/controller']
            ],
            'SitePhotobooth\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-photobooth/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'sitePhotoboothIndex' => [
                'path' => [
                    'value' => '/photobooth'
                ],
                'handler' => 'SitePhotobooth\\Controller\\Photo::index'
            ],
            'sitePhotoboothSingle' => [
                'path' => [
                    'value' => '/photobooth/(:id)',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'handler' => 'SitePhotobooth\\Controller\\Photo::single'
            ],
            'sitePhotoboothFeed' => [
                'path' => [
                    'value' => '/photobooth/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SitePhotobooth\\Controller\\Robot::feed'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'photobooth' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'sitePhotoboothSingle',
                        'params' => [
                            'id' => '$id'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libEvent' => [
        'events' => [
            'photobooth:created' => [
                'SitePhotobooth\\Library\\Event::clear' => TRUE
            ],
            'photobooth:deleted' => [
                'SitePhotobooth\\Library\\Event::clear' => TRUE
            ],
            'photobooth:updated' => [
                'SitePhotobooth\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SitePhotobooth\\Library\\Robot::feed' => TRUE
            ],
            'sitemap' => [
                'SitePhotobooth\\Library\\Robot::sitemap' => TRUE
            ]
        ]
    ]
];
