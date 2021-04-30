@extends('layouts.app')

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
                    <h5>Allocations</h5>
                    <span class="pcoded-mtext"> Add Allocation</span>
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
                        <a href="{{ url('allocations') }}">Allocations</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('allocations/create') }}">Bulk Allocation</a>
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
                            <h4 style="margin-bottom:0">Bulk Allocation</h4>
                            <span>Please select either Department or Employee type allocation</span>
                        </div>
                        <div class="card-block" style="padding-top: 7px;margin-top:0;">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ url('/bulk-allocate-send') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-5">
                                        <select name="select_type" class="form-control" id="select_type" style="width: 100%;" required="" autofocus>
                                            <option value="">Choose allocation type</option>
                                            <option value="department">Department</option>
                                            <option value="etype">Employee Type</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <select name="result" class="form-control" id="result" style="width: 100%;" required="" autofocus>
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn waves-effect btn-round waves-light btn-block btn-sm btn-success">Allocate</button>
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
    $('#result').select2();
</script>

@endsection
