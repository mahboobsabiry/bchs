@extends('layouts.admin.master')
<!-- Title -->
@section('title', config('app.name') . ' ~ ' . trans('pages.users.editUser'))
<!-- Extra Styles -->
@section('extra_css')
    <!---Fileupload css-->
    <link href="{{ asset('backend/assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet">
    <!---Fancy uploader css-->
    <link href="{{ asset('backend/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet">
    <!--Sumoselect css-->
    <link href="{{ asset('backend/assets/plugins/sumoselect/sumoselect.css') }}" rel="stylesheet">
@endsection
<!--/==/ End of Extra Styles -->

<!-- Main Content of The Page -->
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <!-- Breadcrumb -->
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">@lang('pages.users.editUser')</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard.dashboard')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">@lang('admin.sidebar.users')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user->id) }}">@lang('global.details')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('pages.users.editUser')</li>
                </ol>
            </div>

            <!-- Btn List -->
            <div class="btn btn-list">
                <!-- Back -->
                <a class="btn btn-orange btn-sm btn-with-icon" href="{{ route('admin.users.show', $user->id) }}">
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
                            <div>
                                <h6 class="card-title mb-1">@lang('pages.users.editUser')</h6>
                                <p class="text-muted card-sub-title">You can add new record here.</p>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{ route('admin.users.update', $user->id) }}" data-parsley-validate="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Name -->
                                        <div class="form-group @error('name') has-danger @enderror">
                                            <p class="mb-2">@lang('form.name'): <span class="tx-danger">*</span></p>
                                            <input type="text" id="name" class="form-control @error('name') form-control-danger @enderror" name="name" value="{{ $user->name ?? old('name') }}" placeholder="@lang('form.name')" required>

                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Name -->

                                        <!-- Phone Number -->
                                        <div class="form-group @error('phone') has-danger @enderror">
                                            <p class="mb-2">@lang('form.phone'):</p>
                                            <input type="text" id="phone" class="form-control @error('phone') form-control-danger @enderror" name="phone" value="{{ $user->phone ?? old('phone') }}" placeholder="@lang('form.phone')">

                                            @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Phone Number -->

                                        <!-- Email -->
                                        <div class="form-group @error('email') has-danger @enderror">
                                            <p class="mb-2">@lang('form.email'): <span class="tx-danger">*</span></p>
                                            <input type="email" id="email" class="form-control @error('email') form-control-danger @enderror" name="email" value="{{ $user->email ?? old('email') }}" placeholder="@lang('form.email')" required>

                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Email -->

                                        <!-- Status -->
                                        <div class="form-group @error('status') has-danger @enderror">
                                            <p class="mb-2">@lang('form.status'):</p>
                                            <select id="status" name="status" class="form-control">
                                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>@lang('global.active')</option>
                                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>@lang('global.inactive')</option>
                                            </select>

                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Status -->

                                        <!-- Information -->
                                        <div class="form-group @error('info') has-danger @enderror">
                                            <p class="mb-2">@lang('global.information'):</p>
                                            <textarea name="info" class="form-control @error('info') form-control-danger @enderror" placeholder="@lang('global.information')">{{ $user->info ?? old('info') }}</textarea>

                                            @error('info')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Information -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Avatar -->
                                        <div class="form-group @error('avatar') has-danger @enderror">
                                            <p class="mb-2">
                                                <!-- Delete Avatar -->
                                                <span class="caption">
                                                    <img src="{{ $user->image }}" class="img-fluid float-left" style="height: 30px;">
                                                </span>
                                                @lang('form.avatar'):
                                            </p>
                                            <p></p>
                                            <input type="file" class="dropify" name="avatar" accept="image/*" data-height="200" data-max-file="4M" data-show-errors="true" />
                                            @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Avatar -->

                                        <!-- Roles -->
                                        <div class="form-group @error('roles') has-danger @enderror">
                                            <p class="mb-2">
                                                @lang('admin.sidebar.roles'): <span class="tx-danger">*</span>
                                                <span class="btn btn-primary btn-sm deselect-all pl-1 pr-1" id="mybutton">@lang('global.deselectAll')</span>
                                                &nbsp;
                                                <span class="btn btn-success btn-sm select-all" id="mybutton">@lang('global.selectAll')</span>
                                            </p>
                                            <div class="selectgroup selectgroup-pills p-2" style="border: 1px solid gainsboro;">
                                                <div class="">
                                                    @foreach($roles as $role)
                                                        <label class="selectgroup-item checkboxes">
                                                            <input id="checkAll" type="checkbox" name="roles[]" value="{{ $role->id }}" class="selectgroup-input" @if($user) {{ $user->roles->contains($role->id) ? 'checked' : '' }} @endif>
                                                            <span class="selectgroup-button rounded-0 border-black">{{ $role->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!--/==/ End of Roles -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn ripple btn-primary rounded-2" type="submit">@lang('global.save')</button>
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

    <!--Sumoselect js-->
    <script src="{{ asset('backend/assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!-- Form-elements js-->
    <script src="{{ asset('backend/assets/js/advanced-form-elements.js') }}"></script>

    <!-- Form-elements js-->
    <script src="{{ asset('backend/assets/js/form-elements.js') }}"></script>
    <script>
        $('.select-all').click(function () {
            if($('input[type="checkbox"]').parents('.checkboxes')){
                $('input[type="checkbox"]').prop('checked', 'checked')
            }
        });

        $('.deselect-all').click(function () {
            if($('input[type="checkbox"]').parents('.checkboxes')){
                $('input[type="checkbox"]').prop('checked', '')
            }
        });
    </script>
@endsection
<!--/==/ End of Extra Scripts -->
