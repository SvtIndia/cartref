 <!-- Sticky Footer -->
 <div class="sticky-footer sticky-content fix-bottom fixed show">
    <a href="{{ route('welcome') }}" class="sticky-link">
        <i class="d-icon-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('products') }}" class="sticky-link">
        <i class="d-icon-volume"></i>
        <span>Browse</span>
    </a>
    {{-- <a href="{{ route('wishlist') }}" class="sticky-link">
        <i class="d-icon-heart"></i>
        <span>Wishlist</span>
    </a> --}}
    @if(Config::get('icrm.showcase_at_home.feature') == 1)
        @livewire('showcasecount',[
            'view' => 'mobile-bottom'
        ])
    @endif
    <a href="{{ route('myaccount') }}" class="sticky-link">
        <i class="d-icon-user"></i>
        <span>Account</span>
    </a>
    <div class="header-search hs-toggle dir-up">
        <a href="#" class="search-toggle sticky-link">
            <i class="d-icon-search"></i>
            <span>Search</span>
        </a>
        <form action="{{ route('search') }}" method="post" class="input-wrapper">
            @csrf
            <input type="text" class="form-control" name="search" value="{{ $_GET['search'] ?? '' }}" autocomplete="off" placeholder="Search your keyword..." value="{{ $_GET['search'] ?? '' }}" required="">
            <button class="btn btn-search" type="submit" title="submit-button">
                <i class="d-icon-search"></i>
            </button>
        </form>
    </div>
</div>
