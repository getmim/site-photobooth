<?php
/**
 * PhotoController
 * @package site-photobooth
 * @version 0.0.1
 */

namespace SitePhotobooth\Controller;

use SitePhotobooth\Library\Meta;
use Photobooth\Model\Photobooth;
use LibFormatter\Library\Formatter;
use LibPagination\Library\Paginator;

class PhotoController extends \Site\Controller
{
    public function indexAction(){
        list($page, $rpp) = $this->req->getPager();

        $photos = Photobooth::get([], $rpp, $page, ['id'=>false]);
        if($photos)
            $photos = Formatter::formatMany('photobooth', $photos, ['user']);

        $params = [
            'pagination' => null,
            'photos'     => $photos,
            'meta'       => Meta::index($photos, $page)
        ];

        $total = Photobooth::count([]);
        if($total > $rpp){
            $params['pagination'] = new Paginator(
                $this->router->to('sitePhotoboothIndex'),
                $total,
                $page,
                $rpp,
                10
            );
        }

        $this->res->render('photobooth/index', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }

    public function singleAction(){
        $id = $this->req->param->id;

        $photo = Photobooth::getOne(['id'=>$id]);
        if(!$photo)
            return $this->show404();

        $photo = Formatter::format('photobooth', $photo);

        $params = [
            'photo' => $photo,
            'meta'  => Meta::single($photo)
        ];
        
        $this->res->render('photobooth/single', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }
}
