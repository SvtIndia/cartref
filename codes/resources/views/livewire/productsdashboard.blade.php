<div class="dashboard">
    <div class="item">
        <div class="stat">
            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/products?type={{ request('type') }}">
                <span class="count">{{ $this->products }}</span>
            </a>
        </div>
        <div class="info">
            <span class="title">Products</span>
        </div>
    </div>
    <div class="item @if(request('filter') == 'activeproducts') active @endif">
        <div class="stat">
            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/products?filter=activeproducts&type={{ request('type') }}">
                <span class="count">{{ $this->activeproducts }}</span>
            </a>
        </div>
        <div class="info">
            <span class="title">Active</span>
        </div>
    </div>
    <div class="item @if(request('filter') == 'inactiveproducts') active @endif">
        <div class="stat">
            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/products?filter=inactiveproducts&type={{ request('type') }}">
                <span class="count">{{ $this->inactiveproducts }}</span>
            </a>
        </div>
        <div class="info">
            <span class="title">Inactive</span>
        </div>
    </div>
    <div class="item @if(request('filter') == 'pendingforverificationproducts') active @endif">
        <div class="stat">
            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/products?filter=pendingforverificationproducts&type={{ request('type') }}">
                <span class="count">{{ $this->pendingforverificationproducts }}</span>
            </a>
        </div>
        <div class="info">
            <span class="title">Pending For Verification</span>
        </div>
    </div>
</div>

<div class="types">

    <div>
        <span class="searchresult">
            Showing result
            @if (request('type'))
                for {{ request('type') }} type
            @endif
            @if (request('filter'))
                @if(request('type')) in @else for @endif
                    @if(request('filter') == 'activeproducts') Active Products
                    @elseif(request('filter') == 'inactiveproducts') In-Active Products
                    @elseif(request('filter') == 'pendingforverificationproducts') Pending for Verification Products
                    @else {{ request('filter') }}
                    @endif
            @endif
            @if (empty(request('type')) && empty(request('filter')))
                for all
            @endif
        </span>
    </div>

    <ul>

        @if (request('type') OR request('filter') OR request('order_id'))
        <li>
            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/products" style="color: blue;">
                Reset
            </a>
        </li>
        @endif

        <li>
            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/products?type=regular" @if(request('type') == 'regular') style="color: #f93e18;" @endif>
                Regular
            </a>
        </li>
        @if (Config::get('icrm.customize.feature') == 1)
        <li>
            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/products?type=customized" @if(request('type') == 'customized') style="color: #f93e18;" @endif>
                Customized
            </a>
        </li>
        @endif
    </ul>
</div>