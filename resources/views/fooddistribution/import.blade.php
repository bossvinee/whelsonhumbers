@extends('layouts.app')

@section('template_title')
    Import Food Distribution
@endsection

@section('template_linked_css')
<link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
@endsection
@section('content')

<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Food Distribution</h5>
                    <span class="pcoded-mtext"> Import distribution from excel</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"
                        ><i class="feather icon-home"></i
                        ></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('fdistributions') }}">Food Distribution</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-header pb-0">
                            <h4 style="margin-bottom:0">Bulk Food Distribution</h4>
                            <span>Please upload .xlsx file or csv file using the format e.g </span>
                        </div>
                        <div class="card-block" style="padding-top: 7px;margin-top:0;">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ url('/food-import-send') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="distributor" class="col-sm-2 col-form-label"
                                        >Choose file : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="file" name="distributor" id="distributor" class="form-control">
                                    </div>
                                    @error('distributor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <div class="col-md-2 mt-4">
                                        <button type="submit" class="btn btn-block btn-sm btn-success btn-round">Upload</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')


@endsection
