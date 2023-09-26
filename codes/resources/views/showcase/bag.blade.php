@extends('layouts.website')

@section('meta-seo')
    <title>Showcase at home Bag</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Riode - Ultimate eCommerce Template">

    <style>
        @media screen and (max-width: 480px) {
            .cart .shop-table tr {
                padding: 1rem 0 0rem !important;
            }

            .product-thumbnail {
                padding: 0rem 2rem 1.5rem 0 !important;
            }

            .product-thumbnail figure {
                width: 100%;
                height: 100%;
            }

            .product-thumbnail figure a {
                width: 100% !important;
                height: 100% !important;
            }

            .product-thumbnail figure img {
                width: inherit !important;
                height: 190px !important;
                max-width: inherit !important;
                max-height: inherit !important;
            }

            .cart-tr {
                display: flex !important;
                flex-wrap: wrap;
            }

            .product-thumbnail {
                max-width: 50%;
                flex: 0 0 50%;
            }

            .product-name {
                max-width: 50%;
                flex: 0 0 50%;
                text-align: left;
            }

            .product-quantity {
                max-width: 25%;
                flex: 0 0 50%;
            }

            .product-price {
                max-width: 40%;
                flex: 0 0 50%;
                text-align: left !important;
                margin-top: 5px;
                margin-left: 4rem;
            }

            .product-price .amount {
                color: blue;
                font-size: 2rem;
            }

            .cart .product-remove {
                position: unset !important;
            }

            .product-close {
                margin-bottom: 5px;
                align-items: center;
                display: flex !important;

            }
            .save_text{
                font-size: 14px;
                color: green;
            }
            .input-group{
                width: 9rem !important;
            }
        }
    </style>
@endsection

@section('content')
@livewire('showcase.bag')
@endsection
