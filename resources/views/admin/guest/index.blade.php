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
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Guest</h1>
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
                                    <a href="{{ route('guestBook.create') }}"class="btn btn-light shadow rounded m-0"><i
                                            class="fas fa-plus"></i><span>Add New</span></a>
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
                                            {{-- <th>Created By</th> --}}
                                            <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($guests as $key => $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->image }}</td>
                                                <td>{{ $item->address }}</td>
                                                <td>{{ $item->address }}</td>
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
