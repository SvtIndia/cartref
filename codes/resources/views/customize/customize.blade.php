@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.customize.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.customize.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.customize.description') }}">
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

    {{-- @foreach(File::glob(public_path('storage/images/customized_media').'/*') as $path)
        <img src="{{ str_replace(public_path(), '', $path) }}">
    @endforeach --}}

    <div id="example">
        {{-- here we can add our own content/code --}}
    </div>

</div>
<br><br>
@endsection


<style>
    .view-images-memes-ar-amm{
        display: none;
    }
</style>

@section('bottomscripts')
{{-- <script src="{{ asset('js/imageMaker.min.js') }}"></script> --}}

    @if (Config::get('icrm.customize.your_media') == 1)
    @php
        if(auth()->user())
        {
            // $folderimages = File::glob(public_path('storage/images/customized_media/'.auth()->user()->id).'/*');
            $folderimages = File::glob('storage/images/customized_media/'.auth()->user()->id.'/*');
            $folderimages = str_replace(['C:\ICRM Software\riode.ecommerce\public\storage'], '', $folderimages);
            $folderimages = str_replace('/', '\\', $folderimages);
        }


        $mergeimages;
        
        if(isset($folderimages))
        {
            if(count($folderimages) > 0)
            {
                foreach ($folderimages as $key => $image) {
                    // $image = Voyager::image($image);
                    $image = asset($image);
                    $image = "{url: '$image', title: 'Image $key'}";
                    $mergeimages[] = $image;
                }

                $mergeimages = json_encode($mergeimages);
                $mergeimages = str_replace('"', '', $mergeimages);
                $mergeimages = str_replace('&#039', '', $mergeimages);
                $mergeimages = str_replace(';', '', $mergeimages);
                $mergeimages = str_replace('&', '', $mergeimages);
                $mergeimages = str_replace('\/', '/', $mergeimages);
            }
        }
        
        


        if(!empty($mergeimages))
        {
            $mergeimages = "$mergeimages";
        }else{
            // $mergeimages = "[{url: '{{ Voyager::image($customizableimage) }}', title:'Image 1'}]";
            $mergeimages = "[]";
        }
        
        // dd($mergeimages);
    @endphp
    @endif

    <script>
    $(document).ready(function(){

        // merge_images:[
        //     {url: '{{ Voyager::image($customizableimage) }}', title:'Image 1'},
        // ],

        var mergeimages = <?php echo  $mergeimages; ?>;

        // composer.log(mergeimages);

        $('#example').imageMaker({                             
            
            merge_images: mergeimages,


            templates:[
                {url: '{{ Voyager::image($customizableimage) }}', title:'{{ $product->name }}'},
            ],
            

            // number of text boxes
            text_boxes_count: 0,

            // thumbnail width
            merge_image_thumbnail_width: '100',
            template_thumbnail_width: 50,

            // thumbnail height
            merge_image_thumbnail_height: 50,
            template_thumbnail_height: 50,

            // download generated image instead of sending it to backend
            downloadGeneratedImage: true,

            i18n:{
                fontFamilyText: 'Font Family',
                enterTextText:'Enter Text',
                topText:'Top Text',
                bottomText: 'Bottom Text',
                sizeText:'Size',
                uperCaseText:'UperCase',
                mergeImageText: 'Append Your Logo',
                drawText:'Draw',
                addTextBoxText:'Add TextBox',
                previewText:'Preview',
                addTemplateText:'Add template',
                resetText: 'Reset',
                imageGeneratorText: 'PREVIEW',
                stopBrushingText:'Stop Brushing',
                canvasLoadingText: 'Canvas Loading'
            },

            onGenerate: function(data, formData) {
                // line number 1284 is where i can store this file
                
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });

                // let searchParams = new URLSearchParams(window.location.search)

                // if(searchParams.has('customizeid'))
                // {
                //     var customizeidresult = searchParams.get('customizeid');
                // }else{
                //     return alert('error');
                // }


                // var canvas = document.getElementById('example');
                // var dataURL = canvas.toDataURL();

                // $.ajax({
                //     type: "POST",
                //     url: "{{ route('customize.customized') }}",
                //     data: { 
                //         imgBase64: dataURL,
                //         customizeidresult: customizeidresult,
                //         data: data,
                //         formData: formData,
                //     }
                // }).done(function(o) {
                //     console.log('saved'); 
                // });


                // $.ajax({
                //     type:'POST',
                //     url: "{{ route('customize.customized') }}",
                //     data: {data: data, formData: formData, customizeidresult:customizeidresult},
                //     contentType: false,
                //     processData: false,
                //     success: (response) => {
                //         if (response) {
                //         this.reset();
                //         alert('Image has been uploaded successfully');
                //         }
                //     },
                //     error: function(response){
                //         console.log(response);
                //             // $('#image-input-error').text(response.responseJSON.errors.file);
                //             // alert(response.responseJSON.errors.file);
                //     }
                // });

                // end onGenerate
            },
            preRender: function(html){return html;},
            onInitialize: function(canvas_info){
            },
            onLoad: function(canvas_info){
            },
            alterTextInfo: function(text_info){},
            alterFontFamilies: function(All_FontFamilies){},
        });



        // $('#example').imageMaker({
        //     onGenerate: (data, formData) {},
        //     preRender: function(html){return html;},
        //     onInitialize: function(canvas_info){},
        //     onLoad: function(canvas_info){},
        //     alterTextInfo: function(text_info){},
        //     alterFontFamilies: function(All_FontFamilies){},
        // });

    });
    </script>




@endsection