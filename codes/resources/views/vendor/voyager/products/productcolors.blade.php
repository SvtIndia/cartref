@php
    $colors = App\Productcolor::where('product_id', $dataTypeContent->getKey())->get();
@endphp

@isset($colors)
    @if (count($colors) > 1)
    <div class="container">
        <div class="row">
            <h3>Product Variations Image</h3>
        </div>
    </div>
    <div class="table-responsive">
        <table id="ColorsdataTable" class="table table-hover">
            <thead>
                <tr>
                    <th class="actions text-center dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                    <th>Color</th>
                    <th>Main Image</th>
                    @if (Config::get('icrm.customize.feature') == 1)
                        <th>Customizable Image</th>
                    @endif
                    <th>Status</th>
                    <th>Create At</th>
                </tr>
            </thead>
            <tbody>
                @isset($colors)
                    @foreach ($colors as $color)
                        <tr>
                            <td style="text-align: center">
                                @if ($color->status == 1)
                                    <a target="_blank" href="{{ url('/'.Config('icrm.admin_panel.prefix').'/productcolors/'.$color->id.'/edit') }}">Edit</a>
                                @else
                                    -
                                @endif
                            </td>
                            <th>{{ $color->color }}</th>
                            <th>
                                @if (!empty(Voyager::image($color->main_image)))
                                    <img src="{{ Voyager::image($color->main_image) }}" alt="{{ $color->color.' '.$color->product_id }}" style="max-height: 50px;">    
                                @else
                                    NA
                                @endif
                            </th>

                            @if (Config::get('icrm.customize.feature') == 1)
                                <th>
                                    @if (!empty(Voyager::image($color->customizable_image)))
                                        <img src="{{ Voyager::image($color->customizable_image) }}" alt="{{ $color->color.'- Customizable - '.$color->product_id }}" style="max-height: 50px;">    
                                    @else
                                        NA
                                    @endif
                                </th>
                            @endif
                            
                            <th>
                                @if ($color->status == 1)
                                    <span style="color: green;">Active</span>
                                @else
                                    <span style="color: red;">Inactive</span>
                                @endif
                            </th>
                            <th>{{ $color->created_at }}</th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Looks like you dont have any colors on this product.</td>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
    @endif
@endisset