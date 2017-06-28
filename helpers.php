<?php

function bcs_seo()
{

	$html = SEO::generate();
    
    if(Route::currentRouteName() == 'homepage')
    {

    $html = $html.'<script type=\'application/ld+json\'>
    {
      "@context": "http:\/\/schema.org",
      "@type": "WebSite",
      "@id": "#website",
      "url": "'.str_replace('/','\/',url('')).'",
      "name": "'.setting('bcseo::name').'",
      "potentialAction":{
            "@type":"SearchAction",
            "target":"'.str_replace('/','\/',url('/')).'?s={search_term_string}",
            "query-input":"required name=search_term_string"
        }
      
    }
    </script>

    <script type=\'application/ld+json\'>
    {
        "@context":"http:\/\/schema.org",
        "@type":"'.ucfirst(setting('bcseo::company_or_person')).'",
        "url": "'.str_replace('/','\/',url('')).'",
        "sameAs":["'.str_replace('/','\/',setting('core::facebook')).'"],
        "@id":"#'.setting('bcseo::company_or_person').'",
        "name":"'. setting('bcseo::name') .'",
        "logo":"'. str_replace('/','\/',setting('core::logo')) .'"
    }
    </script>';	
    }
    

    return preg_replace( "/\r|\n/", "", $html );
}

