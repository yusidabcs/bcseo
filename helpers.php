<?php

function bcs_seo()
{

	$html = SEO::generate(true);
    
    if(Route::currentRouteName() == 'homepage')
    {
    	$html = $html.'<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "WebSite",
      "@id": "#website",
      "url": "'.url('').'",
      "name": "'.setting('core::site-name').'",
    }
    </script>

    <script type="application/ld+json">
    {
        "@context":"http:\/\/schema.org",
        "@type":"'.setting('bcseo::company_or_person').'",
        "url":"'.url('').'",
        "sameAs":[],
        "@id":"#'.setting('bcseo::company_or_person').'",
        "name":"'. setting('core::site-name') .'",
        "logo":"'. setting('core::logo') .'"
    }
    </script>';	
    }
    

    return preg_replace( "/\r|\n/", "", $html );
}