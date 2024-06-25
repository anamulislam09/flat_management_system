@extends('layouts.admin')

@section('admin_content')
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
                font-size: 10px !important;
            }

            table,
            thead,
            tbody,
            tr,
            td,
            th {
                font-size: 13px !important;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center text">
                                <h3 class="card-title" style="width:100%; text-align:center; font-size:14px">All Users</h3>
                            </div>
                            {{-- </div> --}}
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>User Id</th>
                                            <th>User Name</th>
                                            <th>Flat Name</th>
                                            <th>Phone/Passport</th>
                                            <th>Email</th>
                                            <th>NID/NRC</th>
                                            <th>Status</th>
                                            <th> Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            @php
                                                $flat = DB::table('flats')
                                                    ->where('client_id', Auth::guard('admin')->user()->id)
                                                    ->where('flat_id', $item->flat_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $item->user_id }}</td>
                                                <td>{{ $item->name }}</td>
                                                @if (!empty($flat))
                                                    <td>{{ $flat->flat_name }}</td>
                                                @else
                                                    <td class="text-center">-----</td>
                                                @endif
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->nid_no }}</td>
                                                <td>
                                                    @if ($item->status == 0)
                                                        <span class="badge badge-danger">Deactive</span>
                                                    @else
                                                        <span class="badge badge-primary">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-info edit"
                                                        data-id="{{ $item->id }}" data-toggle="modal"
                                                        data-target="#editUser"><i class="fas fa-edit"></i></a>
                                                </td>
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

    {{-- category edit model --}}
    <!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="model-main">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Edit Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal_body">

                </div>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script>
        $('body').on('click', '.edit', function() {
            let user_id = $(this).data('id');
            $.get("/admin/users/edit/" + user_id, function(data) {
                $('#model-main').html(data);

            })
        })
    </script>
@endsection
