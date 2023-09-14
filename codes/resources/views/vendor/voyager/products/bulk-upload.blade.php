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
                    <form role="form" class="form-edit-add" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group col-md-4">
                                <label class="control-label" for="name">Upload File</label>
                                <span class="required"></span>
                                <input type="file" name="file" />
                            </div>
                        </div>
                        <!-- panel-body -->
                        <div class="panel-footer">
                            <button type="submit" id="submitbtn" class="btn btn-primary save">Upload</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
