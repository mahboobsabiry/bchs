@extends('layouts.admin.master')
<!-- Title -->
@section('title', trans('global.add') . ' ' . trans('global.new'))
<!-- Extra Styles -->
@section('extra_css')

@endsection
<!--/==/ End of Extra Styles -->

<!-- Main Content of The Page -->
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <!-- Breadcrumb -->
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">@lang('pages.exitDoor.exitDoor')</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin.dashboard.dashboard')</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.exit-door.index') }}">@lang('pages.exitDoor.exitDoor')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('global.add')</li>
                </ol>
            </div>

            <!-- Btn List -->
            <div class="btn btn-list">
                <!-- Back -->
                <a class="btn btn-orange btn-sm btn-with-icon" href="{{ url()->previous() }}">
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
                                <h6 class="card-title mb-1">@lang('global.add')</h6>
                                <p class="text-muted card-sub-title">You can add new record here.</p>
                            </div>

                            <!-- Form -->
                            <form method="post" action="{{ route('admin.exit-door.store') }}" data-parsley-validate="">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Exit Type -->
                                        <div class="form-group @error('exit_type') has-danger @enderror">
                                            <p class="mb-2">@lang('pages.exitDoor.exitType'): <span class="tx-danger">*</span></p>

                                            <select id="exit_type" name="exit_type" class="form-control @error('exit_type') form-control-danger @enderror">
                                                <option value="0" id="transitOption">@lang('pages.exitDoor.transitGoods')</option>
                                                <option value="1" id="exportOption">@lang('pages.exitDoor.exportGoods')</option>
                                                <option value="2" id="emptyOption">@lang('pages.exitDoor.emptyVehicles')</option>
                                                <option value="3" id="rejectedOption">@lang('pages.exitDoor.rejectedGoods')</option>
                                            </select>

                                            @error('exit_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Exit Type -->

                                        <!-- Company Name -->
                                        <div class="form-group @error('company_name') has-danger @enderror">
                                            <p class="mb-2">@lang('pages.exitDoor.cName'): <span class="tx-danger">*</span></p>
                                            <input type="text" id="company_name" class="form-control @error('company_name') form-control-danger @enderror" name="company_name" value="{{ old('company_name') }}" placeholder="@lang('pages.exitDoor.cName')" required>

                                            @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Company Name -->

                                        <!-- Vehicle Plate & Trailer Number -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Vehicle Plate Number -->
                                                <div class="form-group @error('vp_number') has-danger @enderror">
                                                    <p class="mb-2">@lang('pages.exitDoor.vpNumber'): <span class="tx-danger">*</span></p>

                                                    <input type="text" id="vp_number" class="form-control @error('vp_number') form-control-danger @enderror" name="vp_number" value="{{ old('vp_number') }}" placeholder="@lang('pages.exitDoor.vpNumber')" required>

                                                    @error('vp_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Vehicle Plate Number -->
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Vehicle Trailer Plate Number -->
                                                <div class="form-group @error('vpt_number') has-danger @enderror">
                                                    <p class="mb-2">@lang('pages.exitDoor.vptNumber'):</p>

                                                    <input type="text" id="vpt_number" class="form-control @error('vpt_number') form-control-danger @enderror" name="vpt_number" value="{{ old('vpt_number') }}" placeholder="@lang('pages.exitDoor.vptNumber')">

                                                    @error('vpt_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Vehicle Trailer Plate Number -->
                                            </div>
                                        </div>
                                        <!--/==/ End of Vehicle Plate & Trailer Number -->

                                        <!-- ENEX -->
                                        <div class="form-group @error('enex') has-danger @enderror" id="enexDiv">
                                            <p class="mb-2">EN-EX: <span class="tx-danger">*</span></p>

                                            <input type="number" id="enex" class="form-control @error('enex') form-control-danger @enderror" name="enex" value="{{ old('enex') }}" placeholder="EN-EX*">

                                            @error('enex')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of ENEX -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Good Name && Weight -->
                                        <div class="row" id="goodNameWeight">
                                            <div class="col-md-6">
                                                <!-- Good Name -->
                                                <div class="form-group @error('good_name') has-danger @enderror" id="goodName">
                                                    <p class="mb-2">@lang('pages.exitDoor.goodName'): <span class="tx-danger">*</span></p>

                                                    <input type="text" id="good_name" class="form-control @error('good_name') form-control-danger @enderror" name="good_name" value="{{ old('good_name') }}" placeholder="@lang('pages.exitDoor.goodName')">

                                                    @error('good_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Good Name -->
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Weight -->
                                                <div class="form-group @error('weight') has-danger @enderror" id="weightKg">
                                                    <p class="mb-2">@lang('pages.exitDoor.weightKg'): <span class="tx-danger">*</span></p>

                                                    <input type="number" id="weight" class="form-control @error('weight') form-control-danger @enderror" name="weight" value="{{ old('weight') }}" placeholder="@lang('pages.exitDoor.weightKg')">

                                                    @error('weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Weight -->
                                            </div>
                                        </div>
                                        <!--/==/ End of Good Name && Weight -->

                                        <!-- Box Total && Box Total Text -->
                                        <div class="row" id="bxTotal">
                                            <div class="col-md-6">
                                                <!-- Box Total -->
                                                <div class="form-group @error('bx_total') has-danger @enderror">
                                                    <p class="mb-2">@lang('pages.exitDoor.bxTotal'): <span class="tx-danger">*</span></p>

                                                    <input type="number" id="bx_total" class="form-control @error('bx_total') form-control-danger @enderror" name="bx_total" value="{{ old('bx_total') }}" placeholder="@lang('pages.exitDoor.bxTotal')">

                                                    @error('bx_total')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Box Total -->
                                            </div>

                                            <div class="col-md-6">
                                                <!-- Box Total Text -->
                                                <div class="form-group @error('bx_total_tx') has-danger @enderror">
                                                    <p class="mb-2">@lang('pages.exitDoor.bxTotalTx'): <span class="tx-danger">*</span></p>

                                                    <input type="text" id="bx_total_tx" class="form-control @error('bx_total_tx') form-control-danger @enderror" name="bx_total_tx" value="{{ old('bx_total_tx') }}" placeholder="@lang('pages.exitDoor.bxTotalTx')">

                                                    @error('bx_total_tx')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!--/==/ End of Box Total Text -->
                                            </div>
                                        </div>
                                        <!--/==/ End of Box Total && Box Total Text -->

                                        <!-- Description -->
                                        <div class="form-group @error('desc') has-danger @enderror">
                                            <p class="mb-2">@lang('form.description'):</p>
                                            <textarea name="desc" class="form-control @error('desc') form-control-danger @enderror" placeholder="@lang('form.description')">{{ old('desc') }}</textarea>

                                            @error('desc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--/==/ End of Description -->
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
    <!-- Form-elements js-->
    <script src="{{ asset('backend/assets/js/advanced-form-elements.js') }}"></script>

    <!-- Form-elements js-->
    <script src="{{ asset('backend/assets/js/form-elements.js') }}"></script>

    @include('admin.exit-door.inc.ce_scripts')
@endsection
<!--/==/ End of Extra Scripts -->
