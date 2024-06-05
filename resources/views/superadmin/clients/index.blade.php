@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">All Customers </h3>
                            </div>
                            <div class="row ml-3">
                                <div class="col-3 form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control submitable" id="status">
                                        <option value="">All</option>
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="dataTable" class="table table-bordered table-striped">
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
                                        @php
                                            $details =App\Models\CustomerDetail::where('client_id', $item->id)->get();
                                            // dd($details);
                                        @endphp
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                @foreach ($details as $detail)
                                                <td>{{ $detail->phone }}</td>
                                                <td>{{ $detail->address }}</td>
                                                @endforeach
                                                <td>
                                                    @if ($item->status == 1)
                                                        <span class="badge badge-primary">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Deactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-primary"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="{{route('customer.edit',$item->id)}}" class="btn btn-sm btn-info edit"
                                                       ><i class="fas fa-edit"></i></a>
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
    @endsection
