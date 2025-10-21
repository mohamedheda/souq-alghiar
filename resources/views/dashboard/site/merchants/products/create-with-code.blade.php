@extends('dashboard.core.app')
@section('title', __('dashboard.Create') . ' ' . __('dashboard.products'))

@section('css_addons')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.products')</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('merchants-products.storeWithCode') }}" method="post" autocomplete="off"
                              enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.Create') @lang('dashboard.products')</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <input hidden="" name="user_id" value="{{$id}}">
                                {{-- General Info --}}
                                <div class="card card-primary">
                                    <div class="card-header"><h3 class="card-title">@lang('dashboard.general_info')</h3></div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>@lang('dashboard.price')</label>
                                            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('dashboard.description')</label>
                                            <textarea name="code" class="form-control">{{ old('code') }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-dark">@lang('dashboard.Create')</button>
                    </div>
                    </form>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js_addons')

@endsection
