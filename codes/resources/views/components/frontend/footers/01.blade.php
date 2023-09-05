<footer class="footer appear-animate" data-animation-options="{ 'delay': '.2s' }">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget-about">
                        <a href="/" class="logo-footer mb-5">
                            <img src="{{ Voyager::image(setting('site.logo')) }}" alt="logo-footer" width="154" height="43">
                        </a>
                        <div class="widget-body">
                            <p>{{setting('footer.description')}}</p>
                            <a href="mailto:{{ setting('footer.contact_email') }}">{{ setting('footer.contact_email') }}</a>
                        </div>
                    </div>
                    <!-- End of Widget -->
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget">
                        <h4 class="widget-title">Account</h4>
                        <ul class="widget-body">
                            <li><a href="{{ route('myaccount') }}">My Account</a></li>
                            @foreach ($pages as $page)
                                <li><a href="{{ route('page.slug', ['slug' => $page->slug]) }}">{{ $page->page_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- End of Widget -->
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="widget mb-6 mb-sm-0">
                        <h4 class="widget-title">Get Help</h4>
                        <ul class="widget-body">
                            <li><a href="{{ route('myorders') }}">My Orders</a></li>
                            <li><a href="{{ route('bag') }}">My Cart</a></li>

                            @if (Config::get('icrm.vendor.signup') == 1)
                                <li><a href="{{ route('becomeseller') }}">Become Seller</a></li>
                            @endif

                            <li><a href="{{ route('contactus') }}">Contact Us</a></li>
                            <li><a href="{{ route('aboutus') }}">About Us</a></li>
                            <li><a href="/sitemap.xml">Site Map</a></li>
                        </ul>
                    </div>
                    <!-- End of Widget -->
                </div>
                <div class="col-lg-4 col-sm-6">
                    @if (Config::get('icrm.frontend.newslettersignup.feature') == 1)
                        {{-- show only when user is not signedup for news letter --}}
                        @if (empty(Session::get('signedupfornewsletter')))
                            <div class="widget">
                                <h4 class="widget-title text-normal">Subscribe to Our Newsletter</h4>
                                <div class="widget-body widget-newsletter">
                                    <form action="{{ route('newslettersignup') }}" method="post" class="input-wrapper input-wrapper-inline">
                                        @csrf
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email address here..." required="">
                                        <button class="btn btn-primary btn-sm btn-icon-right btn-rounded" type="submit">subscribe<i class="d-icon-arrow-right"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="footer-info">
                        <figure class="payment">
                            <img src="{{ asset('images/icrm/settings/payment.png') }}" alt="payment"
                            {{-- width="135" height="24" --}}
                            >
                        </figure>
                    </div>

                    <div class="widget">
                        @if (Config::get('icrm.frontend.socialpagelinks.feature') == 1)
                        <div class="social-links mt-4 text-white">
                            @if (!empty(setting('social-links.youtube')))
                                <a href="{{ setting('social-links.youtube') }}" class="social-link social-youtube fab fa-youtube"></a>
                            @endif
                            @if (!empty(setting('social-links.facebook')))
                                <a href="{{ setting('social-links.facebook') }}" class="social-link social-facebook fab fa-facebook-f"></a>
                            @endif
                            @if (!empty(setting('social-links.instagram')))
                                <a href="{{ setting('social-links.instagram') }}" class="social-link social-instagram fab fa-instagram"></a>
                            @endif
                            @if (!empty(setting('social-links.twitter')))
                                <a href="{{ setting('social-links.twitter') }}" class="social-link social-twitter fab fa-twitter"></a>
                            @endif
                            @if (!empty(setting('social-links.linkedin')))
                                <a href="{{ setting('social-links.linkedin') }}" class="social-link social-linkedin fab fa-linkedin-in"></a>
                            @endif
                            @if (!empty(setting('social-links.googleplus')))
                                <a href="{{ setting('social-links.googleplus') }}" class="social-link social-google fab fa-google-plus-g"></a>
                            @endif
                        </div>
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of FooterMiddle -->
    <div class="footer-bottom d-block text-center">
        <p class="copyright">{{ env('APP_NAME') }} © 2023. All Rights Reserved</p>
    </div>
    <!-- End of FooterBottom -->
</footer>
