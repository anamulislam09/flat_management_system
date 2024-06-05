@extends('layouts.admin')

@section('admin_content')
    <style>
        ul li {
            list-style: none;
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
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Vendore Entry Form</h3>
                            </div>
                            <div class="card">
                                {{-- <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        Add New Receiver Info
                                        <button class="btn btn-link collapsed" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Click here
                                        </button>
                                    </h5>
                                </div> --}}
                                    <div class="card-body">
                                        <div class="row py-4">
                                            <div class="col-8 m-auto border p-5" style="background: #ddd">
                                                <form action="{{ route('vendor.store') }}" method="POST">
                                                    @csrf
                                                    {{-- <input type="hidden" name="exp_id" value="{{ $exp->id }}">
                                                    <input type="hidden" name="amount" value="{{ $exp->amount }}"> --}}
                                                    <div class=" form-group">
                                                        <label for="name" class="">Name :</label>
                                                        <input type="text" class="form-control" value=""
                                                            name="name" id="name" placeholder="Enter Name" required>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="phone" class="">Phone :</label>
                                                        <input type="text" class="form-control" value=""
                                                            name="phone" id="phone" placeholder="Enter Phone Number"
                                                            required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="unit" class="">Address :</label>
                                                        <input type="text" class="form-control" value=""
                                                            name="address" placeholder="Enter Address">
                                                    </div>
                                                    <div class="">
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            id="generate">Submit</button>
                                                    </div>
                                                </form>
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
@endsection
