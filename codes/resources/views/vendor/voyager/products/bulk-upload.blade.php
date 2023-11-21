@extends('voyager::master')

@section('page_title', 'Bulk Upload')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-upload"></i> Bulk Upload
        </h1>
    </div>
@stop
@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <form role="form" class="form-edit-add" action="{{ route('products.bulk-upload') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="panel-body">
                            <div class="form-group col-md-4">
                                <label class="control-label" for="name">Category</label>
                                <span class="required"></span>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option selected disabled>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="name">Sub Category</label>
                                <span class="required"></span>
                                <select class="form-control" name="subcategory_id" id="subcategory_id" required>
                                    <option selected disabled>Select Category</option>
                                    {{--@foreach($sub_categories as $sub_category)
                                        <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="name">Upload File</label>
                                <span class="required"></span>
                                <input type="file" name="file" required/>
                            </div>
                        </div>
                        <!-- panel-body -->
                        <div class="panel-footer">
                            <button type="submit" id="submitbtn" class="btn btn-primary save">Upload</button>
                        </div>
                    </form>

                </div>
                <a href="{{ route('products.download-dummy') }}" download class="btn btn-warning btn-add-new">
                    <i class="voyager-cloud-download"></i> <span>Download Dummy File</span>
                </a>
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script>
        let categories = <?php echo json_encode($categories); ?>;

        $('#category_id').change(function () {
            let category_id = $(this).val();
            let category = categories.find(c => c.id == category_id)
            // console.log(category_id, categories, category);

            let options = [];
            options[0] = `<option selected disabled value="">Select Category</option>`
            category.subcategory.forEach(category => {
                options.push(`<option value="${category.id}">${category.name}</option>`)
            })
            // console.log(options);
            $('#subcategory_id').html(options);
        })
    </script>
@stop
