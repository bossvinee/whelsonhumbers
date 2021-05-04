@extends('layouts.app')

@section('template_linked_css')
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/buttons.datatables.min.css') }}">
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
                    <span class="pcoded-mtext"> Food humber distribution overview</span>
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
                        <a href="{{ url('fdistributions') }}">Fdistribution</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('fdistributions/create') }}">Add New</a>
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
                        <div class="card-header" style="margin-bottom: 0;padding-bottom:0;">
                            <h4 style="font-size:16px;margin-bottom:0;">Add New Distribution</h4>
                            <p>Select users to distribute , once finish click submit</p>
                        </div>
                        <div class="card-block">
                            <form action="{{ url('multi-insert-post') }}" method="POST" role="form" class="needs-validation">
                                @csrf
                                <div class="">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <th>Paynumber</th>
                                        <th>Jobcard</th>
                                        <th>Issue Date </th>
                                        <th>Department </th>
                                        <th>Name </th>
                                        <th>Allocation </th>
                                        <th><a href="javascript:;" class="btn btn-sm btn-info addRow">+</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="paynumber[]" id="paynumber" class="form-control" style="width: 100%;">
                                                    <option value="">Select Paynumber</option>
                                                    @if ($users)
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->paynumber }}">{{ $user->paynumber }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <select name="card_number[]" id="card_number" class="form-control" style="width: 100%;">
                                                    <option value="">Select Jobcard</option>
                                                    @if ($jobcards)
                                                        @foreach ($jobcards as $jobcard)
                                                            <option value="{{ $jobcard->card_number }}">{{ $jobcard->card_number }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td><input type="date" class="form-control" name="issue_date[]" id="issue_date"></td>
                                            <td><input type="text" class="form-control" name="department[]" id="department" ></td>
                                            <td><input type="text" class="form-control" name="name[]" id="name" ></td>
                                            <td>
                                                <select name="allocation[]" id="allocation" class="form-control" style="width: 100%;">
                                                    <option value="">Select Allocation</option>
                                                </select>
                                            </td>
                                            <td><a href="javascript:;" class="btn btn-sm btn-danger deleteRow">-</a></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                                <input type="submit" value="Submit">
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
<script>
    $('thead').on('click','.addRow',function(){
        var tr  = '<tr>'+
                    '<td>'+
                        '<select name="paynumber[]" id="paynumber" class="form-control" style="width: 100%;">'+
                            '<option value="">Select Paynumber</option>'+
                            '@if ($users)'+
                                '@foreach ($users as $user)'+
                                    '<option value="{{ $user->paynumber }}">{{ $user->paynumber }}</option>'+
                                '@endforeach'+
                            '@endif'+
                        '</select>'+
                    '</td>'+
                    '<td>'+
                        '<select name="card_number[]" id="card_number" class="form-control" style="width: 100%;">'+
                            '<option value="">Select Jobcard</option>'+
                            '@if ($jobcards)'+
                                '@foreach ($jobcards as $jobcard)'+
                                    '<option value="{{ $jobcard->card_number }}">{{ $jobcard->card_number }}</option>'+
                                '@endforeach'+
                            '@endif'+
                        '</select>'+
                    '</td>'+
                    '<td><input type="date" class="form-control" name="issue_date[]" id="issue_date"></td>'+
                    '<td><input type="text" class="form-control" name="department[]" id="department" ></td>'+
                    '<td><input type="text" class="form-control" name="name[]" id="name" ></td>'+
                    '<td>'+
                        '<select name="allocation[]" id="allocation" class="form-control" style="width: 100%;">'+
                            '<option value="">Select Allocation</option>'+
                        '</select>'+
                    '</td>'+
                    '<td><a href="javascript:;" class="btn btn-sm btn-danger deleteRow">-</a></td>'+
                '</tr>';
        $('tbody').append(tr);
    });

    $('tbody').on('click','.deleteRow', function(){
        $(this).parent().parent().remove();
    });


</script>
<script src="{{ asset('select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#paynumber').select2({
        placeholder:'select pay number'
    }).change(function(){
        var paynumber = $(this).val();
        var _token = $("input[name='_token']").val();
        if(paynumber){
            $.ajax({
                type:"get",
                url:"/getusername/"+paynumber,
                _token: _token ,
                success:function(res)
                {
                    if(res)
                    {
                        $("#name").empty();
                        $.each(res,function(key, value){

                            $("#name").val(value);
                        });

                    }
                }

            });

            $.ajax({
                type:"get",
                url:"/getdepartment/"+paynumber,
                _token: _token ,
                success:function(res)
                {
                    if(res)
                    {
                        $("#department").empty();
                        $.each(res,function(key, value){

                            $("#department").val(value);
                        });

                    }
                }

            });

            $.ajax({
                type:"get",
                url:"/get-allocation/"+paynumber,
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
        $('#card_number').select2({
            placeholder:'Card Number'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#allocation').select2({
            placeholder:'Select Allocation'
        });
    });
</script>
@endsection
