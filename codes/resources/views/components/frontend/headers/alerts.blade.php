@if (Session::has('news'))
    <div class="alert alert-news alert-dark alert-round alert-inline">
        {{-- <h4 class="alert-title">News :</h4> --}}
        {!! Session::get('news') !!}
        <button type="button" class="btn btn-link btn-close">
            <i class="d-icon-times"></i>
        </button>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success alert-dark alert-round alert-inline">
        {{-- <h4 class="alert-title">Success :</h4> --}}
        {!! Session::get('success') !!}
        <button type="button" class="btn btn-link btn-close">
            <i class="d-icon-times"></i>
        </button>
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning alert-dark alert-round alert-inline">
        {{-- <h4 class="alert-title">Warning :</h4> --}}
        {!! Session::get('warning') !!}
        <button type="button" class="btn btn-link btn-close">
            <i class="d-icon-times"></i>
        </button>
    </div>
@endif

@if (Session::has('danger'))
    <div class="alert alert-danger alert-dark alert-round alert-inline">
        {{-- <h4 class="alert-title">Danger :</h4> --}}
        {!! Session::get('danger') !!}
        <button type="button" class="btn btn-link btn-close">
            <i class="d-icon-times"></i>
        </button>
    </div>
@endif

@if($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dark alert-round alert-inline">
        {{-- <h4 class="alert-title">Danger :</h4> --}}
        {{ $error }}
        <button type="button" class="btn btn-link btn-close">
            <i class="d-icon-times"></i>
        </button>
    </div>
    @endforeach
@endif