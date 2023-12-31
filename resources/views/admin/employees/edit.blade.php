@extends('layouts.admin.master')
<!-- Title -->
@section('title', config('app.name') . ' ~ ' . trans('pages.employees.editTitle'))
<!-- Extra Styles -->
@section('extra_css')
    <!---Fileupload css-->
    <link href="{{ asset('backend/assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet">
    <!---Fancy uploader css-->
    <link href="{{ asset('backend/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet">
    <!--Sumoselect css-->
    <link href="{{ asset('backend/assets/plugins/sumoselect/sumoselect.css') }}" rel="stylesheet">

    <!---Datetimepicker css-->
    <link href="{{ asset('backend/assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
@endsection
<!--/==/ End of Extra Styles -->

<!-- Main Content of The Page -->
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <!-- Breadcrumb -->
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">@lang('pages.employees.editTitle')</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard.dashboard')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">@lang('admin.sidebar.employees')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.employees.show', $employee->id) }}">@lang('global.details')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('pages.employees.editTitle')</li>
                </ol>
            </div>

            <!-- Btn List -->
            <div class="btn btn-list">
                <!-- Back -->
                <a class="btn btn-orange btn-sm btn-with-icon" href="{{ route('admin.employees.show', $employee->id) }}">
                    @lang('global.back')
                    <i class="fe fe-arrow-left"></i>
                </a>
            </div>
        </div>
        <!--/==/ End of Page Header -->

        <!-- Main Row -->
        <div class="row">
            <div class="col-lg-12">
                <!-- Card -->
                <div class="card custom-card overflow-hidden">
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="">
                            <!-- Errors Message -->
                            @include('admin.inc.alerts')

                            <!-- Form Title -->
                            <div class="mb-3">
                                <h6 class="card-title mb-1 tx-bold">
                                    @lang('pages.employees.editTitle')
                                </h6>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{ route('admin.employees.update', $employee->id) }}" data-parsley-validate="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Personal Information -->
                                        <p class="bd-b mb-2 tx-bold pb-2">
                                            <span class="badge badge-primary badge-pill">1</span>
                                            @lang('pages.employees.personalInfo')
                                        </p>

                                        <!-- Position && OnDuty -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Position -->
                                                <div class="form-group @error('position_id') has-danger @enderror">
                                                    <p class="mb-2">1) @lang('form.position'): <span class="tx-danger">*</span></p>

                                                    <select id="position_id" name="position_id" class="form-control select2 @error('position_id') form-control-danger @enderror">
                                                        <option label="Choose one">
                                                        </option>
                                                        @foreach($positions as $position)
                                                            <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>{{ $position->title }}</option>
                                                            @foreach($position->children as $admin)
                                                                <option value="{{ $admin->id }}" class="text-secondary" {{ $employee->position_id == $admin->id ? 'selected' : '' }}>- {{ $admin->title }}</option>
                                                                @foreach($admin->children as $mgmt)
                                                                    <option value="{{ $mgmt->id }}" {{ $employee->position_id == $mgmt->id ? 'selected' : '' }}>-- {{ $mgmt->title }}</option>
                                                                    @foreach($mgmt->children as $mgr)
                                                                        <option value="{{ $mgr->id }}" {{ $employee->position_id == $mgr->id ? 'selected' : '' }}>--- {{ $mgr->title }}</option>
                                                                    @endforeach
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                    </select>

                                                    @error('position_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Position -->
                                            </div>

                                            <!-- On Duty && Main Position -->
                                            <div class="col-md-6">
                                                <div class="form-group @error('main_position') has-danger @enderror">
                                                    <p class="mb-2 row" id="onDutyParent">1)
                                                        @lang('pages.employees.onDuty')
                                                        <span class="mr-2 ml-2">
                                                            <input type="checkbox" name="on_duty" id="onDutyCheck"
                                                                   class="custom-checkbox" {{ $employee->on_duty == 0 ? 'checked' : '' }}>
                                                        </span>

                                                        <span id="mpText" style="display: {{ $employee->on_duty == 0 ? 'block' : 'none' }};">@lang('pages.employees.mainPosition'):</span>
                                                    </p>
                                                    <select id="on_duty" name="main_position" class="form-control @error('main_position') form-control-danger @enderror" style="display: {{ $employee->on_duty == 0 ? 'block' : 'none' }};">
                                                        <option value="" selected>@lang('form.chooseOne')</option>
                                                        @foreach($positions as $position)
                                                            <option value="{{ $position->title }}" {{ $employee->main_position == $position->title ? 'selected' : '' }}>{{ $position->title }}</option>
                                                            @foreach($position->children as $admin)
                                                                <option value="{{ $admin->title }}" {{ $employee->main_position == $admin->title ? 'selected' : '' }} class="text-secondary">- {{ $admin->title }}</option>
                                                                @foreach($admin->children as $mgmt)
                                                                    <option value="{{ $mgmt->title }}" {{ $employee->main_position == $mgmt->title ? 'selected' : '' }}>-- {{ $mgmt->title }}</option>
                                                                    @foreach($mgmt->children as $mgr)
                                                                        <option value="{{ $mgr->title }}" {{ $employee->main_position == $mgr->title ? 'selected' : '' }}>--- {{ $mgr->title }}</option>
                                                                    @endforeach
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                    </select>

                                                    @error('main_position')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!--/==/ End of Position && OnDuty -->

                                        <!-- Name & Last Name -->
                                        <div class="row">
                                            <!-- Name -->
                                            <div class="col-md-6">
                                                <div class="form-group @error('name') has-danger @enderror">
                                                    <p class="mb-2">2) @lang('form.name'): <span class="tx-danger">*</span></p>
                                                    <input type="text" id="name" class="form-control @error('name') form-control-danger @enderror" name="name" value="{{ $employee->name ?? old('name') }}" placeholder="@lang('form.name')" required>

                                                    @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-md-6">
                                                <div class="form-group @error('last_name') has-danger @enderror">
                                                    <p class="mb-2">3) @lang('form.lastName'):</p>
                                                    <input type="text" id="last_name" class="form-control @error('last_name') form-control-danger @enderror" name="last_name" value="{{ $employee->last_name ?? old('last_name') }}" placeholder="@lang('form.lastName')">

                                                    @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!--/==/ End of Name & Last Name -->

                                        <!-- Father and Grand Father Name -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Father Name -->
                                                <div class="form-group @error('father_name') has-danger @enderror">
                                                    <p class="mb-2">4) @lang('form.fatherName'): <span class="tx-danger">*</span></p>
                                                    <input type="text" id="father_name" class="form-control @error('father_name') form-control-danger @enderror" name="father_name" value="{{ $employee->father_name ?? old('father_name') }}" placeholder="@lang('form.fatherName')" required>

                                                    @error('father_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Father Name -->
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Grand Father Name -->
                                                <div class="form-group @error('grand_f_name') has-danger @enderror">
                                                    <p class="mb-2">5) @lang('form.grandFatherName'): <span class="tx-danger">*</span></p>
                                                    <input type="text" id="grand_f_name" class="form-control @error('grand_f_name') form-control-danger @enderror" name="grand_f_name" value="{{ $employee->grand_f_name ?? old('grand_f_name') }}" placeholder="@lang('form.grandFatherName')" required>

                                                    @error('grand_f_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Grand Father Name -->
                                            </div>
                                        </div>
                                        <!--/==/ End of Father and Grand Father Name -->

                                        <!-- P2 Number and Employee Number -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- P2 Number -->
                                                <div class="form-group @error('p2number') has-danger @enderror">
                                                    <p class="mb-2">6) @lang('form.p2number'): <span class="tx-danger">*</span></p>
                                                    <input type="text" id="p2number" class="form-control @error('p2number') form-control-danger @enderror" name="p2number" value="{{ $employee->p2number ?? old('p2number') }}" placeholder="@lang('form.p2number')" required>

                                                    @error('p2number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of P2 Number -->
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Employee Number -->
                                                <div class="form-group @error('emp_number') has-danger @enderror">
                                                    <p class="mb-2">7) @lang('form.empNumber'): <span class="tx-danger">*</span></p>
                                                    <input type="number" id="emp_number" class="form-control @error('emp_number') form-control-danger @enderror" name="emp_number" value="{{ $employee->emp_number ?? old('emp_number') }}" placeholder="@lang('form.empNumber')" required>

                                                    @error('emp_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Employee Number -->
                                            </div>
                                        </div>
                                        <!--/==/ End of P2 Number and Employee Number -->
                                        <!--/==/ End of Personal Information -->

                                        <!-- General Information -->
                                        <p class="bd-b mb-2 tx-bold pb-2">
                                            <span class="badge badge-primary badge-pill">2</span>
                                            @lang('pages.employees.generalInfo')
                                        </p>

                                        <!-- Date of Birth and Email -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Date of Birth -->
                                                <p class="mb-2">8) @lang('form.dob') <span class="small tx-gray-600">(میلادی)</span>: <span class="tx-danger">*</span></p>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fe fe-calendar lh--9 op-6"></i>
                                                        </div>
                                                    </div>
                                                    <input name="dob" class="form-control fc-datepicker" type="text" value="{{ $employee->dob ?? old('dob') }}" placeholder="MM/DD/YYYY" required>

                                                    @error('dob')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Date of Birth -->
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Email Address -->
                                                <div class="form-group @error('email') has-danger @enderror">
                                                    <p class="mb-2">9) @lang('form.email'): <span class="tx-danger">*</span></p>
                                                    <input type="email" id="email" class="form-control @error('email') form-control-danger @enderror" name="email" value="{{ $employee->email ?? old('email') }}" placeholder="@lang('form.email')" required>

                                                    @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Email Address -->
                                            </div>
                                        </div>
                                        <!--/==/ End of Date of Birth and Email Address -->

                                        <!-- Phone Number -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Phone Number -->
                                                <div class="form-group @error('phone') has-danger @enderror">
                                                    <p class="mb-2">10) @lang('form.phone'): <span class="tx-danger">*</span></p>
                                                    <input type="text" id="phone" class="form-control @error('phone') form-control-danger @enderror" name="phone" value="{{ $employee->phone ?? old('phone') }}" placeholder="@lang('form.phone')" required>

                                                    @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Phone Number -->
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Phone Number 2 -->
                                                <div class="form-group @error('phone2') has-danger @enderror">
                                                    <p class="mb-2">11) @lang('form.phone') @lang('global.alternative'): </p>
                                                    <input type="text" id="phone2" class="form-control @error('phone2') form-control-danger @enderror" name="phone2" value="{{ $employee->phone2 ?? old('phone2') }}" placeholder="@lang('form.phone')">

                                                    @error('phone2')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Phone Number 2 -->
                                            </div>
                                        </div>
                                        <!--/==/ End of Phone Number -->

                                        <!-- Province -->
                                        <div class="form-group @error('province') has-danger @enderror">
                                            <p class="mb-2">12) @lang('form.province'): <span class="tx-danger">*</span></p>
                                            <input type="text" id="province" class="form-control @error('province') form-control-danger @enderror" name="province" value="{{ $employee->province ?? old('province') }}" placeholder="@lang('form.province')" required>

                                            @error('province')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Province -->

                                        <!--/==/ End of General Information -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Other Information -->
                                        <p class="bd-b mb-2 tx-bold pb-2">
                                            <span class="badge badge-primary badge-pill">3</span>
                                            @lang('pages.employees.otherInfo')
                                        </p>

                                        <!-- Photo -->
                                        <div class="form-group @error('photo') has-danger @enderror">
                                            <p class="mb-2">
                                                <!-- Photo -->
                                                <span class="caption">
                                                    <img src="{{ $employee->image }}" class="img-fluid float-left" style="height: 30px;">
                                                </span>
                                                13) @lang('form.photo'):
                                            </p>

                                            <input type="file" class="dropify" name="photo" accept="image/*" data-height="200" />
                                            @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Photo] -->

                                        <!-- Tazkira -->
                                        <div class="form-group @error('tazkira') has-danger @enderror">
                                            <p class="mb-2">
                                                <!-- Tazkira -->
                                                @if($employee->taz)
                                                    <span class="caption">
                                                        <img src="{{ $employee->taz }}" class="img-fluid float-left" style="height: 30px;">
                                                    </span>
                                                @endif
                                                14) @lang('form.idCard'): <br>
                                                <span class="caption bg-gray-300">نوت: اگر تذکره الکترونیکی دارید، آن را در یک فایل قرار داده و آپلود نمایید.</span>
                                            </p>

                                            <input type="file" class="dropify" name="tazkira" accept="image/*" data-height="200" />
                                            @error('tazkira')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Tazkira -->

                                        <!-- Information -->
                                        <div class="form-group @error('info') has-danger @enderror">
                                            <p class="mb-2">15) @lang('global.information'):</p>
                                            <textarea name="info" class="form-control @error('info') form-control-danger @enderror" placeholder="@lang('global.information')">{{ $employee->info ?? old('info') }}</textarea>

                                            @error('info')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Information -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn ripple btn-primary rounded-2" type="submit">@lang('global.update')</button>
                                </div>
                            </form>
                            <!--/==/ End of Form -->
                        </div>
                    </div>
                    <!--/==/ End of Card Body -->
                </div>
                <!--/==/ End of Card -->
            </div>
        </div>
        <!--/==/ End of Main Row -->
    </div>
