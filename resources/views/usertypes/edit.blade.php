@extends('layouts.app')

@section('content')
<div class="page-header card">
    <div class="row align-items-end">
        @include('partials.form-status')
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5>Employees</h5>
                    <span class="pcoded-mtext">Edit employee type</span>
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
                        <a href="{{ url('usertypes') }}">Category</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('usertypes/create') }}">Add New</a>
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
                            <h4 style="font-size: 18px;">Edit </h4>
                        </div>
                        <div class="card-block mt-0 pt-0">
                            <h4 class="sub-title"></h4>
                            <form method="POST" action="{{ route('usertypes.store') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="type" class="col-sm-2 col-form-label"
                                        >User type : </label
                                    >
                                    <div class="col-sm-8">
                                        <input type="text" value="{{ $usertype->type }}" name="type" id="type" class="form-control @error('type') is-invalid @enderror" placeholder="e.g Salaried" required="" autofocus />
                                    </div>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <div class="col-sm-2">
                                        <button class="btn waves-effect waves-light btn-sm btn-primary">Update type</button>
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
