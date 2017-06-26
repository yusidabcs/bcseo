<?php

function bcs_seo()
{

	$html = SEO::generate(true);
    
    if(Route::currentRouteName() == 'homepage')
    {
    	$html = $html.'<script type="application/ld+json">
    {
      "@context": "http:\/\/schema.org",
      "@type": "WebSite",
      "@id": "#website",
      "url": "'.str_replace('/','\/',url('')).'",
      "name": "'.setting('core::site-name').'",
    }
    </script>

    <script type="application/ld+json">
    {
        "@context":"http:\/\/schema.org",
        "@type":"'.setting('bcseo::company_or_person').'",
        "url": "'.str_replace('/','\/',url('')).'",
        "sameAs":[],
        "@id":"#'.setting('bcseo::company_or_person').'",
        "name":"'. setting('core::site-name') .'",
        "logo":"'. str_replace('/','\/',setting('core::logo')) .'"
    }
    </script>';	
    }
    

    return preg_replace( "/\r|\n/", "", $html );
}

