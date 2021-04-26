@extends('layouts.app')

@section('template_linked_css')
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header pb-0">
            <h4>New meet distribution</h4>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form method="POST" action="{{ route('mdistributions.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="department" class="col-sm-2 col-form-label"
                        >Department : </label
                    >
                    <div class="col-sm-10">
                        <input type="text" name="department" id="department" class="form-control @error('department') is-invalid @enderror" placeholder="e.g Accounts" required="" />
                    </div>
                    @error('department')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="paynumber" class="col-sm-2 col-form-label"
                        >Pay Number : </label
                    >
                    <div class="col-sm-10">
                        <select name="paynumber" id="paynumber" class="form-control" style="width: 100%;">
                            <option value="">Select pay number</option>
                            @if ($users)
                                @foreach ($users as $user)
                                    <option value="{{ $user->paynumber }}">( {{ $user->paynumber }} ) {{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @error('paynumber')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="card_number" class="col-sm-2 col-form-label"
                        >Job card number : </label
                    >
                    <div class="col-sm-10">
                        <select name="card_number" id="card_number" class="form-control">
                            <option value="">Please select card number</option>
                            @if ($jobcards)
                                @foreach ($jobcards as $jobcard)
                                    <option value="{{ $jobcard->card_number }}"> {{ $jobcard->card_number }}</option>
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
                    <label for="month" class="col-sm-2 col-form-label"
                        >Month : </label
                    >
                    <div class="col-sm-10">
                        <select name="month" id="month" class="form-control">
                            <option value="">Select month of issue</option>
                            <option value="jan">January</option>
                            <option value="feb">February</option>
                            <option value="mar">March</option>
                            <option value="apr">April</option>
                        </select>
                    </div>
                    @error('month')
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
                        <input type="text" name="name" id="username" class="form-control @error('name') is-invalid @enderror" placeholder="e.g Accounts" required="" />
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="issue_date" class="col-sm-2 col-form-label"
                        >Issue Date : </label
                    >
                    <div class="col-sm-10">
                        <input type="date" name="issue_date" id="issue_date" class="form-control @error('issue_date') is-invalid @enderror" placeholder="e.g Accounts" required="" />
                    </div>
                    @error('issue_date')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row justify-content-end">
                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">create issue</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script src="{{ asset('select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#paynumber').select2({
        placeholder:'select paynumber'
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
                        $("#username").empty();
                        $.each(res,function(key, value){

                            $("#username").val(value);
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
        }
    });

</script>
<script>
    $(document).ready(function() {
        $('#card_number').select2({
            placeholder:'please select card number'
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#month').select2({
            placeholder:'select month for distribution'
        });
    });
</script>
@endsection
