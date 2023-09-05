@extends('layouts.website')

@section('meta-seo')
    <title>{{ Config::get('seo.contactus.title') }}</title>
    <meta name="keywords" content="{{ Config::get('seo.contactus.keywords') }}">
    <meta name="description" content="{{ Config::get('seo.contactus.description') }}">
@endsection

@section('content')
<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}"><i class="d-icon-home"></i></a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </nav>
    <div class="page-header">
        {{-- style="background-image: url(images/page-header/contact-us.jpg)" --}}
        <h1 class="page-title font-weight-bold text-capitalize ls-l">Contact Us</h1>
    </div>
    <div class="page-content mt-10 pt-7 mb-10">
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 ls-m mb-4">
                        <div class="grey-section d-flex align-items-center h-100">
                            <div class="pt-5 pr-5 pb-5 pl-5">
                                {{-- <h4 class="mb-2 text-capitalize">Headquarters</h4>
                                <p>1600 Amphitheatre Parkway<br>New York WC1 1BA</p> --}}

                                <h4 class="mb-2 text-capitalize">Phone Number</h4>
                                {!! setting('contact-us.phone_numbers') !!}

                                <h4 class="mb-2 text-capitalize">Support</h4>
                                {!! setting('contact-us.support') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 d-flex align-items-center mb-4">
                        <div class="w-100">
                            <form class="pl-lg-2" action="{{ route('contactuspost') }}" method="post">
                                @csrf
                                <h4 class="ls-m font-weight-bold">Let’s Connect</h4>
                                <p>Your email address will not be published. Required fields are
                                    marked *</p>
                                <div class="row mb-2">
                                    <div class="col-md-4 mb-4">
                                        <input class="form-control" type="text" placeholder="Name *" name="name" required="">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <input class="form-control" type="email" placeholder="Email *" name="email" required="">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <input class="form-control" type="text" placeholder="Phone *" name="phone" required="">
                                    </div>
                                    <div class="col-12 mb-4">
                                        <textarea class="form-control" required="" placeholder="Message*" name="message"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark btn-rounded">Submit<i class="d-icon-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</main>
@endsection

