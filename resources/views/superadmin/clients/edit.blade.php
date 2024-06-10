@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mt-4 ml-2" style="font-size: 25px">Client</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Client</li>
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
                                    <a href="{{ route('client.all') }}"class="btn btn-light shadow rounded m-0">
                                        <span>Cancel Edit
                                        </span></a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row m-auto">
                                    <div class="col-12 m-auto" style="border: 1px solid #ddd">
                                        <form action="{{ route('client.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <div class="modal-body">
                                                <div class="mb-3 mt-3">
                                                    <label for="user_name" class="form-label"> Client Name:</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $data->name }}" name="name">
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="user_phone" class="form-label">Phone:</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $data->phone }}" name="phone">
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="user_email" readonly class="form-label">Email:</label>
                                                    <input type="email" class="form-control" value="{{ $data->email }}"
                                                        name="email">
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="exampleInputEmail1"> Flat Sequence </label>
                                                    @if (isset($flat->sequence) && !empty($flat->sequence))
                                                        <input type="text" class="form-control"
                                                            value="@if ($flat->sequence == 1) A1,A2,A3
                                                @elseif ($flat->sequence == 2)A1,B1,C1
                                               
                                                @else 1A,2A,3A @endif"
                                                            readonly>
                                                    @else
                                                        <input type="text" class="form-control"
                                                            value="-----" readonly>
                                                    @endif
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="exampleInputEmail1"> Status </label>
                                                    <select name="status" id="" class="form-control">
                                                        <option value="1"
                                                            @if ($data->status == 1) selected @endif>
                                                            Active</option>
                                                        <option value="0"
                                                            @if ($data->status == 0) selected @endif>
                                                            Deactive</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
