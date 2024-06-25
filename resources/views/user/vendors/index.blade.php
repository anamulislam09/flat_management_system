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
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text" style="width:100%; text-align:center">All Vendor</h3>
                            </div>

                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body table-responsive">
                                            <table id="dataTable" class="table table-bordered table-striped item-table">
                                                <thead>
                                                    <tr style="border-top: 1px solid #ddd">
                                                        <th width="10%">SL</th>
                                                        <th width="15%">Name</th>
                                                        <th width="20%">Phone</th>
                                                        <th width="25%">Address</th>
                                                        <th width="15%">Entry Date </th>
                                                        <th width="15%">Created BY </th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vendors as $key => $item)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->phone }}</td>
                                                            <td>{{ $item->address }}</td>
                                                            <td>{{ $item->date }}</td>
                                                            <td>
                                                                @php
                                                                    //  $user = User::where('user_id', Auth::user()->user_id)->first();
                                                                    $client_name = App\Models\Client::where(
                                                                        'id',
                                                                        $item->auth_id,
                                                                    )->first();
                                                                    $user_name = App\Models\User::where(
                                                                        'client_id',
                                                                        $item->client_id,
                                                                    )
                                                                        ->where('user_id', $item->auth_id)
                                                                        ->first();
                                                                @endphp

                                                                @if ($item->auth_id == Auth::user()->user_id)
                                                                {{ $user_name->name }}
                                                                @else
                                                                {{ $client_name->name }}
                                                                @endif


                                                            </td>
                                                            <td>
                                                                <a href="" class="btn btn-sm btn-info edit"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-target="#editUser"><i class="fas fa-edit"></i></a>
                                                                {{-- <a href="{{ route('customers.delete', $item->user_id) }}"
                                                        class="btn btn-sm btn-danger edit"><i class="fas fa-trash"></i></a> --}}
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
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title editmodel text">Edit Vendor </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal_body" class="modl-body">

                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('body').on('click', '.edit', function() {
            let id = $(this).data('id');
            $.get("/manager/vendor/edit/" + id, function(data) {
                $('#modal_body').html(data);
            })
        })
    </script>
@endsection
