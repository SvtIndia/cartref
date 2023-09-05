@if (Config::get('icrm.frontend.fivecolumnfreerowscomponent.feature') == 1)
    

    @isset($collections5cfr)
        
        @if (count($collections5cfr) > 0)

        <section class="container">
            <div class="row">
                <div class="section-header">
                    <h3>{{ setting('5-column-description.title') }}</h3>
                    <p>{{ setting('5-column-description.description') }}</p>
                </div>
                <div class="section-body">
                    @foreach ($collections5cfr as $collection)
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