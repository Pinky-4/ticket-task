@section('title', 'Ticket List')
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">Tickets</div>
                            <div class="col-md-2">
                                @if(\Illuminate\Support\Facades\Auth::user()->role == 0)
                                    <a href="{{ route('ticket.add') }}" class="btn btn-primary float-right">create</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="filter-field-space m-2">
                        <input type="text" id="all_search" class="form-field form-control search_control"
                            placeholder="Search">
                    </div>

                    <div class="card-body">
                        <div class="inner-box table-responsive table-pds">
                            {!! $html->table(
                                ['class' => 'ticket_listing table text-center table-sortable responsive table', 'width' => '100%'],
                                true,
                            ) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-styles')
    <style>
        .toast-success {
            background-color: #51a351 !important;
        }

        .toast-error {
            background-color: #bd362f !important;
        }
    </style>
@endpush
@push('custom-scripts')
    <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('js/tickets/list.js')}}"></script>
    {!! $html->scripts() !!}
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
