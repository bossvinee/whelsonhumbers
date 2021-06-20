@extends('layouts.app')

@section('template_linked_css')
<link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
@endsection

@section('template_title')
Edit Meat distribution for {{ $distribution->paynumber}} - {{ $distribution->name }}
@endsection

@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Meat Distribution</h5>
                    <span class="pcoded-mtext"> Edit meat distribution for {{ $distribution->paynumber }} - {{ $distribution->name }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="feather icon-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('mdistributions') }}">Meat Distribution</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('mdistributions/create') }}">Add New</a>
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
                                <h4 style="font-size:18px;">Edit meat distribution <span class="float-right"><a
                                            href="{{ url('mdistributions') }}"
                                            class="btn d-inline btn-sm btn-light btn-light waves-light btn-round">Back
                                            to Mdistributions</a></span></h4>
                            </div>
                            <div class="card-block" style="padding-top: 0;margin-top:0;">
                                <h4 class="sub-title"></h4>
                                <form method="POST" action="{{ route('mdistributions.store') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="paynumber" class="col-sm-2 col-form-label">Pay Number : </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="paynumber" class="form-control" id="paynumber" value="{{ $distribution->paynumber }}">
                                        </div>
                                        @error('paynumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="department" class="col-sm-2 col-form-label">Department : </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="department" id="department" value="{{ $distribution->department }}"
                                                class="form-control @error('department') is-invalid @enderror"
                                                placeholder="e.g Accounts" required="" />
                                        </div>
                                        @error('department')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="card_number" class="col-sm-2 col-form-label">Job card number :
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="card_number" value="{{ $distribution->card_number }}" id="card_number">

                                        </div>
                                        @error('card_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name : </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" id="username" value="{{ $distribution->name }}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="e.g Simon" required="" />
                                        </div>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="issue_date" class="col-sm-2 col-form-label">Issue Date : </label>
                                        <div class="col-sm-10">
                                            <input type="date" name="issue_date" id="issue_date" value="{{ $distribution->issue_date }}" class="form-control @error('issue_date') is-invalid @enderror" required="" />
                                        </div>
                                        @error('issue_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="allocation" class="col-sm-2 col-form-label">Allocation : </label>
                                        <div class="col-sm-10">
                                            <select name="allocation" id="allocation" class="form-control"
                                                style="width: 100%;">
                                                <option value="">Please select allocation</option>
                                            </select>
                                        </div>
                                        @error('allocation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row justify-content-end">
                                        <button
                                            class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">create
                                            issue</button>
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
<script src="{{ asset('select2/js/select2.min.js') }}"></script>
<script>
    $('#paynumber').select2({

        var paynumber = $(this).val();
        var _token = $("input[name='_token']").val();
        if(paynumber){
        $.ajax({
        type:"get",
        url:"/get-meat-allocation/"+paynumber,
        _token: _token ,
        success:function(res) {
        if(res) {
        $("#allocation").empty();
        $.each(res,function(key, value){
        $("#allocation").append('<option value="'+value+'">'+value+'</option>');
        });
        }
        }

        });
        }

        });
</script>
<script>
    $(document).ready(function() {
        $('#allocation').select2({
            placeholder:'Please select allocation'
        });
    });
</script>
@endsection
