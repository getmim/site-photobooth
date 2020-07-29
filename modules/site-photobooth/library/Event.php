<?php
/**
 * Event
 * @package site-photobooth
 * @version 0.0.1
 */

namespace SitePhotobooth\Library;


class Event
{
    static function clear(array $data): void{
        $page = $data['page'] ?? $data['old'] ?? null;

        // clear output cache
        if($page && module_exists('lib-cache-output'))
            Cleaner::router('sitePhotoboothSingle', (array)$page);

        // Clear static page RSS Feed output cache
        // Clear global RSS Feed output cache
        // Clear global Sitemap output cache
    }
}