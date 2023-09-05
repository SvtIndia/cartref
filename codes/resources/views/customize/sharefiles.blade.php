@extends('layouts.website')

@section('meta-seo')
    <title>Customizing {{ $product->name }}</title>
    <meta name="keywords" content="{{ Config::get('seo.sharefiles.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.sharefiles.description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('headerlinks')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>

    <link href="{{ url('https://www.jqueryscript.net/css/jquerysctipttop.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/imageMaker.css') }}">
@endsection

@section('content')
<nav class="breadcrumb-nav">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
            <li>Customize</li>
            <li><a href="{{ route('product.slug', ['slug' => $product->slug, 'color' => $customizecart->attributes->color]) }}">{{ $product->name.' - Color: '.$customizecart->attributes->color.' - Size: '.$customizecart->attributes->size.' - G+: '.$customizecart->attributes->g_plus.' - Qty: '.$customizecart->quantity }}</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <br>
    @include('customize.header')
    <br>
    <div class="wrapper-memes-main">
      
        <div class="wrapper-memes-preview">
        <div class="wrapper-memes-preview-operations" style="background: green;">
        
              
              <h3 style="color: white;">Preview</h3>

              <div class="clear_both"></div>
           </div>
        
        <div id="wrapper_canvas_background">
            <img src="{{ $customizableimage }}" alt="">
        
        </div> 
         
   
        
        </div>
       
    
        <div class="wrapper-memes-operations">
        
        <form method="post" action="{{ route('customize.movetobag') }}" enctype="multipart/form-data" style="background: whitesmoke; border: 1px solid rgba(0, 0, 0, 0.474); padding: 1em 2em;">
            @csrf
            <input type="hidden" name="customizeid" value="{{ request('customizeid') }}">
            <input type="hidden" name="requireddocument" value="{{ $customizecart->attributes->requireddocument }}">
            <input type="hidden" name="customizedimage" value="{{ $customizableimage }}">
            
            {{-- originalimage --}}
            <label for="" style="color: black; font-weight: 600; margin-bottom: 10px; font-size: 2em;">Upload Original Image</label>
            <br><br>
            <input type="file" name="originalimage[]" multiple class="form-control" style="padding: 2em 5em;" required>
            
            
            <br>
            <small>* upload image which you used on the customized image</small><br>
            <small>* only cdr file format is allowed</small>
            <br><br>
            <input type="checkbox" required> I'm done with the customization and agree with all the <a href="/page/terms-and-conditions" target="_blank" style="color: blue;">Terms & Conditions</a> <span style="color: red;">*</span>
            <br><br>
            <a href="{{ route('customize', ['customizeid' => request('customizeid')]) }}" class="mr-5 btn btn-default btn-danger form-submit reset_meme"><i class="d-icon-arrow-left"></i> Edit</a>
            <button type="submit" class="generate_meme btn btn-default btn-primary form-submit">Move to Bag</buton>
        </form>
            
        <br>
        {{-- <form class="form-generat-meme" action="meme-generator-callback" method="post" enctype="multipart/form-data">
          
        </form>  --}}
  
        </div>
  
           
    
        <div class="clear_both"> </div>
    
        </div>
</div>
<br><br>
@endsection


<style>
    .view-images-memes-ar-amm{
        display: none;
    }
</style>

