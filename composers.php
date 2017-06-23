<?php

View::composer('*', function($view)
{
    $obj = null;
    $data = $view->getData();
    if(isset($data['page'])){
        $obj = $data['page'];
    }
    else if(isset($data['villa'])){
        $obj = $data['villa'];
    }

    if($obj != null){

        $title = $obj->meta_title == '' ? Setting::get('core::site-name') : $obj->meta_title;
        $description = $obj->meta_description == '' ? Setting::get('core::site-description') : $obj->meta_description;
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addKeyword($obj->meta_keyword);
        SEOMeta::addMeta('google-site-verification',Setting::get('bcseo::google-site-verification'));
        SEOMeta::addMeta('robots',Setting::get('bcseo::robots'));

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setType('website');
        OpenGraph::addProperty('locale','en_US');
        OpenGraph::addProperty('site_name',setting('core::site-name'));

        Twitter::setTitle($title);
        Twitter::setDescription($description);
        Twitter::setType('summary');
        Twitter::setSite(setting('core::site-name'));
    }

});
