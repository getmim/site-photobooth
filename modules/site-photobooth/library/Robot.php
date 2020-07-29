<?php
/**
 * Robot
 * @package site-photobooth
 * @version 0.0.1
 */

namespace SitePhotobooth\Library;

use Photobooth\Model\Photobooth;

class Robot
{
    static private function getPages(): ?array{
        $cond = [
            'updated' => ['__op', '>', date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];
        $pages = Photobooth::get($cond);
        if(!$pages)
            return null;

        return $pages;
    }

    static function feed(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route = $mim->router->to('sitePhotoboothSingle', (array)$page);
            $title = $page->fullname;
            $desc  = $page->fullname;

            $result[] = (object)[
                'description'   => $desc,
                'page'          => $route,
                'published'     => $page->created,
                'updated'       => $page->updated,
                'title'         => $title,
                'guid'          => $route
            ];
        }

        return $result;
    }

    static function sitemap(): array {
        $mim = &\Mim::$app;

        $pages = self::getPages();
        if(!$pages)
            return [];

        $result = [];
        foreach($pages as $page){
            $route  = $mim->router->to('sitePhotoboothSingle', (array)$page);
            $result[] = (object)[
                'page'          => $route,
                'updated'       => $page->updated,
                'priority'      => '0.2',
                'changefreq'    => 'monthly'
            ];
        }

        return $result;
    }
}