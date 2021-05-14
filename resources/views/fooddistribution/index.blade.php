@extends('layouts.app')

@section('template_linked_css')
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/datatables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dash_resource/css/buttons.datatables.min.css') }}">
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
                            <h4 style="font-size:16px;margin-bottom:0;">Showing all humbers distributed</h4>
                        </div>
                        <div class="card-block">
                          <div class="dt-responsive table-responsive">
                            <table
                              id="basic-btn"
                              class="table table-bordered nowrap"
                            >
                              <thead>
                                <tr>
                                  <th>Folio</th>
                                  <th>Deparment</th>
                                  <th>Number</th>
                                  <th>Name</th>
                                  <th>Jobcard No:</th>
                                  <th>Issue Date</th>
                                  <th>Month</th>
                                  <th>Status</th>
                                  <th>Done By</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if ($fdists)
                                    @foreach ($fdists as $distribution )
                                        <tr>
                                            <td>{{ $distribution->id }}</td>
                                            <td>{{ $distribution->department }}</td>
                                            <td>{{ $distribution->paynumber }}</td>
                                            <td>{{ $distribution->name }}</td>
                                            <td>{{ $distribution->card_number }}</td>
                                            <td>{{ $distribution->issue_date }}</td>
                                            <td>{{ $distribution->allocation }}</td>
                                            <td>
                                                @if ($distribution->status == 'Not Collected')
                                                    @php
                                                        $badgeClass = 'warning'
                                                    @endphp
                                                @else
                                                    @php $badgeClass = 'success' @endphp
                                                @endif
                                                <span
                                                    class="badge badge-{{$badgeClass}}"
                                                    >{{ $distribution->status }}</span
                                                >
                                            </td>
                                            <td>{{ $distribution->done_by }}</td>
                                            <td style="white-space: nowrap;width:20%;">
                                                <a href="{{ url('add-collection/'.$distribution->id) }}" data-toggle="tooltip" title="Add to collection" class="d-inline btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                                <a href="" data-toggle="tooltip" title="Show Department" class="d-inline btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                                <button class="d-inline btn-sm btn btn-danger" data-toggle="tooltip" title="Delete Department"><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
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
<script src="{{ asset('dash_resource/js/datatables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/vfs_fonts-2.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/buttons.colvis.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/datatables.bootstrap4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/datatables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dash_resource/js/extension-btns-custom.js') }}" type="text/javascript"></script>

@endsection
