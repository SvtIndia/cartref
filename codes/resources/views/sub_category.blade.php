@extends('layouts.website')

@section('meta-seo')
    <title>
        {{-- @if (request('category'))
            {{ ucwords(str_replace('-', ' ', request('category'))).' - ' }}
        @elseif(request('subcategory'))
        {{ ucwords(str_replace('-', ' ', request('subcategory'))).' - ' }}
        @endif

        {{ Config::get('seo.catalog.title') }} --}}
        {{ $user->brands ?? $user->name }} | Brand
    </title>

    <meta name="keywords" content="{{ Config::get('seo.catalog.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.catalog.description') }}">
@endsection
@section('headerlinks')
    <style>
        .product-wrapper{
            justify-content: space-around;
        }
        .vendor-wrap {
            width: 100%;
            height: 100%;
            position: relative;
            background: white;
            margin-bottom: 2rem;
        }

        .vendor {
            width: 100%;
            height: auto;
            background: linear-gradient(180deg, rgb(141, 205, 239) 0%, rgba(4.23, 194.01, 253.94, 0) 100%);
        }

        .vendor .brand-img-container {
            width: 150px !important;
            height: 180px;
            margin: auto;
            overflow: hidden;
            border-radius: 50%;
            border: 1px #B1A5A5 solid;
        }

        .vendor .brand-img{
            max-width: 100%;
            height: 100%;
            vertical-align: middle;
            width: 100%;
            object-fit: cover;
            border: 1px #B1A5A5 solid
        }

        .vendor .content {
            width: 100% !important;
            text-align: center !important;
            color: black;
            word-wrap: break-word;

        }

        .vendor .content .brand {
            font-size: 20px;
            font-weight: 400;
        }

        .vendor .content .description {
            font-size: 15px;
            font-weight: 400;
            letter-spacing: 3.60px;
        }

        .vendor .content-store {
            width: 100% !important;
            text-align: right !important;
            color: black;
            word-wrap: break-word;
        }

        .vendor .content-store .label {
            font-size: 15px;
            font-weight: 400;
            line-height: 18px;
            letter-spacing: 1.88px;
        }

        .vendor .content-store .rating {
            font-size: 32px;
            font-weight: 600;
            letter-spacing: 4px;
            text-align: right;
        }

        @media only screen and (max-width: 768px) {
            .vendor-wrap {
                margin-bottom: 2rem;
            }

            .vendor .brand-img-container {
                width: 120px !important;
                height: 150px;
            }


            .vendor .brand-img {
                height: 180px;
            }

            .vendor .content .brand {
                font-size: 15px;
                letter-spacing: 3px;
                text-align: center;
            }

            .vendor .content .description {
                font-size: 12px;
                letter-spacing: 0px
            }

            .vendor .content-store .label {
                font-size: 15px;
                font-weight: 400;
            }

            .vendor .content-store .rating {
                text-align: right;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: 4px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="page-content mb-10 pb-3">
            <div class="container mt-10 mb-10">
                <div class="row main-content-wrap gutter-lg">
                    <div class="col-lg-12 main-content">
                        <div class="row cols-2 cols-sm-5 product-wrapper box-mode">
                            @foreach ($subCategories as $subCategory)
                                <a href="{{ route('products.subcategory', ['subcategory' => $subCategory->slug, 'brands[' . $user->brands . ']' => $user->brands]) }}"
                                    class="vendor-wrap">

                                    <div class="vendor"
                                        style="background: linear-gradient(180deg, white 0%, rgba(4.23, 194.01, 253.94, 0) 100%);">
                                        <div class="brand-img-container">
                                            <img class="brand-img" src="{{ Voyager::image($subCategory->image) }}"
                                                onerror="this.onerror=null;this.src='{{ config('app.url') }}/images/placeholer.png';" />
                                        </div>
                                        <div class="content">
                                            <span class="brand">{{ $subCategory->name }}</span><br>
                                            {{-- HSN :<span class="description">{{ $subCategory->hsn }}</span> --}}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Livewire Component wire-end:7siXOD3evKnwmcef4hyX -->
    </div>
@endsection
