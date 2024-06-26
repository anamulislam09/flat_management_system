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

            table,
            thead,
            tbody,
            tr,
            td {
                font-size: 15px;
            }

            table,
            thead,
            tbody,
            tr,
            td,
            th {
                font-size: 13px !important;
                padding: 5px !important;
            }

            .card-header {
                padding: .25rem 1.25rem;
            }

            .text {
                font-size: 14px !important;
            }

            .form {
                margin-bottom: 9px !important;
                width: 250px;
                float: left;
            }

            .form2 {
                float: right;
                width: 100px;
            }
        }

        .table td,
        .table th {
            padding: .30rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }

        .text {
            font-size: 15px !important;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mt-4 ml-2 text" style="font-size: 25px">Clients</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Clients</li>
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
                                    <a href="#"class="btn btn-light shadow rounded m-0 text"> <span>All
                                            Clients</span></a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Customer Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Verification Status</th>
                                                <th>Package</th>
                                                <th>Validation Status</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($data as $item)
                                            @php
                                                 $package = App\Models\Package::where('id', $item->package_id)->first();
                                            @endphp
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>{{ $item->address }}</td>
                                                    <td>
                                                        @if ($item->isVerified == 1)
                                                            <span class="badge badge-primary">Verified</span>
                                                        @else
                                                            <span class="badge badge-danger">Not Verified</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($package->package_name))
                                                            {{ $package->package_name }}
                                                        @endempty
                                                </td>
                                                @php
                                                    $today = Carbon\Carbon::today()->toDateString();
                                                    $datetime1 = new DateTime($item->package_start_date);
                                                    $datetime2 = new DateTime($today);
                                                    $difference = $datetime1->diff($datetime2);
                                                @endphp
                                                <td>
                                                    @if (!empty($package))
                                                        @if ($difference->days > $package->duration)
                                                            <span class="badge badge-danger">Expired</span>
                                                        @elseif ($package->duration - $difference->days <= 30)
                                                            <span class="badge badge-warning">Expeired Soon</span>
                                                        @else
                                                            <span class="badge badge-primary">Done</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <a href="{{ route('client.notactive', $item->id) }}"
                                                            class="deactive_status"><i
                                                                class="fas fa-thumbs-down text-danger pr-1"></i><span
                                                                class="badge badge-success ">Active</span></a>
                                                    @else
                                                        <a href="{{ route('client.active', $item->id) }}"
                                                            class="active_status"><i
                                                                class="fas fa-thumbs-up text-primary pr-1"></i><span
                                                                class="badge badge-danger ">Deactive</span></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('client.edit', $item->id) }}"
                                                        class="btn btn-sm btn-info edit"><i class="fas fa-edit"></i></a>
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
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // {{-- status ajax stert here --}}
    //   {{-- active_status --}}
    $('body').on('click', '.active_status', function() {
        var href = $(this).attr('href');
        var url = href;
        $.ajax({
            url: url,
            type: 'get',
            success: function(data) {
                toastr.success(data);
                window.location.reload()
            }
        })
    })

    // {{--  deactive_status --}}
    $('body').on('click', '.deactive_status', function() {
        var href = $(this).attr('href');
        var url = href;
        $.ajax({
            url: url,
            type: 'get',
            success: function(data) {
                toastr.success(data);
                window.location.reload()
            }
        })
    })
    // {{-- status ajax ends here --}}
</script>
@endsection
