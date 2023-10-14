@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing') . ' ' . $dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.' . $dataType->slug . '.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if (!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.' . $dataType->slug . '.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if ($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes"
                    data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}"
                    data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan

        @foreach ($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach

    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">


                        @php
                            if (
                                auth()
                                    ->user()
                                    ->hasRole(['Vendor'])
                            ) {
                                $orders = App\Order::where('vendor_id', auth()->user()->id)->get();
                            } else {
                                $orders = App\Order::get();
                            }
                        @endphp

                        <div style="display:inline-flex; width:100%; justify-content: space-between">
                            <div style="width: 48%">
                                <h3>Order Manifestation <i class="voyager-basket"></i></h1>
                                    <div class="dashboard">
                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=New Order">
                                            <div class="item @if (request('label') == 'New Order') new_order active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'New Order')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">New Orders</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a
                                            href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Ready to Dispatch">
                                            <div
                                                class="item @if (request('label') == 'Ready to Dispatch') ready_to_dispatch active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'Ready To Dispatch')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Ready To Dispatch</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a
                                            href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Scheduled For Pickup">
                                            <div
                                                class="item @if (request('label') == 'Scheduled For Pickup') scheduled_for_pickup active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'Scheduled For Pickup')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Pending Pickup</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            </div>
                            <div style="width: 48%">
                                <h3>Order Haulage <i class="voyager-truck"></i></h1>
                                    <div class="dashboard">
                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Shipped">
                                            <div class="item @if (request('label') == 'Shipped') shipped active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'Shipped')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">In Transist</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Delivered">
                                            <div class="item @if (request('label') == 'Delivered') delivered active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'Delivered')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Delivered</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Cancelled">
                                            <div class="item @if (request('label') == 'Cancelled') cancelled active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'Cancelled')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Cancelled</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            </div>
                        </div>

                        <div style="display:inline-flex; width:100%; justify-content: space-between">
                            <div style="width: 48%">
                                <h3>Returns <i class="voyager-refresh"></i>
                                    </h1>
                                    <div class="dashboard">

                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=RTO">
                                            <div class="item @if (request('label') == 'RTO') rto active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'RTO')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Return To Origin</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a
                                            href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Request For Return">
                                            <div
                                                class="item @if (request('label') == 'Request For Return') requestforreturn active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->whereIn('order_status', ['Requested For Return', 'Return Request Accepted', 'Return Request Rejected', 'Returned'])->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Customer Return</span>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Returned">
                                            <div class="item @if (request('label') == 'Returned') returned active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('order_status', 'Returned')->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Returne Delivered</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            </div>

                            <div style="width: 48%">
                                <h3>Journey at Cartrefs
                                    <i class="voyager-location"></i>
                                    </h1>
                                    <div class="dashboard">
                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?all=true">
                                            <div class="item @if (request('all') == true) active @endif">
                                                <div class="stat">
                                                    <span
                                                        class="count">{{ $orders->where('created_at','>',now()->subDays(60)->endOfDay())->count() }}</span>
                                                </div>
                                                <div class="info">
                                                    <span class="title">Completed in 90 days</span>
                                                </div>
                                            </div>
                                        </a>
                                        @if (auth()->user()->hasRole('Client'))
                                            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?all=true">
                                                <div class="item @if (request('all') == true) active @endif">
                                                    <div class="stat">
                                                        <span class="count">{{ $orders->count() }}</span>
                                                    </div>
                                                    <div class="info">
                                                        <span class="title">Total Orders</span>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Other">
                                                <div class="item @if (request('label') == 'Other') other active @endif">
                                                    <div class="stat">
                                                        <span
                                                            class="count">{{ $orders->where('order_status', 'Other')->count() }}</span>
                                                    </div>
                                                    <div class="info">
                                                        <span class="title">Others</span>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                            </div>
                            @if (Config::get('icrm.order_lifecycle.undermanufacturing.feature') == 1)
                                <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?label=Under Manufacturing">
                                    <div
                                        class="item @if (request('label') == 'Under Manufacturing') under_manufacturing active @endif">
                                        <div class="stat">
                                            <span
                                                class="count">{{ $orders->where('order_status', 'Under Manufacturing')->count() }}</span>
                                        </div>
                                        <div class="info">
                                            <span class="title">Under Manufacturing</span>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>


                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-2">
                                        <select id="search_key" name="key">
                                            @foreach ($searchNames as $key => $name)
                                                <option value="{{ $key }}"
                                                    @if ($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                            <option value="contains" @if ($search->filter == 'contains') selected @endif>
                                                contains</option>
                                            <option value="equals" @if ($search->filter == 'equals') selected @endif>=
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control"
                                            placeholder="{{ __('voyager::generic.search') }}" name="s"
                                            value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                            </form>
                        @endif

                        {{-- <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                        @if ($showCheckboxColumn)
                                            <th class="dt-not-orderable">
                                                <input type="checkbox" class="select_all">
                                            </th>
                                        @endif
                                        @foreach ($dataType->browseRows as $row)
                                        <th>
                                            @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                            @endif
                                            {{ $row->getTranslatedAttribute('display_name') }}
                                            @if ($isServerSide)
                                                @if ($row->isCurrentSortField($orderBy))
                                                    @if ($sortOrder == 'asc')
                                                        <i class="voyager-angle-up pull-right"></i>
                                                    @else
                                                        <i class="voyager-angle-down pull-right"></i>
                                                    @endif
                                                @endif
                                                </a>
                                            @endif
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTypeContent as $data)
                                    <tr @if ($data->order_status == 'Under processing') style="background: #fce5c1;" @elseif($data->order_status == 'Ready to dispatch') style="background: #c2e6fa;" @elseif($data->order_status == 'Shipped') style="background: #d4fae4;" @endif>
                                        <td class="no-sort no-click bread-actions">
                                            <ul style="display: inline-flex;">
                                                @foreach ($actions as $action)
                                                    @if (!method_exists($action, 'massAction'))
                                                        @include('voyager::bread.partials.actions', ['action' => $action])
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                        @if ($showCheckboxColumn)
                                            <td>
                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                            </td>
                                        @endif
                                        @foreach ($dataType->browseRows as $row)
                                            @php
                                            if ($data->{$row->field.'_browse'}) {
                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                            }
                                            @endphp
                                            <td @if ($row->getTranslatedAttribute('display_name') == 'Product') style="min-width: 250px;" @endif>
                                                @if (isset($row->details->view))
                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                @elseif($row->type == 'image')
                                                    <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                @elseif($row->type == 'relationship')

                                                    @if ($row->getTranslatedAttribute('display_name') == 'Product')
                                                        @if (!empty($data->color))
                                                            <a href="{{ route('product.slug', ['slug' => $data->product->slug, 'color' => $data->color]) }}" target="_blank" style="color: blue;">
                                                        @else
                                                            <a href="{{ route('product.slug', ['slug' => $data->product->slug]) }}" target="_blank" style="color: blue;">
                                                        @endif

                                                    @endif

                                                    @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])

                                                    @if ($row->getTranslatedAttribute('display_name') == 'Product')
                                                        </a>
                                                    @endif
                                                @elseif($row->type == 'select_multiple')
                                                    @if (property_exists($row->details, 'relationship'))

                                                        @foreach ($data->{$row->field} as $item)
                                                            {{ $item->{$row->field} }}
                                                        @endforeach

                                                    @elseif(property_exists($row->details, 'options'))
                                                        @if (!empty(json_decode($data->{$row->field})))
                                                            @foreach (json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif
                                                    @endif

                                                    @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                        @if (@count(json_decode($data->{$row->field})) > 0)
                                                            @foreach (json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif

                                                @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                    {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                    @if (property_exists($row->details, 'format') && !is_null($data->{$row->field}))
                                                        {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                    @else
                                                        {{ $data->{$row->field} }}
                                                    @endif
                                                @elseif($row->type == 'checkbox')
                                                    @if (property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                        @if ($data->{$row->field})
                                                            <span class="label label-info">{{ $row->details->on }}</span>
                                                        @else
                                                            <span class="label label-primary">{{ $row->details->off }}</span>
                                                        @endif
                                                    @else
                                                    {{ $data->{$row->field} }}
                                                    @endif
                                                @elseif($row->type == 'color')
                                                    <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                @elseif($row->type == 'text')

                                                    @if ($row->getTranslatedAttribute('display_name') == 'Order Id')
                                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?order_id={{ $data->{$row->field} }}" style="color: blue;">
                                                    @endif

                                                    @if ($row->getTranslatedAttribute('display_name') == 'AWB No')
                                                        <a href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?order_awb={{ $data->{$row->field} }}" style="color: blue;">
                                                    @endif

                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 50 ? mb_substr($data->{$row->field}, 0, 50) . ' ...' : $data->{$row->field} }}</div>

                                                    @if ($row->getTranslatedAttribute('display_name') == 'Order Id')
                                                        </a>
                                                    @endif

                                                    @if ($row->getTranslatedAttribute('display_name') == 'AWB No')
                                                        </a>
                                                    @endif

                                                @elseif($row->type == 'text_area')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 50 ? mb_substr($data->{$row->field}, 0, 50) . ' ...' : $data->{$row->field} }}</div>
                                                @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    @if (json_decode($data->{$row->field}) !== null)
                                                        @foreach (json_decode($data->{$row->field}) as $file)
                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                {{ $file->original_name ?: '' }}
                                                            </a>
                                                            <br/>
                                                        @endforeach
                                                    @else
                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                            Download
                                                        </a>
                                                    @endif
                                                @elseif($row->type == 'rich_text_box')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                @elseif($row->type == 'coordinates')
                                                    @include('voyager::partials.coordinates-static-image')
                                                @elseif($row->type == 'multiple_images')
                                                    @php $images = json_decode($data->{$row->field}); @endphp
                                                    @if ($images)
                                                        @php $images = array_slice($images, 0, 3); @endphp
                                                        @foreach ($images as $image)
                                                            <img src="@if (!filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                        @endforeach
                                                    @endif
                                                @elseif($row->type == 'media_picker')
                                                    @php
                                                        if (is_array($data->{$row->field})) {
                                                            $files = $data->{$row->field};
                                                        } else {
                                                            $files = json_decode($data->{$row->field});
                                                        }
                                                    @endphp
                                                    @if ($files)
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                            <img src="@if (!filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                            @endforeach
                                                        @else
                                                            <ul>
                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                <li>{{ $file }}</li>
                                                            @endforeach
                                                            </ul>
                                                        @endif
                                                        @if (count($files) > 3)
                                                            {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                        @endif
                                                    @elseif (is_array($files) && count($files) == 0)
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @elseif ($data->{$row->field} != '')
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                        @else
                                                            {{ $data->{$row->field} }}
                                                        @endif
                                                    @else
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @endif
                                                @else
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <span>{{ $data->{$row->field} }}</span>
                                                @endif
                                            </td>
                                        @endforeach

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                    's' => $search->value,
                                    'filter' => $search->filter,
                                    'key' => $search->key,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder,
                                    'showSoftDeleted' => $showSoftDeleted,
                                ])->links() }}
                            </div>
                        @endif --}}

                        <?php
                        // echo"<pre>";
                        //     print_r($dataTypeContent[0]);
                        //     echo"</pre>";
                        ?>
                        {{-- <div class="sliding-btn-div">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" id="left-button">
                                        <span class="page-link" aria-hidden="true">‹</span>
                                    </li>
                                    <li class="page-item" id="right-button">
                                        <span class="page-link" aria-hidden="true">›</span>
                                    </li>
                                </ul>
                            </nav>
                        </div> --}}
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-responsive table-hover"
                                style="width: 100%; min-width:1600px; overflow-x:auto;">
                                <thead>
                                    <tr>
                                        <th class="actions text-right dt-not-orderable">
                                            {{ __('voyager::generic.actions') }}</th>
                                        <th>ID</th>
                                        @if ($showCheckboxColumn)
                                            <th class="dt-not-orderable">
                                                <input type="checkbox" class="select_all">
                                            </th>
                                        @endif
                                        <th>Order Date</th>
                                        <th style="border-right:none;">Product Information</th>
                                        <th style="border-right:none;"></th>
                                        <th>Quantity</th>
                                        @if (auth()->user()->hasRole('Client'))
                                            <th>Seller Information</th>
                                        @endif
                                        <th>Amount</th>
                                        {{-- @if (auth()->user()->hasRole('Client') ||
    (request('label') != 'New Order' &&
        auth()->user()->hasRole('Vendor'))) --}}
                                        <th>Logistic Details</th>
                                        {{-- @endif --}}
                                        @if (auth()->user()->hasRole('Client'))
                                            <th>Buyer Information</th>
                                        @endif
                                        @if (auth()->user()->hasRole('Client'))
                                            <th>Pickup and Delivery</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTypeContent as $data)


                                        <tr
                                            @if ($data->order_status == 'Under processing') style="background: #fce5c1;" @elseif($data->order_status == 'Ready to dispatch') style="background: #c2e6fa;" @elseif($data->order_status == 'Shipped') style="background: #d4fae4;" @endif>
                                            <td class="no-sort no-click bread-actions" style="width: 2% !important;">
                                                <ul
                                                    style="display: inline-grid;margin-block-start: 0em;padding-inline-start: 0px;">
                                                    @foreach ($actions as $action)
                                                        @if (!method_exists($action, 'massAction'))
                                                            @include('voyager::bread.partials.actions', [
                                                                'action' => $action,
                                                            ])
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td style="width: 1% !important;">
                                                {{ $data->id }}
                                                {{-- {{ $data }} --}}
                                            </td>
                                            @if ($showCheckboxColumn)
                                                <td style="width: 1% !important;">
                                                    <input type="checkbox" name="row_id"
                                                        id="checkbox_{{ $data->getKey() }}"
                                                        value="{{ $data->getKey() }}">
                                                </td>
                                            @endif
                                            <td style="width: 10% !important;">
                                                <div>
                                                    {{ date('M d, Y', strtotime($data->created_at)) }}
                                                </div>

                                                <br>

                                                <div>
                                                    OrderNum :-
                                                    <a
                                                        href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?order_id={{ $data->order_id }}">
                                                        {{ $data->order_id }}
                                                    </a>
                                                </div>
                                                <br>
                                                <div>
                                                    @php
                                                        $sameDayEnd = date('Y-m-d 00:00:00', strtotime($data->created_at));
                                                        $forward = Carbon\Carbon::parse($sameDayEnd)->addDay(1);

                                                        $hourdiff = round((time() - strtotime($forward)) / 3600, 1);

                                                        $now = $forward;
                                                        $now->format('Y-m-d H:i:s');
                                                        $hours = 36;
                                                        $modified = (clone $now)->add(new DateInterval("PT{$hours}H"));


                                                        $newDiff = round((strtotime($modified) - time()) / 3600, 0);

                                                        if ($hourdiff > 36 && ($data->order_status == 'New Order' || $data->order_status == 'Under Manufacturing')) {
                                                            echo '<span
                                                                style="color: red;font-weight:600; font-size:15px">LATE SHIPMENT <br>LPF: '.round($data->product_offerprice * 0.1035, 0).'/- </span>'; # code...
                                                        } elseif ($hourdiff < 36 && ($data->order_status == 'New Order' || $data->order_status == 'Under Manufacturing')) {
                                                            echo '<span style="color: green;font-weight:400; font-size:12px">Please dispatch your order on or before '.
                                                                $modified->format('jS M, Y H:i A') .' to avoid a late processing fees ';
                                                        }
                                                    @endphp
                                                </div>
                                            </td>
                                            <td style="width: 10% !important;">
                                                <div class="product-information">
                                                    @if (!empty($data->color))
                                                        <a href="{{ route('product.slug', ['slug' => $data->product->slug, 'color' => $data->color]) }}"
                                                            class="name" target="_blank">
                                                        @else
                                                            <a href="{{ route('product.slug', ['slug' => $data->product->slug]) }}"
                                                                class="name" target="_blank">
                                                    @endif
                                                    @if (!empty($data->color))
                                                        @php
                                                            $colorimage = App\Productcolor::where('color', $data->color)
                                                                ->where('product_id', $data->product_id)
                                                                ->first();
                                                        @endphp

                                                        @if (!empty($colorimage))
                                                            @if (!empty($colorimage->main_image))
                                                                <img style="width: 2rem; height:2rem;"
                                                                    src="{{ Voyager::image($colorimage->main_image) }}"
                                                                    alt="{{ $data->product->name }}">
                                                            @else
                                                                <img style="width: 2rem; height:2rem;"
                                                                    src="{{ Voyager::image($data->product->image) }}"
                                                                    alt="{{ $data->product->name }}">
                                                            @endif
                                                        @else
                                                            <img style="width: 2rem; height:2rem;"
                                                                src="{{ Voyager::image($data->product->image) }}"
                                                                alt="{{ $data->product->name }}">
                                                        @endif
                                                    @else
                                                        <img style="width: 2rem; height:2rem;"
                                                            src="{{ Voyager::image($data->product->image) }}"
                                                            alt="{{ $data->product->name }}">
                                                    @endif

                                                    </a>
                                                    <div class="info">
                                                        @if (!empty($data->color))
                                                            <a href="{{ route('product.slug', ['slug' => $data->product->slug, 'color' => $data->color]) }}"
                                                                class="name" target="_blank">
                                                            @else
                                                                <a href="{{ route('product.slug', ['slug' => $data->product->slug]) }}"
                                                                    class="name" target="_blank">
                                                        @endif
                                                        {{ Str::limit($data->product->name, 30) }}
                                                        </a>
                                                        <div>
                                                            <div>
                                                                SKU: {{ $data->product_sku }}
                                                            </div>

                                                            @if (!empty($data->size))
                                                                <div>
                                                                    Size: {{ $data->size }}
                                                                </div>
                                                            @endif

                                                            @if (!empty($data->color))
                                                                <div>
                                                                    Color: {{ $data->color }}
                                                                </div>
                                                            @endif


                                                            @if (!empty($data->g_plus))
                                                                <div>
                                                                    G+: {{ $data->g_plus }}
                                                                </div>
                                                            @endif

                                                            @if (!empty($data->requirement_document))
                                                                <div>
                                                                    Requirements: <a
                                                                        href="{{ $data->requirement_document }}"
                                                                        style="color: blue;">Download</a>
                                                                </div>
                                                            @endif

                                                            @if (!empty($data->customized_image))
                                                                <div>
                                                                    Customized Image:
                                                                    <a href="{{ $data->customized_image }}"
                                                                        style="color: blue;">Download</a>
                                                                </div>
                                                            @endif

                                                            @if (!empty($data->original_file))
                                                                <div>
                                                                    Original File:
                                                                    @php
                                                                        $originalfiles = collect(json_decode($data->original_file));
                                                                    @endphp
                                                                    @foreach ($originalfiles as $key => $originalfile)
                                                                        <a href="{{ $originalfile }}" target="_blank"
                                                                            style="color: blue;">Attachment
                                                                            {{ $key + 1 }} @if ($loop->last)
                                                                            @else,
                                                                            @endif
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <div>
                                                                Brand: {{ $data->product->brand_id }}
                                                            </div>

                                                            {{-- @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                                            @if (!empty($data->vendor_id))
                                                                <div>
                                                                    Vendor: {{ $data->vendor->brand_name }}
                                                                </div>
                                                            @endif
                                                        @endif --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 6% !important;">
                                                <div>
                                                    Item ID:
                                                    @if (!empty($data->color))
                                                        <a href="{{ route('product.slug', ['slug' => $data->product->slug, 'color' => $data->color]) }}"
                                                            target="_blank">
                                                        @else
                                                            <a href="{{ route('product.slug', ['slug' => $data->product->slug]) }}"
                                                                target="_blank">
                                                    @endif
                                                    {{ $data->product_id }}
                                                    </a>
                                                </div>
                                                <div>
                                                    HSN: {{ $data->product->productsubcategory->hsn }}
                                                </div>
                                                <div>
                                                    Type: {{ $data->type }}
                                                </div>
                                            </td>
                                            <td style="width: 2% !important;">
                                                Qty: {{ $data->qty }}
                                            </td>
                                            @if (auth()->user()->hasRole('Client'))
                                                <td style="width: 10% !important;">
                                                    @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                                        @if (!empty($data->vendor_id))
                                                            <div>
                                                                <text>
                                                                    <span
                                                                        style="color: black; font-weight:700">Name</span>:
                                                                    {{ $data->vendor->name }}
                                                                </text>
                                                            </div>
                                                            <div>
                                                                <text class="text-ellipsis">
                                                                    <span
                                                                        style="color: black; font-weight:700">Brand</span>:
                                                                    {{ $data->vendor->brand_name }}
                                                                </text>
                                                            </div>
                                                            <div>
                                                                <text class="text-ellipsis">
                                                                    <span
                                                                        style="color: black; font-weight:700">Email</span>:
                                                                    {{ $data->vendor->email }}
                                                                </text>
                                                            </div>
                                                            <div>
                                                                <text class="text-ellipsis">
                                                                    <span
                                                                        style="color: black; font-weight:700">Address</span>:
                                                                    {{ $data->vendor->street_address_1 }}
                                                                    {{ $data->vendor->street_address_2 ?? '' }}
                                                                    {{ $data->vendor->city ?? '' }},
                                                                    {{ $data->vendor->state ?? '' }} -
                                                                    {{ $data->vendor->pincode ?? '' }}
                                                                </text>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    {{-- <div>
                                                    Type: {{$data->vendor }}
                                                </div> --}}
                                                </td>
                                            @endif

                                            <td style="width: 5% !important;">
                                                <div>
                                                    {{ Config::get('icrm.currency.icon') . ' ' . $data->product_offerprice }}
                                                </div>
                                                <div>{{ $data->order_method }}</div>
                                            </td>

                                            @if (auth()->user()->hasRole('Client') ||
                                                    (request('label') != 'New Order' &&
                                                        auth()->user()->hasRole('Vendor')))
                                                <td style="width: 10% !important;">
                                                    <div>
                                                        @if ($data->order_status == 'New Order')
                                                            <span style="color: green">Order Placed</span>
                                                        @elseif ($data->order_status == 'Under manufacturing')
                                                            <span
                                                                style="color: orange; font-weight:600; font-size:15px">{{ strtoupper($data->order_status) }}</span>
                                                        @elseif($data->order_status == 'Delivered' or $data->order_status == 'Scheduled for pickup')
                                                            <span
                                                                style="color: green; font-weight:600; font-size:15px">{{ strtoupper($data->order_status) }}</span>
                                                        @elseif($data->order_status == 'Cancelled')
                                                            <span
                                                                style="color: red; font-weight:600; font-size:15px">{{ strtoupper($data->order_status) }}</span>
                                                        @else
                                                            <span>{{ $data->order_status }}</span>
                                                        @endif
                                                    </div>

                                                    @if (!empty($data->order_substatus))
                                                        <div>
                                                            {{ $data->order_substatus }}
                                                        </div>
                                                    @endif

                                                    <div>
                                                        {{ $data->shipping_provider }}
                                                    </div>

                                                    @if (!empty($data->order_awb))
                                                        <div>
                                                            AWB:
                                                            <a
                                                                href="/{{ Config::get('icrm.admin_panel.prefix') }}/orders?order_awb={{ $data->order_awb }}">
                                                                {{ $data->order_awb }}
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if (!empty($data->shipping_id))
                                                        <div>
                                                            Shipping ID: {{ $data->shipping_id }}
                                                        </div>
                                                    @endif

                                                    @if (!empty($data->shipping_label))
                                                        <div>
                                                            <a href="{{ $data->shipping_label }}">
                                                                Shipping label
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if (Config::get('icrm.site_package.multi_vendor_store') == 0)
                                                        @if (!empty($data->tax_invoice))
                                                            <div>
                                                                <a href="{{ $data->tax_invoice }}">
                                                                    Tax invoice
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @if (!empty($data->manifest_url))
                                                        <div>
                                                            <a href="{{ $data->manifest_url }}">
                                                                Manifest
                                                            </a>
                                                        </div>
                                                    @endif


                                                    @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                                                        @if (!empty($data->order_awb))
                                                            <div>
                                                                <a href="javascript:void(0)"
                                                                    onclick="document.getElementById('downloadtaxinvoiceForm').submit()">
                                                                    Tax Invoice
                                                                </a>
                                                            </div>
                                                            <div style="display: none">
                                                                <a>
                                                                    <form action="{{ route('downloadtaxinvoice') }}" target="_blank"
                                                                        method="post" id="downloadtaxinvoiceForm">
                                                                        @csrf
                                                                        <input type="text" hidden name="order_awb"
                                                                            value="{{ $data->order_awb }}">
                                                                        {{-- <button type="submit" class="btn btn-sm btn-info">Tax
                                                                            Invoice</button> --}}
                                                                    </form>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endif

                                                </td>
                                            @endif

                                            @if (auth()->user()->hasRole('Client'))
                                                <td style="width: 10% !important;">
                                                    <div>
                                                        <strong style="color:black; font-weight: 700;">Name: </strong>
                                                        <text class="text-primary">{{ $data->customer_name }}</text>
                                                    </div>
                                                    <div>
                                                        <text class="text-ellipsis">
                                                            {{ $data->dropoff_streetaddress1 }}<br>
                                                        </text>
                                                        <text class="text-ellipsis">
                                                            {{ $data->dropoff_streetaddress2 }}<br>
                                                        </text>
                                                        <strong
                                                            style="color:black; font-weight: 700;">{{ $data->dropoff_city . ' - ' . $data->dropoff_state }}<br></strong>
                                                        <strong
                                                            style="color:black; font-weight: 700;">{{ $data->dropoff_country }}<br></strong>
                                                        <strong
                                                            style="color:black; font-weight: 700;">{{ $data->dropoff_pincode }}(Pincode)</strong>
                                                    </div>
                                                </td>
                                            @endif
                                            @if (auth()->user()->hasRole('Client'))
                                                <td style="width: 15% !important;">
                                                    <div>
                                                        <strong style="color:black; font-weight: 700;">Delivery
                                                            Date:
                                                        </strong>
                                                        <text
                                                            class="text-success">{{ $data->exp_delivery_date ? date('M d, Y', strtotime($data->exp_delivery_date)) : '-' }}</text>
                                                    </div>
                                                    <div>
                                                        <strong style="color:black; font-weight: 700;">Pickup Scheduled
                                                            Date:
                                                        </strong>
                                                        <text
                                                            class="text-primary">{{ $data->pickup_scheduled_date ? date('M d, Y', strtotime($data->pickup_scheduled_date)) : '-' }}</text>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">
                                    {{ trans_choice('voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total(),
                                    ]) }}
                                </div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                        's' => $search->value,
                                        'filter' => $search->filter,
                                        'key' => $search->key,
                                        'order_by' => $orderBy,
                                        'sort_order' => $sortOrder,
                                        'showSoftDeleted' => $showSoftDeleted,
                                    ])->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-gap: 0.5em;
            margin-bottom: 3em;
        }

        .product-information {
            display: grid;
            grid-template-columns: 0.15fr 1fr;
            grid-gap: 5px;
        }

        .product-information .info {
            display: grid;
            grid-template-columns: 1fr;
            grid-gap: 0px;
        }

        .product-information .info .name {
            color: blue;
        }

        .voyager .table tr td,
        .voyager .table tr th {
            border-right: 1px solid;
        }

        .text-ellipsis {
            width: 200px;
            white-space: nowrap;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sliding-btn-div {
            position: fixed;
            bottom: 11px;
            right: 15px;
            z-index: 1000;
            background: #c4e2ff;
            padding: 0px 6px;
            border-radius: 6px;
        }

        .sliding-btn-div .page-link {
            color: black;
            font-weight: 400;
        }

        .pagination>li {
            cursor: pointer;
        }
    </style>

    {{-- Single delete modal --}}
    {{-- <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div> --}}
@stop

@section('css')
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge(
                        [
                            'order' => $orderColumn,
                            'language' => __('voyager::datatable'),
                            'columnDefs' => [['targets' => 'dt-not-orderable', 'searchable' => false, 'orderable' => false]],
                        ],
                        config('voyager.dashboard.data_tables', []),
                    ),
                    true,
                ) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function() {
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function(e) {
            $('#delete_form')[0].action = '{{ route('voyager.' . $dataType->slug . '.destroy', '__id') }}'
                .replace(
                    '__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if ($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before(
                            '<a id="redir" href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 1]), true) }}"></a>'
                        );
                    } else {
                        $('#dataTable').before(
                            '<a id="redir" href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 0]), true) }}"></a>'
                        );
                    }

                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function() {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });
    </script>

    {{-- <script>
        $("#right-button").click(function() {
            event.preventDefault();
            $(".table-responsive").animate({
                    scrollLeft: "+=500px"
                },
                "slow"
            );
        });

        $("#left-button").click(function() {
            event.preventDefault();
            $(".table-responsive").animate({
                    scrollLeft: "-=500px"
                },
                "slow"
            );
        });
    </script> --}}
@stop
