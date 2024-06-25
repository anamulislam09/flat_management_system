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
                font-size: 15px;
            }

            .text {
                font-size: 14px !important;
            }

            table,
            thead,
            tbody,
            tr,
            td,
            th {
                font-size: 14px !important;
                padding: 10px !important;
            }

            .card-header {
                padding: .25rem 1.25rem;
            }

        }

        a.disabled {
            pointer-events: none;
            cursor: default;
        }

        .modal-dialog {
            max-width: 650px;
        }

        .table td,
        .table th {
            padding: .20rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }

        .text {
            font-size: 14px
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0 text">Guest</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Guest</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center text p-1">
                                <h3 class="card-title">
                                    <a href="#"class="btn btn-light shadow rounded m-0"><span>Guest Entry History</span></a>
                                </h3>
                            </div>
                            {{-- </div> --}}
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Guest Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Image</th>
                                            <th>Purpose</th>
                                            <th>Entry_Date</th>
                                            <th>Exit_Date</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($history as $key => $item)
                                            @php
                                                $guest = App\Models\Guest::where('id', $item->guest_id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $guest->name }}</td>
                                                <td>{{ $guest->phone }}</td>
                                                <td>{{ $guest->address }}</td>
                                                <td> <img src="{{ asset('images/' . $guest->image) }}"
                                                        style="width: 50px; margin:auto;" alt="{{ $guest->image }}"></td>
                                                <td>{{ $item->purpose }}</td>
                                                <td>{{ $item->entry_date }}</td>
                                                <td>{{ $item->exit_date ? $item->exit_date : '---' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
