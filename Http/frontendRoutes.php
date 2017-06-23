<?php

Route::get('sitemap-generator', function()
{
    $sitemap_page = App::make("sitemap");
    $pages = \Modules\Page\Entities\Page::all();

    foreach ($pages as $page)
    {
        $main_url = LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), url($page->slug));
        $translations = [];
        foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)
        {
            $translations[] = ['language' => $key, 'url' => LaravelLocalization::getLocalizedURL($key, url($page->slug))];
        }
        $sitemap_page->add($main_url, $page->updated_at, 1, 'daily', [], null, $translations);

    }

    // create file sitemap-posts.xml in your public folder (format, filename)
    $sitemap_page->store('xml','sitemap-pages');

    // create sitemap
    $sitemap_posts = App::make("sitemap");

    // add items
    $villas = DB::table('villamanager__villas')->orderBy('created_at', 'desc')->get();
    foreach ($villas as $villa)
    {
        $main_url = LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), villa_url($villa));
        $translations = [];
        foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)
        {
            $translations[] = ['language' => $key, 'url' => LaravelLocalization::getLocalizedURL($key, villa_url($villa))];
        }
        $sitemap_posts->add($main_url, $villa->updated_at, 1, 'daily', [], null, $translations);

    }

    // create file sitemap-posts.xml in your public folder (format, filename)
    $sitemap_posts->store('xml','sitemap-villas');

    // create sitemap
    $sitemap_tags = App::make("sitemap");

    // add items
    $tags = DB::table('villamanager__villa_categories')->get();

    foreach ($tags as $tag)
    {
        $sitemap_tags->add(url('our-villas?category='.$tag->id), null, '0.5', 'monthly');
    }

    // create file sitemap-tags.xml in your public folder (format, filename)
    $sitemap_tags->store('xml','sitemap-villa-categories');


    // create sitemap
    $sitemap_blog = App::make("sitemap");

    // add items
    $blogs = Modules\Blog\Entities\Post::get();

    foreach ($blogs as $item)
    {
        $main_url = LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), url('blog/posts/'.$item->slug));
        $translations = [];
        foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)
        {
            $translations[] = ['language' => $key, 'url' => LaravelLocalization::getLocalizedURL($key, url('blog/posts/'.$item->slug))];
        }
        $sitemap_blog->add($main_url, $item->updated_at, 1, 'daily', [], null, $translations);
    }

    // create file sitemap-tags.xml in your public folder (format, filename)
    $sitemap_blog->store('xml','sitemap-blogs');

    // create sitemap index
    $sitemap = App::make ("sitemap");

    // add sitemaps (loc, lastmod (optional))
    $sitemap->addSitemap(URL::to('sitemap-pages.xml'),\Carbon\Carbon::now());
    $sitemap->addSitemap(URL::to('sitemap-villas.xml'),\Carbon\Carbon::now());
    $sitemap->addSitemap(URL::to('sitemap-villa-categories.xml'),\Carbon\Carbon::now());
    $sitemap->addSitemap(URL::to('sitemap-blogs.xml'),\Carbon\Carbon::now());

    // create file sitemap.xml in your public folder (format, filename)
    $sitemap->store('sitemapindex','sitemap');
});