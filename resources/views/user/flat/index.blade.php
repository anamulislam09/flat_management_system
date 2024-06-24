@extends('user.user_layouts.user')

@section('user_content')
<style>
    @media screen and (max-width: 767px) {

        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: right !important;
        }

        .card-title a {
            font-size: 10px !important;
        }

        table,
        thead,
        tbody,
        tr,
        th,
        td {
            font-size: 13px !important;
            padding: 5px !important;
        }
    }

    .table td,
    .table th {
        padding: .30rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        font-size: 14px;
    }
</style>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-10 col-sm-12">
                    <div class="card">

                        <div class="card-header bg-primary text-center">
                            <h3 class="card-title" style="width:100%; text-align:center; font-size:14px !important">All
                                Flats </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            @php
                                $flat = App\Models\Flat::where(
                                    'client_id',
                                    Auth::user()->client_id,
                                )->exists();
                                $total = App\Models\Flat::where('client_id', Auth::user()->client_id)->sum(
                                    'amount',
                                );
                            @endphp

                            @if (!$flat)
                                <section class="page_404">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="col-sm-12 text-center">
                                                    <div class="contant_box_404">
                                                        <h3 class="h2">
                                                            Flat Not Found!
                                                        </h3>
                                                        <p>Pls! Flat created first</p>
                                                        {{-- <a href="{{ route('flat.create') }}"
                                                            class="link_404 btn btn-primary">Create
                                                            Flat</a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @else
                                <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-center">Customer ID</th>
                                            <th class="text-center">Flat Name</th>
                                            <th class="text-center">Service Charge</th>
                                            <th class="text-center">Status</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->client_id }}</td>
                                                <td>{{ $item->flat_name }}</td>
                                                <td class="text-right">{{ $item->amount }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 1)
                                                        <span class="badge badge-primary">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Deactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"> <strong>Total :</strong></td>
                                            <td class="text-right"><strong>{{ $total }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
