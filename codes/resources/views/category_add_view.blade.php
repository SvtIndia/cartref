@if(\Request::route()->getName() == 'voyager.collections.create' || \Request::route()->getName() == 'voyager.collections.edit' || 
    \Request::route()->getName() == 'voyager.homesliders.create' || \Request::route()->getName() == 'voyager.homesliders.edit')
    @if(isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field})))
        <?php $selected_value = old($row->field, $dataTypeContent->{$row->field}); ?>
    @else
        <?php $selected_value = old($row->field); ?>
    @endif
    <?php $default = 'Home' ?>

    <select class="form-control select2" name="category">
        <optgroup label="Category">
            <option value="Home" @if($default == 'Home' && $selected_value === NULL) selected="selected" @endif @if((string)$selected_value == (string)'Home') selected="selected" @endif>Home</option>

            <option value="Men" @if($default == 'Men' && $selected_value === NULL) selected="selected" @endif @if((string)$selected_value == (string)'Men') selected="selected" @endif>Men</option>
            <option value="Women" @if($default == 'Women' && $selected_value === NULL) selected="selected" @endif @if((string)$selected_value == (string)'Women') selected="selected" @endif>Women</option>
            <option value="kids" @if($default == 'kids' && $selected_value === NULL) selected="selected" @endif @if((string)$selected_value == (string)'kids') selected="selected" @endif>kids</option>

            @php
                $options = \App\ProductCategory::where('status', true)->get();
            @endphp
            @foreach($options as $option)
                <option value="{{ ($option->slug == '_empty_' ? '' : $option->slug) }}" @if($selected_value === NULL) selected="selected"     
                    @endif @if((string)$selected_value == (string)$option->slug) selected="selected" @endif>{{ $option->name }}</option>
            @endforeach
        </optgroup>
    </select>
@else
    {{ $content }}
@endif
