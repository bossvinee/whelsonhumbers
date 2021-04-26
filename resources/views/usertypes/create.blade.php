@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header pb-0">
            <h4>Create new job title</h4>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form method="POST" action="{{ route('usertypes.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label"
                        >User type : </label
                    >
                    <div class="col-sm-8">
                        <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" placeholder="e.g Salaried" required="" />
                    </div>
                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong> {{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="col-sm-2">
                        <button class="btn waves-effect waves-light btn-sm btn-primary">new user type</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endsection