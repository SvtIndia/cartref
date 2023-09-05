@php
    

    
    // get domain name 
    $domain = request()->getSchemeAndHttpHost();


    // url without page parameter
    $withoutpage = str_replace($domain, '', request()->fullUrlWithoutQuery('page'));
    $withoutpage = str_replace('%5B', '[', $withoutpage);
    $withoutpage = str_replace('%5D', ']', $withoutpage);
    

    if(empty($seo))
    {
        // find with url and parameters
            // \Request::getRequestUri()
        $seo = App\Seo::where('url', $withoutpage)->where('status', 1)->first();
    }



    if(empty($seo))
    {
        // find with url's first parameters
        if(isset(explode('&', $withoutpage)[0]))
        {
            $seo = App\Seo::where('url', 'LIKE', '%'.explode('&', $withoutpage)[0].'%')->where('status', 1)->first();
        }
        
    }


    
    if(empty($seo))
    {
        // find with url first prefix
        
        if(explode('/', \Request::route()->uri)[0] == 'products')
        {
            $seo = App\Seo::where('url', '/products')->where('status', 1)->first();
        }

    }


    $prefix = explode('/', \Request::route()->uri)[0];

@endphp



@isset($seo)
    <title>{!! $seo->meta_title !!}</title>
    <meta name="description" content="{{ $seo->meta_description }}">
    <meta name="keywords" content="{{ $seo->meta_keywords }}">
    <link rel="canonical" href="{{ env('APP_URL').\Request::getRequestUri() }}">
@else
    @yield('meta-seo')
    <link rel="canonical" href="{{ env('APP_URL').\Request::getRequestUri() }}">
@endisset


