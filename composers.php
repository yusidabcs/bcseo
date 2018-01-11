<?php

View::composer('*', function ($view) {
    $obj = null;
    $data = $view->getData();

    if (isset($data['page'])) {
        $obj = $data['page'];
    }  else if (isset($data['villa'])) {
        $obj = $data['villa'];
    } else if (isset($data['post'])) {
        $obj = $data['post'];
    }


    if ($obj != null) {

        $title = $obj->meta_title == '' ? Setting::get('core::site-name') : $obj->meta_title;
        $description = $obj->meta_description == '' ? Setting::get('core::site-description') : $obj->meta_description;
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('google-site-verification', setting('bcseo::google-site-verification'));
        SEOMeta::addMeta('robots', Setting::get('bcseo::robots'));

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        if (Route::currentRouteName() == 'homepage')
            OpenGraph::setType('website');
        else
            OpenGraph::setType('article');

        OpenGraph::addProperty('locale', setting('bcseo::locale'));
        OpenGraph::addProperty('site_name', setting('bcseo::name'));
        OpenGraph::addProperty('image', setting('core::logo'));

        if (setting('core::twitter') != '') {
            Twitter::setTitle($title);
            Twitter::setDescription($description);
            Twitter::setType('summary');
            Twitter::setSite(setting('core::twitter'));
        }

    } else {
        $title = Setting::get('core::site-name');
        $description = Setting::get('core::site-description');
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('google-site-verification', setting('bcseo::google-site-verification'));
        SEOMeta::addMeta('robots', Setting::get('bcseo::robots'));

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        if (Route::currentRouteName() == 'homepage')
            OpenGraph::setType('website');
        else
            OpenGraph::setType('article');

        OpenGraph::addProperty('locale', setting('bcseo::locale'));
        OpenGraph::addProperty('site_name', setting('bcseo::name'));
        OpenGraph::addProperty('image', setting('core::logo'));

        if (setting('core::twitter') != '') {
            Twitter::setTitle($title);
            Twitter::setDescription($description);
            Twitter::setType('summary');
            Twitter::setSite(setting('core::twitter'));
        }
    }

});
