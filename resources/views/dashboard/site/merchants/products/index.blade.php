@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.products'))
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
                        <div class="card-header">
                            <h3 class="card-title">@lang('dashboard.products')</h3>
                            @permission('merchants-products-create')
                            <div class="card-tools">
                                    <a href="{{ route('merchants-products.create',$id) }}"
                                       class="btn  btn-dark">@lang('dashboard.Create')</a>
                                </div>
                                <div class="card-tools mx-3">
                                    <a href="{{ route('merchants-products.createWithCode',$id) }}"
                                       class="btn  btn-dark">@lang('dashboard.CreateWithCode')</a>
                                </div>
                            @endpermission
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th style="width: 50px;">@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>
                                            @if ($product->mainImage?->image !== null)
                                                <img src="{{ asset($product->mainImage?->image) }}" style="width: 100px;" />
                                            @endif
                                        </td>
                                        <td></td>
                                    </tr>
                                @empty
                                    @include('dashboard.core.includes.no-entries', ['columns' => 5])
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        </div>
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
