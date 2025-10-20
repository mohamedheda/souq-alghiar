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
                        <form action="{{ route('merchants-products.store') }}" method="post" autocomplete="off"
                              enctype="multipart/form-data">
                            <div class="card-header">
                                <h3 class="card-title">@lang('dashboard.Create') @lang('dashboard.product')</h3>
                            </div>
                            <div class="card-body">
                                @csrf
                                <input hidden="" name="user_id" value="{{$id}}">
                                {{-- General Info --}}
                                <div class="card card-primary">
                                    <div class="card-header"><h3 class="card-title">@lang('dashboard.general_info')</h3></div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>@lang('dashboard.name')</label>
                                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('dashboard.description')</label>
                                            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('dashboard.condition')</label>
                                            <select name="used" class="form-control" required>
                                                <option value="0">@lang('dashboard.new')</option>
                                                <option value="1">@lang('dashboard.used')</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('dashboard.price')</label>
                                            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('dashboard.category')</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="">@lang('dashboard.category')</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->t('name') }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>@lang('dashboard.subcategory')</label>
                                            <select name="sub_category_id" id="sub_category_id" class="form-control">
                                                <option value="">@lang('dashboard.subcategory')</option>
                                                {{-- Will be filled dynamically --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Brands --}}
                                <div class="card card-info">
                                    <div class="card-header"><h3 class="card-title">@lang('dashboard.brands_info')</h3></div>
                                    <div class="card-body">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" id="all_makes" type="radio" name="all_makes" value="1" checked>
                                            <label class="form-check-label" for="all_makes">@lang('dashboard.select_all')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" id="specific_makes" type="radio" name="all_makes" value="0">
                                            <label class="form-check-label" for="specific_makes">@lang('dashboard.select_specific')</label>
                                        </div>
                                        <div id="dropdown-wrapper">
                                        <div id="makes-wrapper" class="mt-3">
                                            <div class="row mb-2 make-item">
                                                <div class="col-md-3">
                                                    <select id="mark_id" name="makes[0][mark_id]" class="form-control model-select">
                                                        <option value="">@lang('Select Mark')</option>
                                                        @foreach ($marks as $mark)
                                                            <option value="{{ $mark->id }}">
                                                                {{ app()->getLocale() == 'ar' ? $mark->name_ar : $mark->name_en }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <select id="model_id" name="makes[0][model_id]" class="form-control model-select">
                                                        <option value="">@lang('Select Model')</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="makes[0][year_from]" class="form-control">
                                                        <option value="">@lang('dashboard.year_from')</option>
                                                        @for($y = date('Y'); $y >= 1950; $y--)
                                                            <option value="{{ $y }}">{{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="makes[0][year_to]" class="form-control">
                                                        <option value="">@lang('dashboard.year_to')</option>
                                                        @for($y = date('Y'); $y >= 1950; $y--)
                                                            <option value="{{ $y }}">{{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-make"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success" id="add-make">@lang('dashboard.add_brand')</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Images --}}
                                <div class="card card-secondary">
                                    <div class="card-header"><h3 class="card-title">@lang('dashboard.images')</h3></div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>@lang('dashboard.upload_images')</label>
                                            <input type="file" name="images[]" class="form-control" multiple required>
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
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
            $('.select2').select2({
                language: {
                    searching: function () {
                    }
                },
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            // 🔹 Show/Hide makes-wrapper based on radio selection
            $('input[name="all_makes"]').on('change', function () {
                if ($(this).val() == '0') {
                    $('#dropdown-wrapper').slideDown(); // show when select_specific
                } else {
                    $('#dropdown-wrapper').slideUp(); // hide when select_all
                }
            });

            // 🔹 Trigger once on page load to set the correct initial state
            $('input[name="all_makes"]:checked').trigger('change');


            // 🔹 Add new Make row
            $('#add-make').on('click', function () {
                const index = $('#makes-wrapper .make-item').length;

                const html = `
        <div class="row mb-2 make-item">
            <div class="col-md-3">
                <select name="makes[${index}][mark_id]" id="mark_id${index}" class="form-control mark-select">
                    <option value="">@lang('Select Mark')</option>
                    @foreach($marks as $mark)
                <option value="{{ $mark->id }}">
                        {{ app()->getLocale() == 'ar' ? $mark->name_ar : $mark->name_en }}
                </option>
@endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="makes[${index}][model_id]" id="model_id${index}" class="form-control model-select">
                    <option value="">@lang('Select Model')</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="makes[${index}][year_from]" class="form-control">
                    <option value="">@lang('From Year')</option>
                    @for ($year = date('Y'); $year >= 1950; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <select name="makes[${index}][year_to]" class="form-control">
                    <option value="">@lang('To Year')</option>
                    @for ($year = date('Y'); $year >= 1950; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-make"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;

                // ✅ Append new row correctly
                $('#makes-wrapper').append(html);

                // ✅ Attach mark→model logic for the new row only
                attachMarkModelHandler(index);
            });

            // 🔹 Remove a make row
            $(document).on('click', '.remove-make', function () {
                $(this).closest('.make-item').remove();
            });

        });

        // 🔹 Handle mark → model relationship dynamically
        function attachMarkModelHandler(index) {
            const markSelect = document.getElementById(`mark_id${index}`);
            const modelSelect = document.getElementById(`model_id${index}`);

            if (!markSelect || !modelSelect) return;

            markSelect.addEventListener('change', function() {
                const markId = this.value;
                modelSelect.innerHTML = '<option value="">@lang("Loading...")</option>';

                if (markId) {
                    fetch(`/api/v1/website/marks/${markId}`)
                        .then(res => res.json())
                        .then(data => {
                            modelSelect.innerHTML = '<option value="">@lang("Select Model")</option>';
                            data.data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.name;
                                modelSelect.appendChild(option);
                            });
                        })
                        .catch(() => {
                            modelSelect.innerHTML = '<option value="">@lang("Error loading models")</option>';
                        });
                } else {
                    modelSelect.innerHTML = '<option value="">@lang("Select Model")</option>';
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_id');
            const subCategorySelect = document.getElementById('sub_category_id');

            categorySelect.addEventListener('change', function () {
                const categoryId = this.value;

                // Clear existing options
                subCategorySelect.innerHTML = `<option value="">@lang('dashboard.subcategory')</option>`;

                if (!categoryId) return; // stop if no category selected

                fetch(`{{ url('/api/v1/website/category') }}?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.data.forEach(sub => {
                            const opt = document.createElement('option');
                            opt.value = sub.id;
                            opt.textContent = sub.name;
                            subCategorySelect.appendChild(opt);
                        });
                    })
                    .catch(err => {
                        console.error('Error fetching subcategories:', err);
                    });
            });


            // Handle Models based on Mark
            document.getElementById('mark_id').addEventListener('change', function() {
                const markId = this.value;
                const modelSelect = document.getElementById('model_id');
                modelSelect.innerHTML = '<option value="">@lang("Loading...")</option>';

                if (markId) {
                    fetch(`/api/v1/website/marks/${markId}`)
                        .then(res => res.json())
                        .then(data => {
                            modelSelect.innerHTML = '<option value="">@lang("Select Model")</option>';
                            data.data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.name;
                                modelSelect.appendChild(option);
                            });
                        });
                } else {
                    modelSelect.innerHTML = '<option value="">@lang("Select Model")</option>';
                }
            });
        });


    </script>
@endsection
