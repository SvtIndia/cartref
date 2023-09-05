@php 
    $model = class_exists($row->details->model) ? app($row->details->model) : null;
    
    $errors = [];
    if (!class_exists($row->details->model)) $errors[] = $row->details->model;						// check error
    
    $selects = $row->details->dependent_dropdown;
    foreach ($selects as $class) { if (!class_exists($class->model)) $errors[] = $class->model; }	// check error
    
    $count = count($selects)+1;
    $css = ( $count == 2 ? 'col-md-6' : ( $count == 3 ? 'col-md-4' : 'col-md-3') );
@endphp

@if (!count($errors))	
    @php $query = $model::where('status', 1)->pluck($row->details->label, $row->details->key); @endphp
    <!-- // add first select -->
    <div class="{{ $css }}" style="padding: 10px;">
        <label for="{{$row->details->name}}">{{$row->details->display}}</label>
        <span class="required"></span>
        <select id="{{ $row->details->name }}" name="{{ $row->details->name }}" class="form-group select2 dependent-dropdown"
                data-route="{{ route($row->details->route) }}"
                data-params="{{ json_encode(['options' => $selects[0], 'model' => $selects[0]->model, 'where' => $selects[0]->where, 'value' => '__value']) }}"
                @if(isset($row->details->placeholder)){{'placeholder="$row->details->placeholder"'}}@endif>
            @if(isset($row->details->placeholder))
                <option value="0" selected="selected">{{ $row->details->placeholder }}</option>
            @endif	
            <!-- options -->
            @foreach($query as $key => $value)
                <option value="{{$key}}" {{ old('category_id') == $key ? "selected" : "" }}>{{$value}}</option>
            @endforeach
        </select>
    </div>
    
    <!-- // add second/three select -->
    @foreach ($selects as $key => $item)
        @php $next = ++$key; @endphp
        <div class="{{ $css }}" style="padding: 10px;">
        @if (isset($selects[$next]))
            <label for="{{$item->name}}">{{$item->display}}</label>
            <span class="required"></span>
            <select id="{{ $item->name }}" name="{{ $item->name }}" class="form-group select2 dependent-dropdown"
                    data-route="{{ route($row->details->route) }}"
                    data-params="{{ json_encode(['options' => $selects[$next], 'model' => $selects[$next]->model, 'where' => $selects[$next]->where, 'value' => '__value']) }}"
                    placeholder="{{$item->placeholder}}">
                @if(isset($item->placeholder))
                <option value="0" selected="selected">{{ $item->placeholder }}</option>
                @endif
            </select>
        @else
            {{-- if old subcategory_id exists then show subcategory according to that --}}
            @php
                if(!empty(old('subcategory_id')))
                {
                    $subcategory = App\ProductSubcategory::where('id', old('subcategory_id'))->first();
                }
            @endphp

            <label for="{{$item->name}}">{{$item->display}}</label>
            <span class="required"></span>
            <select id="{{$item->name}}" name="{{$item->name}}" class="form-group select2" placeholder="{{$item->placeholder}}">
                
                    @if (!empty(old('subcategory_id')))
                        <option value="{{ old('subcategory_id') }}">{{ $subcategory->name }}</option>
                    @else
                        @if(isset($item->placeholder))
                            <option value="0" selected="selected">{{ $item->placeholder }}</option>
                        @endif
                    @endif    
                
            </select>
        @endif
        </div>		
    @endforeach
@else
    @foreach($errors as $model)
        <span class="help-block danger">cannot make relationship because {{ $model }} does not exist.</span>
    @endforeach
@endif