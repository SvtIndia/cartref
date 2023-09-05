@if (Config::get('icrm.frontend.twocolumnfreerowscomponent.feature') == 1)
    

    @isset($collections2cfr)
        
        @if (count($collections2cfr) > 0)

        <section class="container">
            <div class="row">
                <div class="section-header">
                    <h3>{{ setting('2-column-description.title') }}</h3>
                    <p>{{ setting('2-column-description.description') }}</p>
                </div>
                <div class="section-body twocolumn">
                    @foreach ($collections2cfr as $collection)
                        <div class="section-item">
                            <a href="{{ $collection->url }}">
                                <img src="{{ Voyager::image($collection->image) }}" alt="{{ $collection->image }}" class="img-responsive">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        

        @endif

    @endisset

@endif