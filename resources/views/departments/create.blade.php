@extends('layouts.app')

@section('template_linked_css')
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header pb-0">
            <h4>Create New Department</h4>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="department" class="col-sm-2 col-form-label"
                        >Department Name : </label
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
                    <label for="manager" class="col-sm-2 col-form-label"
                        >Manager : </label
                    >
                    <div class="col-sm-10">
                        <select name="manager" id="manager" class="form-control">
                            <option value="">Please select department manager</option>
                            @if ($users)
                                @foreach ($users as $user)
                                    <option value="{{ $user->paynumber }}">( {{ $user->paynumber }} ) {{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @error('manager')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="assistant" class="col-sm-2 col-form-label"
                        >Assistant Manager : </label
                    >
                    <div class="col-sm-10">
                        <select name="assistant" id="assistant" class="form-control">
                            <option value="">Please select assistant manager</option>
                            @if ($users)
                                @foreach ($users as $user)
                                    <option value="{{ $user->paynumber }}">( {{ $user->paynumber }} ) {{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @error('assistant')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row justify-content-end">
                    <button class="btn waves-effect btn-round waves-light btn-sm mr-4 btn-primary">Create Department</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection

@section('footer_scripts')
<script src="{{ asset('select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#manager').select2({
            placeholder:'Please select department manager',
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#assistant').select2({
            placeholder:'Please select department assistant manager',
        });
    });
</script>
@endsection
