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

class PhotoController extends \Site\Controller
{
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