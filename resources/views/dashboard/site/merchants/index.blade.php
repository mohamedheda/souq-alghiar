@extends('dashboard.core.app')
@php
    use \Illuminate\Support\Facades\Gate;
@endphp
@section('title', __('dashboard.merchants'))
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@lang('dashboard.merchants')</h1>
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
                            <h3 class="card-title">@lang('dashboard.merchants')</h3>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>@lang('dashboard.Name')</th>
                                    <th>@lang('dashboard.Email')</th>
                                    <th style="width: 50px;">@lang('dashboard.Image')</th>
                                    <th>@lang('dashboard.Phone')</th>
                                    <th>@lang('dashboard.Operations')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->image !== null)
                                                <img src="{{ url($user->image) }}" style="width: 50px;" />
                                            @endif
                                        </td>
                                        <td>{{ $user->phone }}</td>
                                        @if($user->canAddProduct)
                                            @permission('merchants-products-read')
                                            <td>
                                                <div class="operations-btns" style="">
                                                    <a href="{{ route('merchants.products', $user->id) }}"
                                                       class="btn  btn-dark">@lang('dashboard.products')</a>
                                                </div>
                                            </td>
                                            @endpermission
                                        @else
                                            <td>
                                                <small class="badge badge-danger"><i class="far fa-clock"></i> @lang('dashboard.not_subscribed')</small>
                                            </td>
                                        @endif

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
