    <!-- MobileMenu -->
    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-overlay">
        </div>
        <!-- End of Overlay -->
        <a class="mobile-menu-close" href="#"><i class="d-icon-times"></i></a>
        <!-- End of CloseButton -->
        <div class="mobile-menu-container scrollable">
            <form action="{{ route('search') }}" method="post" class="input-wrapper">
                @csrf
                <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search your keyword..." value="{{ $_GET['search'] ?? '' }}" required="">
                <button class="btn btn-search" type="submit" title="submit-button">
                    <i class="d-icon-search"></i>
                </button>
            </form>
            <!-- End of Search Form -->
            <ul class="mobile-menu mmenu-anim">
                @auth
                    <li class="submenu active">
                        <div class="authname">Welcome {{ strtok(auth()->user()->name, ' ') }}!</div>
                    </li>
                @endauth

                {{ menu('Website', 'components.frontend.headers.01-navs') }}

                <li class="submenu active">
                    {{-- <a href="">Select Language</a> --}}
                    <a>{{ Config::get('languages')[App::getLocale()]['display'] }}</a>
                    <ul>
                        @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <li data-original-index="{{ $lang }}">
                                <a href="{{ route('lang.switch', $lang) }}" tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">
                                    {{$language['display']}}
                                </a>
                            </li>
                        @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
            <!-- End of MobileMenu -->
        </div>
    </div>
