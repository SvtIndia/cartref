<section class="pt-6 pb-6" style="background: #101221;">
    <div class="banner banner-background parallax text-center" data-option="{'offset': -60}" style="background-color: #101221; position: relative; overflow: hidden;"><div class="parallax-background" style="background-size: cover; position: absolute; top: 0px; left: 0px; width: 100%; height: 180%; transform: translate3d(0px, -263.495px, 0px); background-position-x: 50%;"></div>
        <div class="container">
            <div class="banner-content">
                <h3 class="banner-title font-weight-bold text-white mb-1">Sign up to {{ env('APP_NAME') }}</h3>
                
                @if (!empty(Config::get('icrm.frontend.newslettersignup.description')))
                    <p class="text-light ls-s">{{Config::get('icrm.frontend.newslettersignup.description')}}</p>    
                @endif
                
                <div class="col-lg-6 d-lg-block d-flex justify-content-center mx-auto">
                    <form action="{{ route('newslettersignup') }}" method="post" class="input-wrapper input-wrapper-round input-wrapper-inline ml-lg-auto">
                        @csrf
                        <input type="email" class="form-control font-primary form-solid" name="email" id="email" placeholder="Email address here..." required="">
                        <button class="btn btn-sm btn-primary" type="submit">Subscribe<i class="d-icon-arrow-right"></i></button>
                    </form>
                </div>
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
</section>