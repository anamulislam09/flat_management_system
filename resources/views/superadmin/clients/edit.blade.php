@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <div class="row">
                                    <div class="col-lg-10 col-sm-12">
                                        <h3 class="card-title">Edit Customer </h3>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <a href="{{ route('customers.all') }}" class="btn btn-outline-primary">Cancel Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row m-auto">
                                    <div class="col-8 m-auto" style="border: 1px solid #ddd">
                                        <form action="{{ route('customers.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <div class="modal-body">
                                                <div class="mb-3 mt-3">
                                                    <label for="user_name" class="form-label"> Customer Name:</label>
                                                    <input type="text" class="form-control" value="{{ $data->name }}"
                                                        name="name">
                                                </div>

                                                @php
                                                    $details = App\Models\CustomerDetail::where('client_id', $data->id)->first();
                                                    // dd($details);
                                                @endphp

                                                <div class="mb-3 mt-3">
                                                    <label for="user_phone" class="form-label"> Customer Phone:</label>
                                                    <input type="text" class="form-control" value="{{ $details->phone }}"
                                                        name="phone">
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="user_email" class="form-label"> Customer Email:</label>
                                                    <input type="email" class="form-control" value="{{ $data->email }}"
                                                        name="email">
                                                </div>

                                                <div class="mb-3 mt-3">
                                                    <label for="exampleInputEmail1"> Flat Name </label>
                                                    @if (isset($sequence) && !empty($sequence))
                                                        <select name="status" id="" class="form-control">
                                                            <option value="1"
                                                                @if ($flat->sequence == 1) selected @endif>
                                                                A1,A2,A3</option>
                                                            <option value="2"
                                                                @if ($flat->sequence == 2) selected @endif>
                                                                A1,B1,C1</option>
                                                            <option value="3"
                                                                @if ($flat->sequence == 3) selected @endif>
                                                                1A,2A,3A</option>
                                                        </select>
                                                    @else
                                                        <select name="status" id="" class="form-control">
                                                            <option value="1">
                                                                A1,A2,A3</option>
                                                            <option value="2">
                                                                A1,B1,C1</option>
                                                            <option value="3">
                                                                1A,2A,3A</option>
                                                        </select>
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
