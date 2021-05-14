@extends('layouts.app')

@section('content')
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card table-card">
                          <div class="card-header">
                            <h4>Monthly Summary for humbers collected </h4>
                          </div>
                          <div class="card-block p-b-0">
                            <div class="table-responsive">
                              <table class="table table-bordered table-hover m-b-0">
                                <thead>
                                  <tr>
                                    <th>Issue Date</th>
                                    <th>Quantity Ordered</th>
                                    <th>Job Card Number</th>
                                    <th>Extras / Previous</th>
                                    <th>Total</th>
                                    <th>Balance</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if($jobcards)
                                        @foreach ($jobcards as $card)
                                        <tr>
                                            <td>{{ $card->date_opened }}</td>
                                            <td>{{ $card->quantity }}</td>
                                            <td>{{ $card->card_number }}</td>
                                            <td>{{ $card->extras_previous }}</td>
                                            <td>{{ $card->extras_previous + $card->issued }}</td>
                                            <td>{{ $card->remaining }}</td>
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
