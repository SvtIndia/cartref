@if (Config::get('icrm.frontend.threecolumnfreerowscomponent.feature') == 1)
    

    @isset($collections3cfr)
        
        @if (count($collections3cfr) > 0)

        <section class="container">
            <div class="row">
                <div class="section-header">
                    <h3>{{ setting('3-column-and-free-rows-collections.title') }}</h3>
                    <p>{{ setting('3-column-and-free-rows-collections.description') }}</p>
                </div>
                <div class="section-body threecolumn">
                    @foreach ($collections3cfr as $collection)
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