@section('title', 'Ticket Edit')
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Show Ticket <a href="{{ route('ticket.list')}}" class="btn btn-primary">Back</a></div>
                    <div class="card-body">
                        <div class="inner-box">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Title:</strong>
                                            {{ $ticket_data->title ?? '' }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                        <div class="form-group">
                                            <strong>Description:</strong>
                                            {{ $ticket_data->description ?? '' }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                        <div class="form-group">
                                            <strong>Status:</strong>
                                            {{ !empty($ticket_data->status) && $ticket_data->status == '1' ? 'Pending' : 'Closed' }}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                        <div class="form-group">
                                            <strong>Assigned User Name:</strong>
                                            {{ !empty($ticket_data->assigned_user_id) ? (!empty($ticket_data->getUserInfo) ? $ticket_data->getUserInfo->name : "-") : "-" }}
                                        </div>
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
