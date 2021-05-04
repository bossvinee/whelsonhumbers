@extends('layouts.app')

@section('template_linked_css')

@endsection
@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Food Collection</h5>
                    <span class="pcoded-mtext"> Add New Collection</span>
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
                        <a href="{{ url('fdistributions') }}">Food Collection</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('fdistributions/create') }}">Add New Collection</a>
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
                            <h4 style="font-weight:18px;">New food collection <span class="float-right"><a href="{{ url('fdistributions') }}" class="btn d-inline btn-sm btn-light btn-light waves-light btn-round">Back to Fdistributions</a></span></h4>
                            <p><b>NB: </b> If the humber was collected by another person fill in collected by and ID number else leave blank. </p>
                        </div>
                        <div class="card-block" style="padding-top: 0;margin-top:0;">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ route('fcollection.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="paynumber" class="col-sm-2 col-form-label"
                                        >Pay Number : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ $distributor->paynumber }}" name="paynumber" id="paynumber">
                                    </div>
                                    @error('paynumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label"
                                        >Name : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $distributor->name }}" name="name" id="username" class="form-control @error('name') is-invalid @enderror" placeholder="e.g Accounts" required="" />
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="distribution" class="col-sm-2 col-form-label"
                                        >Month Distribution : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $distributor->allocation }}" name="distribution" class="form-control">
                                    </div>
                                    @error('distribution')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="date_collected" class="col-sm-2 col-form-label"
                                        >Date Collected : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="date" value="{{ $distributor->issue_date }}" name="date_collected" id="date_collected" class="form-control @error('date_collected') is-invalid @enderror" placeholder="e.g Accounts" required="" />
                                    </div>
                                    @error('date_collected')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="collected_by" class="col-sm-2 col-form-label"
                                        >Collected By: </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" name="collected_by" id="collected_by" class="form-control @error('collected_by') is-invalid @enderror" placeholder="e.g Vincent Marufu" />
                                    </div>
                                    @error('collected_by')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="id_number" class="col-sm-2 col-form-label"
                                        >ID Number : </label
                                    >
                                    <div class="col-sm-10">
                                        <input type="text" name="id_number" id="id_number" class="form-control @error('id_number') is-invalid @enderror" placeholder="e.g 63-3027241W07"  />
                                    </div>
                                    @error('id_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">Add Collection</button>
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
