@extends('layouts.admin')
@section('admin_content')
    <style>
        @media screen and (max-width: 767px) {
            .card-title a {
                font-size: 15px;
            }

            table,
            thead,
            tbody,
            tr,
            td {
                font-size: 14px;
            }

            .text {
                font-size: 14px !important;
            }
        }

        .text {
            font-size: 14px !important;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mt-4 ml-2" style="font-size: 23px">All Collection</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Collections</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <a href="{{ route('collection.create') }}"class="btn btn-light shadow rounded text"><i
                                            class="fas fa-plus"></i><span>Add New</span></a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr style="border-top: 1px solid #ddd">
                                                <th>SL</th>
                                                <th>Client Name</th>
                                                <th>Package Amount</th>
                                                <th>Collection Amount</th>
                                                <th>Due</th>
                                                {{-- <th> Action</th> --}}
                                        </thead>
                                        <tbody>
                                            @foreach ($payments as $key => $item)
                                                @php
                                                    $client = App\Models\Client::where(
                                                        'id',
                                                        $item->client_id,
                                                    )->first();
                                                    $paidAmount = App\Models\Payment::where(
                                                        'client_id',
                                                        $item->client_id,
                                                    )->sum('paid');
                                                    // dd($costomer);
                                                    $due = $item->payment_amount - $paidAmount;
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $client->name }}</td>
                                                    <td>{{ $item->payment_amount }}</td>
                                                    <td>{{ $paidAmount }}</td>
                                                    <td>
                                                        @if ($due > 0)
                                                            <span class="badge badge-danger">{{ $due }}</span>
                                                        @else
                                                            <span class="badge badge-primary">{{ $due }}</span>
                                                        @endif
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
        </section>
        <!-- Modal -->
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text" id="exampleModalLabel">Edit Collection </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal_body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script>
        $('body').on('click', '.edit', function() {
            let id = $(this).data('id');
            $.get("/admin/collection/edit/" + id, function(data) {
                $('#modal_body').html(data);

            })
        })

        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
