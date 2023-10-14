@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop


@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>

        @if (auth()->user()->id == $dataTypeContent->id)
            {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' Profile' }}
        @else
            {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
        @endif
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                    {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-title">
                            <h4>Profile Information</h4>
                        </div>

                        <div class="panel-body">

                            @if (auth()->user()->hasRole(['Vendor']))
                                <div class="form-group">
                                    <label for="name">Seller ID</label>
                                    <input type="text" class="form-control" id="seller_id" name="seller_id" placeholder="{{ __('voyager::generic.name') }}"
                                        value="{{ old('seller_id', $dataTypeContent->id ?? '') }}" disabled readonly>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">{{ __('voyager::generic.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('voyager::generic.name') }}"
                                       value="{{ old('name', $dataTypeContent->name ?? '') }}" @if(auth()->user()->hasRole(['Vendor'])) readonly @endif>
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('voyager::generic.email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('voyager::generic.email') }}"
                                       value="{{ old('email', $dataTypeContent->email ?? '') }}" @if(auth()->user()->hasRole(['Vendor'])) readonly @endif>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <input type="radio" name="gender" value="Male" @if ($dataTypeContent->gender == 'Male') checked @endif> Male
                                <input type="radio" name="gender" value="Female" @if ($dataTypeContent->gender == 'Female') checked @endif> Female
                            </div>

                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile"
                                       value="{{ old('mobile', $dataTypeContent->mobile ?? '') }}" @if(auth()->user()->hasRole(['Vendor'])) readonly @endif>
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('voyager::generic.password') }}</label>
                                @if(isset($dataTypeContent->password))
                                    <br>
                                    <small>{{ __('voyager::profile.password_hint') }}</small>
                                @endif
                                <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password">
                            </div>

                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <label for="default_role">{{ __('voyager::profile.role_default') }}</label>
                                    @php
                                        $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                                        $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                        $options = $row->details;
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                                <div class="form-group">
                                    <label for="additional_roles">{{ __('voyager::profile.roles_additional') }}</label>
                                    @php
                                        $row     = $dataTypeRows->where('field', 'user_belongstomany_role_relationship')->first();
                                        $options = $row->details;
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                            @endcan
                            {{-- @php
                            if (isset($dataTypeContent->locale)) {
                                $selected_locale = $dataTypeContent->locale;
                            } else {
                                $selected_locale = config('app.locale', 'en');
                            }

                            @endphp
                            <div class="form-group">
                                <label for="locale">{{ __('voyager::generic.locale') }}</label>
                                <select class="form-control select2" id="locale" name="locale">
                                    @foreach (Voyager::getLocales() as $locale)
                                    <option value="{{ $locale }}"
                                    {{ ($locale == $selected_locale ? 'selected' : '') }}>{{ $locale }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        </div>


                    </div>

                    @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                    @if (auth()->user()->hasRole(['Vendor', 'Client', 'admin']))
                    <div class="panel panel-bordered">
                        <div class="panel-title">
                            <h4>Store Address</h4>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="street_address_1">Street Address 1</label>
                                <textarea type="text" class="form-control" id="street_address_1" name="street_address_1" placeholder="Street Address 1"
                                    cols="30" rows="2"
                                    @if(auth()->user()->hasRole(['Vendor']))
                                        @if (!empty($dataTypeContent->street_address_1))
                                            readonly
                                        @endif
                                    @endif
                                    >{{ old('street_address_1', $dataTypeContent->street_address_1 ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="street_address_2">Street Address 2</label>
                                <textarea type="text" class="form-control" id="street_address_2" name="street_address_2" placeholder="Street Address 2"

                                    cols="30" rows="2" @if(auth()->user()->hasRole(['Vendor']))
                                        @if (!empty($dataTypeContent->street_address_2))
                                            readonly
                                        @endif
                                    @endif>{{ old('street_address_2', $dataTypeContent->street_address_2 ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="landmark">Landmark</label>
                                <textarea type="text" class="form-control" id="landmark" name="landmark" placeholder="Landmark"
                                    cols="30" rows="2"

                                    @if(auth()->user()->hasRole(['Vendor']))
                                        @if (!empty($dataTypeContent->landmark))
                                            readonly
                                        @endif
                                    @endif

                                    >{{ old('landmark', $dataTypeContent->landmark ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode"
                                       value="{{ old('pincode', $dataTypeContent->pincode ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->pincode))
                                                readonly
                                            @endif
                                        @endif

                                       >
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="City"
                                       value="{{ old('city', $dataTypeContent->city ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->city))
                                                readonly
                                            @endif
                                        @endif

                                       >
                            </div>

                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="State"
                                       value="{{ old('state', $dataTypeContent->state ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->state))
                                                readonly
                                            @endif
                                        @endif

                                       >
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" placeholder="Country"
                                       value="{{ old('country', $dataTypeContent->country ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->country))
                                                readonly
                                            @endif
                                        @endif

                                       >
                            </div>

                        </div>
                    </div>
                    @endif
                    @endif

                    @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                    @if (auth()->user()->hasRole(['Vendor', 'Client', 'admin']))
                    <div class="panel panel-bordered">
                        <div class="panel-title">
                            <h4>More Information</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="brands">Which all brands you will be sellng? (Brand Name)</label>
                                <textarea type="text" class="form-control" id="brands" name="brands" placeholder="Brand Name"
                                    cols="30" rows="2"
                                    @if(auth()->user()->hasRole(['Vendor']))
                                        @if (!empty($dataTypeContent->brands))
                                            readonly
                                        @endif
                                    @endif
                                    >{{ old('brands', $dataTypeContent->brands ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="brands">Brand Description</label>
                                <textarea type="text" class="form-control" name="brand_description" placeholder="Brand Description"
                                    cols="30" rows="2"
                                    {{-- @if(auth()->user()->hasRole(['Vendor']))
                                        @if (!empty($dataTypeContent->brands))
                                            readonly
                                        @endif
                                    @endif --}}
                                    >{{ old('brand_description', $dataTypeContent->brand_description ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="brands">Brand Background Color</label>
                                <input type="color" style="width: 20%" class="form-control" name="brand_bg_color" placeholder="Brand Background Color"
                                    value="{{ old('brand_bg_color', $dataTypeContent->brand_bg_color ?? '') }}">
                            </div>
                            <div class="form-group">
                                @if(isset($dataTypeContent->brand_logo))
                                    <img src="{{ filter_var($dataTypeContent->brand_logo, FILTER_VALIDATE_URL) ? $dataTypeContent->brand_logo : Voyager::image( $dataTypeContent->brand_logo ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="brand_logo" name="brand_logo">
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">

                            <div class="form-group">
                                @if(isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="avatar" name="avatar">
                            </div>



                            @if (Config::get('icrm.showcase_at_home.feature') == 1)
                                @if (auth()->user()->hasRole(['admin', 'Client', 'Vendor']))
                                    @php
                                        // check status of service in this city
                                        $deliveryservicablearea = App\DeliveryServicableArea::where('status', 1)->where('city', ucwords($dataTypeContent->city))->first();
                                    @endphp

                                    @isset($deliveryservicablearea)
                                        @if (!empty($deliveryservicablearea))

                                            @if (ucfirst(strtolower(trans($deliveryservicablearea->city))) == ucfirst(strtolower(trans($dataTypeContent->city))))
                                                <div class="form-group">
                                                    <label for="showcase_at_home">Showroom At Home</label><br>
                                                    <?php $checked = false; ?>
                                                    @if(isset($dataTypeContent->showcase_at_home) || old('showcase_at_home'))
                                                        <?php $checked = old('showcase_at_home', $dataTypeContent->showcase_at_home); ?>
                                                    @else
                                                        <?php $checked = isset($options->checked) &&
                                                            filter_var($options->checked, FILTER_VALIDATE_BOOLEAN) ? true: false; ?>
                                                    @endif

                                                    <?php $class = $options->class ?? "toggleswitch"; ?>

                                                    @if(isset($options->on) && isset($options->off))
                                                        <input type="checkbox" name="showcase_at_home" class="{{ $class }}"
                                                            data-on="{{ $options->on }}" {!! $checked ? 'checked="checked"' : '' !!}
                                                            data-off="{{ $options->off }}">
                                                    @else
                                                        <input type="checkbox" name="showcase_at_home" class="{{ $class }}"
                                                            @if($checked) checked @endif>
                                                    @endif

                                                </div>
                                            @endif
                                        @endif
                                    @endisset


                                @endif
                            @endif

                            @if (auth()->user()->hasRole(['Client', 'admin']))
                                <div class="form-group">
                                    <label for="brands">Store Rating</label>
                                    <input type="number" step="0.01" style="width: 50%" class="form-control" name="brand_store_rating" placeholder="4.6"
                                        value="{{ old('brand_store_rating', $dataTypeContent->brand_store_rating ?? '') }}">
                                </div>
                            @endif
                            @if (auth()->user()->hasRole(['Client', 'admin']))
                            <div class="form-group">
                                <label for="status">Status</label><br>
                                <?php $checked = false; ?>
                                @if(isset($dataTypeContent->status) || old('status'))
                                    <?php $checked = old('status', $dataTypeContent->status); ?>
                                @else
                                    <?php $checked = isset($options->checked) &&
                                        filter_var($options->checked, FILTER_VALIDATE_BOOLEAN) ? true: false; ?>
                                @endif

                                <?php $class = $options->class ?? "toggleswitch"; ?>

                                @if(isset($options->on) && isset($options->off))
                                    <input type="checkbox" name="status" class="{{ $class }}"
                                        data-on="{{ $options->on }}" {!! $checked ? 'checked="checked"' : '' !!}
                                        data-off="{{ $options->off }}">
                                @else
                                    <input type="checkbox" name="status" class="{{ $class }}"
                                        @if($checked) checked @endif>
                                @endif

                            </div>
                            @else
                                <input type="checkbox" name="status" @if($dataTypeContent->status == 1) checked @endif hidden>
                            @endif

                        </div>
                    </div>

                    @if (auth()->user()->hasRole(['Vendor', 'Client', 'admin']))
                    <div class="panel panel-bordered">
                        <div class="panel-title">
                            <h4>Company Information</h4>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="brand_name">Display Name</label>
                                <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Brand Name"
                                       value="{{ old('brand_name', $dataTypeContent->brand_name ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->brand_name))
                                                readonly
                                            @endif
                                        @endif

                                       >
                            </div>

                            <div class="form-group">
                                <label for="company_name">Registered Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name"
                                       value="{{ old('company_name', $dataTypeContent->company_name ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->company_name))
                                                readonly
                                            @endif
                                        @endif

                                       >
                            </div>

                            <div class="form-group">
                                <label for="gst_number">GST Number</label>
                                <input type="text" class="form-control" id="gst_number" name="gst_number" placeholder="GST Number"
                                       value="{{ old('gst_number', $dataTypeContent->gst_number ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->gst_number))
                                                readonly
                                            @endif
                                        @endif

                                       >
                            </div>


                            @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                            @if (auth()->user()->hasRole(['Vendor', 'Client', 'admin']))
                            <div class="form-group">
                                <label for="gst_certificate">GST Certificate</label><br>
                                @if(isset($dataTypeContent->gst_certificate))
                                    @if(json_decode($dataTypeContent->gst_certificate) !== null)
                                        @foreach(json_decode($dataTypeContent->gst_certificate) as $file)
                                        <div data-field-name="gst_certificate">
                                            <a class="fileType" target="_blank"
                                            href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                                            data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->getKey() }}">
                                            {{ $file->original_name ?: '' }}
                                            </a>
                                            <a href="#" class="voyager-x remove-multi-file"></a>
                                        </div>
                                        @endforeach
                                    @else
                                    <div data-field-name="gst_certificate">
                                        <a class="fileType" target="_blank"
                                        href="{{ Storage::disk(config('voyager.storage.disk'))->url($dataTypeContent->gst_certificate) }}"
                                        data-file-name="{{ $dataTypeContent->gst_certificate }}" data-id="{{ $dataTypeContent->getKey() }}">>
                                        Download
                                        </a>
                                        <a href="#" class="voyager-x remove-single-file"></a>
                                    </div>
                                    @endif
                                @endif
                                <input type="file" name="gst_certificate[]" multiple="multiple">
                            </div>

                            <div class="form-group">
                                <label for="company_pancard_number">Pancard Number</label>
                                <input type="text" class="form-control" id="company_pancard_number" name="company_pancard_number" placeholder="Pancard Number"
                                       value="{{ old('company_pancard_number', $dataTypeContent->company_pancard_number ?? '') }}"

                                       @if(auth()->user()->hasRole(['Vendor']))
                                            @if (!empty($dataTypeContent->company_pancard_number))
                                                readonly
                                            @endif
                                        @endif
                                       >
                            </div>

                            <div class="form-group">
                                <label for="company_pancard">Company Pancard</label><br>
                                @if(isset($dataTypeContent->company_pancard))
                                    @if(json_decode($dataTypeContent->company_pancard) !== null)
                                        @foreach(json_decode($dataTypeContent->company_pancard) as $file)
                                        <div data-field-name="company_pancard">
                                            <a class="fileType" target="_blank"
                                            href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                                            data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->getKey() }}">
                                            {{ $file->original_name ?: '' }}
                                            </a>
                                            <a href="#" class="voyager-x remove-multi-file"></a>
                                        </div>
                                        @endforeach
                                    @else
                                    <div data-field-name="company_pancard">
                                        <a class="fileType" target="_blank"
                                        href="{{ Storage::disk(config('voyager.storage.disk'))->url($dataTypeContent->company_pancard) }}"
                                        data-file-name="{{ $dataTypeContent->company_pancard }}" data-id="{{ $dataTypeContent->getKey() }}">>
                                        Download
                                        </a>
                                        <a href="#" class="voyager-x remove-single-file"></a>
                                    </div>
                                    @endif
                                @endif
                                <input type="file" name="company_pancard[]" multiple="false">
                            </div>
                            @endif
                            @endif


                            <div class="form-group">
                                <label for="signature">Signature</label><br>
                                @if(isset($dataTypeContent->signature))
                                    <img src="{{ filter_var($dataTypeContent->signature, FILTER_VALIDATE_URL) ? $dataTypeContent->signature : Voyager::image( $dataTypeContent->signature ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="signature" name="signature">
                            </div>


                        </div>
                    </div>
                    @endif

                    @if (Config::get('icrm.site_package.multi_vendor_store') == 1)
                        @if (auth()->user()->hasRole(['Vendor', 'Client', 'admin']))
                            <div class="panel panel-bordered">
                                <div class="panel-title">
                                    <h4>Bank Account Details</h4>
                                </div>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label for="bank_name">Bank Name</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name"
                                            value="{{ old('bank_name', $dataTypeContent->bank_name ?? '') }}"

                                            @if(auth()->user()->hasRole(['Vendor']))
                                                @if (!empty($dataTypeContent->bank_name))
                                                    readonly
                                                @endif
                                            @endif

                                            >
                                    </div>

                                    <div class="form-group">
                                        <label for="account_number">Account Number</label>
                                        <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number"
                                            value="{{ old('account_number', $dataTypeContent->account_number ?? '') }}"

                                            @if(auth()->user()->hasRole(['Vendor']))
                                                @if (!empty($dataTypeContent->account_number))
                                                    readonly
                                                @endif
                                            @endif

                                            >
                                    </div>

                                    <div class="form-group">
                                        <label for="ifsc_code">IFSC Code</label>
                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code"
                                            value="{{ old('ifsc_code', $dataTypeContent->ifsc_code ?? '') }}"

                                            @if(auth()->user()->hasRole(['Vendor']))
                                                @if (!empty($dataTypeContent->ifsc_code))
                                                    readonly
                                                @endif
                                            @endif

                                            >
                                    </div>

                                    <div class="form-group">
                                        <label for="bank_address">Bank Address</label>
                                        <textarea type="text" class="form-control" id="bank_address" name="bank_address" placeholder="Bank Address"
                                            cols="30" rows="2"

                                            @if(auth()->user()->hasRole(['Vendor']))
                                                @if (!empty($dataTypeContent->bank_address))
                                                    readonly
                                                @endif
                                            @endif

                                            >{{ old('bank_address', $dataTypeContent->bank_address ?? '') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="cancelled_check">Cancelled Check</label><br>
                                        @if(isset($dataTypeContent->cancelled_check))
                                            @if(json_decode($dataTypeContent->cancelled_check) !== null)
                                                @foreach(json_decode($dataTypeContent->cancelled_check) as $file)
                                                <div data-field-name="cancelled_check">
                                                    <a class="fileType" target="_blank"
                                                    href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                                                    data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->getKey() }}">
                                                    {{ $file->original_name ?: '' }}
                                                    </a>
                                                    <a href="#" class="voyager-x remove-multi-file"></a>
                                                </div>
                                                @endforeach
                                            @else
                                                <div data-field-name="cancelled_check">
                                                    <a class="fileType" target="_blank"
                                                    href="{{ Storage::disk(config('voyager.storage.disk'))->url($dataTypeContent->cancelled_check) }}"
                                                    data-file-name="{{ $dataTypeContent->cancelled_check }}" data-id="{{ $dataTypeContent->getKey() }}">>
                                                    Download
                                                    </a>
                                                    <a href="#" class="voyager-x remove-single-file"></a>
                                                </div>
                                            @endif
                                        @endif
                                        <input type="file" name="cancelled_check[]" multiple="multiple">
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save">
                {{ __('voyager::generic.save') }}
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
@stop
