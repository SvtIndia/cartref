@php
    $skus = App\Productsku::where('product_id', $dataTypeContent->getKey())->orderBy('size', 'ASC')->get();
@endphp

@isset($skus)
    @if (count($skus) > 0)
    <div class="container">
        <div class="row">
            <h3>Product SKU's</h3>
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="SKUdataTable" class="table table-hover">
            <thead>
                <tr>
                    @if (Config::get('icrm.stock_management.inventory') == 0)
                        <th class="actions text-center dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                    @endif
                    <th>SKU</th>
                    <th>Size</th>
                    @if (Config::get('icrm.product_sku.color') == 1)
                        <th>Color</th>
                    @endif
                    <th>Price</th>
                    <th>Dimensions (L/B/H/W)</th>
                    <th class="text-center">Available Stock</th>
                    <th>Status</th>
                    <th>Create At</th>
                </tr>
            </thead>
            <tbody>
                @isset($skus)
                    @foreach ($skus as $sku)
                        <tr>
                            @if (Config::get('icrm.stock_management.inventory') == 0)
                                <td style="text-align: center">
                                    @if ($sku->status == 1)
                                        <a target="_blank" href="{{ url('/'.Config('icrm.admin_panel.prefix').'/productsku/'.$sku->id.'/edit') }}">Edit</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endif
                            <th>{{ $sku->sku }}</th>
                            <th>{{ $sku->size }}</th>
                            @if (Config::get('icrm.product_sku.color') == 1)
                                <th>{{ $sku->color }}</th>
                            @endif
                            
                            <th>
                                @if (!empty($sku->offer_price))
                                    {{ Config::get('icrm.currency.icon') }} {{ $sku->offer_price }}/- <del>{{ $sku->mrp }}</del>
                                @else
                                    -
                                @endif
                            </th>

                            <th>
                                {{ $sku->length.' / '.$sku->breath.' / '.$sku->height.' / '.$sku->weight }}
                            </th>

                            <th class="text-center">{{ $sku->available_stock }}</th>
                            <th>
                                @if ($sku->status == 1)
                                    <span style="color: green;">Active</span>
                                @else
                                    <span style="color: red;">Inactive</span>
                                @endif
                            </th>
                            <th>{{ $sku->created_at }}</th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Looks like you dont have any SKU on this product.</td>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
    @endif
@endisset