@extends('layouts.admin')

@section('admin_content')

<style>
    @media screen and (max-width: 767px) {
    div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate{
text-align: right !important;
    }
    
    .card-title a{
        font-size: 15px;
    }
    table, thead, tbody, tr, td{
        font-size: 15px;
    }

    }
</style>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mt-4 ml-2" style="font-size: 25px">Clients</h1>
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
                                    <a href="#"class="btn btn-light shadow rounded m-0"> <span>All Clients</span></a>
                                </h3>
                            </div>
                            {{-- <div class="row ml-3 mt-2">
                                <div class="col-lg-3 col-md-3 col-sm-6 form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control submitable" id="status">
                                        <option value="">All</option>
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div> --}}
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
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td>{{ $item->address }}</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <span class="badge badge-primary">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Deactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- <a href="" class="btn btn-sm btn-primary"><i
                                                            class="fas fa-eye"></i></a> --}}
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
@endsection