@endsection
<!--/==/ End of Main Content of The Page -->

<!-- Extra Scripts -->
@section('extra_js')
    <!--Fileuploads js-->
    <script src="{{ asset('backend/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Fancy uploader js-->
    <script src="{{ asset('backend/assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!-- Form-elements js-->
    <script src="{{ asset('backend/assets/js/advanced-form-elements.js') }}"></script>

    <!-- Jquery-Ui js-->
    <script src="{{ asset('backend/assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Jquery.maskedinput js-->
    <script src="{{ asset('backend/assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!-- Datetimepicker js-->
    <script src="{{ asset('backend/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Simple-Datepicker js-->
    <script src="{{ asset('backend/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/pickerjs/picker.min.js') }}"></script>

    <!--Sumoselect js-->
    <script src="{{ asset('backend/assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!-- Form-elements js-->
    <script src="{{ asset('backend/assets/js/form-elements.js') }}"></script>

    <script>
        // Datepicker
        $('.fc-datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });

        // If On Duty Checkbox has been checked
        if($('input[type="checkbox"]').parents('#onDutyParent')){
            $('#onDutyCheck').change(function() {
                if (this.checked) {
                    $('#mpText').show();
                    $('#on_duty').show();
                } else {
                    $('#on_duty').val("0");
                    $('#on_duty').hide();
                    $('#mpText').hide();
                }
            })
        }
    </script>
@endsection
<!--/==/ End of Extra Scripts -->
