@section('title', 'Ticket Add')
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">Add Ticket</div>
                            <div class="col-md-2"><a href="{{ route('ticket.list') }}" class="btn btn-primary">Back</a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="inner-box">
                            <form action="{{ route('ticket.store') }}" method="POST" name="create-ticket"
                                enctype="multipart/form-data" id="create-ticket">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Title:</strong>
                                                <input type="text" name="title" class="form-control"
                                                    placeholder="Title" value="{{ old('title') }}" id="title" oninput="disallowFirstSpace(event)">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                            <div class="form-group">
                                                <strong>Description:</strong>
                                                <textarea name="description" class="form-control" placeholder="Description" id="textareaField" oninput="disallowFirstSpaceTextArea(event, this)">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3 text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    {!! JsValidator::formRequest('App\Http\Requests\CreateTicketRequest', '#create-ticket') !!}
    <script src="{{ asset('js/tickets/add_edit.js')}}"></script>
    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif (Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
        });
    </script>
@endpush
