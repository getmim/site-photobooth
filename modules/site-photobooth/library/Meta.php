<?php
/**
 * Meta
 * @package site-photobooth
 * @version 0.0.1
 */

namespace SitePhotobooth\Library;


class Meta
{
    static function index(array $photos, int $page){
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');
        $curr_url = \Mim::$app->router->to('sitePhotoboothIndex');

        $meta = (object)[
            'title'         => 'Photobooth',
            'description'   => 'Collection of photobooth collected by month',
            'schema'        => 'WebPage',
            'keyword'       => ''
        ];

        $result['head'] = [
            'description'       => $meta->description,
            'schema.org'        => [],
            'type'              => 'website',
            'title'             => $meta->title,
            'url'               => $curr_url,
            'metas'             => []
        ];

        // schema breadcrumbList
        $result['head']['schema.org'][] = [
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@id' => $home_url,
                        'name' => \Mim::$app->config->name
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => [
                        '@id' => $home_url . '#photobooth',
                        'name' => $meta->title
                    ]
                ]
            ]
        ];

        return $result;
    }

    static function single(object $page): array{
        $result = [
            'head' => [],
            'foot' => []
        ];

        $home_url = \Mim::$app->router->to('siteHome');

        $page->meta = (object)[];

        $def_meta = [
            'title'         => $page->fullname,
            'description'   => $page->fullname->chars(160),
            'schema'        => 'MediaGallery',
            'keyword'       => ''
        ];

        foreach($def_meta as $key => $value){
            if(!isset($page->meta->$key) || !$page->meta->$key)
                $page->meta->$key = $value;
        }

        $result['head'] = [
            'description'       => $page->meta->description,
            'published_time'    => $page->created,
            'schema.org'        => [],
            'type'              => 'article',
            'title'             => $page->meta->title,
            'updated_time'      => $page->updated,
            'url'               => $page->page,
            'metas'             => []
        ];

        // schema breadcrumbList
        $result['head']['schema.org'][] = [
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@id' => $home_url,
                        'name' => \Mim::$app->config->name
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => [
                        '@id' => $home_url . '#photobooth',
                        'name' => 'Photobooth'
                    ]
                ]
            ]
        ];

        // schema logo
        $meta_image = null;
        if($page->images){
            $meta_image = [
                '@context'   => 'http://schema.org',
                '@type'      => 'ImageObject',
                'contentUrl' => $page->images[0],
                'url'        => $page->images[0]
            ];
        }

        // schema page
        $schema = [
            '@context'      => 'http://schema.org',
            '@type'         => $page->meta->schema,
            'name'          => $page->meta->title,
            'description'   => $page->meta->description,
            'url'           => $page->page
        ];

        if($meta_image)
            $schema['image'] = $meta_image;

        $result['head']['schema.org'][] = $schema;

        return $result;
    }
}
