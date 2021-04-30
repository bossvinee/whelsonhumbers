@extends('layouts.app')

@section('template_title')
    Bulk food distribution
@endsection

@section('template_linked_css')
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
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
                    <span class="pcoded-mtext"> Add Distribution</span>
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
                    <li class="breadcrumb-item">
                        <a href="{{ url('bulk-food-form') }}">Bulk Distribution</a>
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
                            <h4 style="margin-bottom:0">Bulk food distribution</h4>
                            <span>Please select either Department or Employee type allocation</span>
                        </div>
                        <div class="card-block" style="padding-top: 7px;margin-top:0;">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ url('/bulk-food-upload') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="select_type" class="col-sm-3 col-form-label"
                                        >Department or Employee type : </label
                                    >
                                    <div class="col-sm-9">
                                        <select name="select_type" class="form-control" id="select_type" style="width: 100%;" required="" autofocus>
                                            <option value="">Choose allocation type</option>
                                            <option value="department">Department</option>
                                            <option value="etype">Employee Type</option>
                                        </select>
                                    </div>
                                    @error('select_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="result" class="col-sm-3 col-form-label"
                                        >Select Result : </label
                                    >
                                    <div class="col-sm-9">
                                        <select name="result" class="form-control" id="result" style="width: 100%;" required="" autofocus>
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                    @error('result')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="month" class="col-sm-3 col-form-label"
                                        >Card Month : </label
                                    >
                                    <div class="col-sm-9">
                                        <select name="month" id="month" class="form-control" style="width: 100%;">
                                            <option value="">Select month of issue</option>
                                            <option value="January@php echo date('Y') @endphp">January@php echo date('Y') @endphp</option>
                                            <option value="February@php echo date('Y') @endphp">February@php echo date('Y') @endphp</option>
                                            <option value="March@php echo date('Y') @endphp">March@php echo date('Y') @endphp</option>
                                            <option value="April@php echo date('Y') @endphp">April@php echo date('Y') @endphp</option>
                                        </select>
                                    </div>
                                    @error('card_month')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="card_number" class="col-sm-3 col-form-label"
                                        >Card Number : </label
                                    >
                                    <div class="col-sm-9">
                                        <select name="card_number" id="card_number" class="form-control" style="width: 100%;">
                                            <option value="">Please select card number</option>
                                            @if ($jobcards)
                                                @foreach ($jobcards as $jobcard)
                                                    <option value="{{ $jobcard->card_number }}">{{ $jobcard->card_number }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('card_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="issue_date" class="col-sm-3 col-form-label"
                                        >Issue Date : </label
                                    >
                                    <div class="col-sm-9">
                                        <input type="date" name="issue_date" id="issue_date" class="form-control @error('issue_date') is-invalid @enderror">
                                    </div>
                                    @error('issue_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row justify-content-end">
                                    <div class="col-sm-3 mt-2">
                                        <button class="btn waves-effect btn-round waves-light btn-block btn-sm btn-success">Process Distribution</button>
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
<script src="{{ asset('dash_resource/js/jquery.datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/datatables.bootstrap4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/datatables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/extension-btns-custom.js') }}" type="text/javascript"></script>

<script src="{{ asset('select2/js/select2.min.js') }}"></script>
<script>
    $('#select_type').select2({
        placeholder: 'Please select allocation type.',
    }).change(function(){
        var department = $(this).val();
        var _token = $("input[name='_token']").val();
        if(department){
            $.ajax({
                type:"get",
                url:"{{url('/department-users')}}/"+department,
                _token: _token ,
                success:function(res) {
                    if(res) {
                        $("#result").empty();
                        $.each(res,function(key, value){
                            $("#result").append('<option value="'+value+'">'+value+'</option>');
                        });
                    }
                }

            });
        }
    });

</script>
<script>
    $(document).ready(function() {
        $('#result').select2({
            placeholder:'Please select result.',
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#month').select2({
            placeholder:'Please select month.',
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#card_number').select2({
            placeholder:'Please select job card number.',
        });
    });
</script>

@endsection
