@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div id="div-error" class="alert alert-danger d-none"></div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('admin.posts.store') }}" method="post"
                        id="form-create-post">
                        @csrf
                        <div class="form-group">
                            <label>Company</label>
                            <select class="form-control" name="company" id='select-company'></select>
                        </div>
                        <div class="form-group">
                            <label>Language</label>
                            <select class="form-control" multiple name="language" id='select-language'></select>
                        </div>
                        <div class="form-row select-location">
                            <div class="form-group col-6">
                                <label>City</label>
                                <select class="form-control" name="city" id='select-city'></select>
                            </div>
                            <div class="form-group col-6">
                                <label>District</label>
                                <select class="form-control" name="district" id='select-district'></select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label>Min Salary</label>
                                <input type="number" name="min_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Max Salary</label>
                                <input type="number" name="max_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Max Salary</label>
                                <select name="currency_salary" class="form-control">
                                    @foreach ($currencies as $currency => $value)
                                        <option value="{{ $value }}">
                                            {{ $currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Requirement</label>
                                <textarea class="form-control" style="width: 100%" name="requirement" id="text-requirement"></textarea>
                            </div>
                            <div class="form-group col-6">
                                {{--  <label>Number Applicants</label>
                                <input type="number" name="number_applicants" class="form-control">
                                <br>  --}}
                                {{--  <select name="remotable" class="form-control">  --}}
                                {{--  @foreach ($remotables as $key => $val)
                                        <option value="{{ $val }}">
                                            {{ __('frontpage.' . strtolower($key)) }}
                                        </option>
                                    @endforeach  --}}
                                {{--  </select>  --}}
                                {{--  <br>
                                <input type="checkbox" name="can_parttime" id="can_parttime" checked data-switch="info">
                                <label for="can_parttime" data-on-label="Can Part-time" data-off-label="No Part-time"></label>  --}}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" id="title">
                            </div>
                            <div class="form-group col-6">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" id="slug">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="modal-company" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create Company</h4>
                        <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="form-create-company" class="form-horizontal" action="{{ route('admin.companies.store') }}"
                              method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Company</label>
                                <input readonly name="name" id="company" class="form-control">
                            </div>
                            <div class="form-row select-location">
                                <div class="form-group col-4">
                                    <label>Country (*)</label>
                                    <select class="form-control" name="country" id='country'>
                                        {{--  @foreach($countries as $val => $name)
                                            <option value="{{ $val }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach  --}}
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>City (*)</label>
                                    <select class="form-control select-city" name="city" id='city'></select>
                                </div>
                                <div class="form-group col-4">
                                    <label>District</label>
                                    <select class="form-control select-district" name="district" id='district'></select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label>Address2</label>
                                    <input type="text" name="address2" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>Zipcode</label>
                                    <input type="number" name="zipcode" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label>Phone</label>
                                    <input type="number" name="phone" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="form-group col-6">
                                    <label>Logo</label>
                                    <input type="file" name="logo"
                                           oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                                    <img id="pic" height="100"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="submitForm('company')" class="btn btn-success">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div @endsection @push('js') <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script>
        function generateTitle() {
            const language = $("#select-language").val();
            let languages = [];
            const selectedLanguages = $("#select-language :selected").map(function(i, v) {
                languages.push($(v).text());
            });
            languages = languages.join(',');
            const city = $("#select-city").val();
            const company = $("#select-company").val();
            let title = `(${city}) ${languages}`;
            if (company) {
                title += ' - ' + company;
            }
            $("#title").val(title);
            generateSlug(title);
        }

        function generateSlug(title) {
            $.ajax({
                url: '{{ route('api.posts.slug.generate') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    title
                },
                success: function(response) {
                    $("#slug").val(response.data);
                    $("#slug").trigger("change");
                },
                error: function(response) {

                }
            });
        }
        async function loadDistrict() {
            //khi chọn quận mới thì xóa quận cũ đi
            $('#select-district').empty();
            const path = $("#select-city option:selected").data('path');
            const response = await fetch('{{ asset('locations/') }}' + path);
            const districts = await response.json();
            $.each(districts.district, function(index, each) {
                if (each.pre === 'Quận' || each.pre === 'Huyện') {
                    $("#select-district").append(`
                    <option>
                        ${each.name}
                    </option>`);
                }
            })
        }
        $(document).ready(async function() {
                $("#select-city").select2();
                const response = await fetch('{{ asset('locations/index.json') }}');
                const cities = await response.json();
                $.each(cities, function(index, each) {
                    $("#select-city").append(`
                <option data-path='${each.file_path}'>
                    ${index}
                </option>`)
                })
                $("#select-city").change(function() {
                    loadDistrict();
                });
                $('#select-district').select2();
                loadDistrict();

                $('#select-company').select2({
                    tags: true,
                    ajax: {
                        url: '{{ route('api.companies') }}',
                        data: function(params) {
                            const queryParameters = {
                                q: params.term
                            };
                            return queryParameters;
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data.data, function(item) {
                                    return {
                                        //  giá trị hiển thị ra 
                                        text: item.name,
                                        // giá trị thật khi mình chọn  
                                        id: item.name
                                    }
                                })
                            };
                        }
                    }
                })
                $("#select-language").select2({
                    ajax: {
                        url: '{{ route('api.languages') }}',
                        data: function(params) {
                            const queryParameters = {
                                q: params.term
                            };
                            return queryParameters;
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data.data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.name
                                    }
                                })
                            };
                        }
                    }
                });
                $(document).on('change', '#select-language, #select-company, #select-city', function() {
                    generateTitle();
                });
                $("#slug").change(function() {
                    $("#btn-submit").attr('disabled', true);
                    $.ajax({
                        url: '{{ route('api.posts.slug.check') }}',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            slug: $(this).val()
                        },
                        success: function(response) {
                            if (response.success) {
                                $("#btn-submit").attr('disabled', false);
                            }
                        }
                    });
                })
                $("#form-create-post").validate({
                    errorClass: 'invalid-feedback',
                    rules: {
                        company: {
                            required: true,
                        }
                    },
                    messages: {
                        company: {
                            required: "Tên công ty không được để trống"
                        },
                    },
                    submitHandler: function(form) {
                        checkCompany();
                    }
                });
                async function checkCompany() {
                    $.ajax({
                        url: '{{ route('api.companies.check') }}/' + $("#select-company").val(),
                        type: 'GET',
                        dataType: 'json',
                        success: async function(response) {
                            if (response.data) {
                                submitForm();
                            } else {
                                $("#modal-company").modal("show");
                                $("#company").val($("#select-company").val());
                                $("#city").val($("#select-city").val()).trigger('change');
                            }
                        }
                    });
                }

                function submitForm() {
                    $.ajax({
                        url: $("#form-create").attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        data: $("#form-create").serialize(),
                        success: function() {
                            $("#div-error").hide();
                        },
                        error: function(response) {
                            const errors = Object.values(response.responseJSON.errors);
                            let string = '<ul>';
                            errors.forEach(function(each) {
                                each.forEach(function(error) {
                                    string += `<li>${error}</li>`;
                                });
                            });
                            string += '</ul>';
                            $("#div-error").html(string);
                            $("#div-error").removeClass("d-none").show();
                        }
                    });
                }
            }

        );
    </script>
@endpush
