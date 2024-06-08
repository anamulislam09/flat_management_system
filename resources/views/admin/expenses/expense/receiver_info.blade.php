@extends('layouts.admin')

@section('admin_content')
    <style>
        ul li {
            list-style: none;
        }

        @media screen and (max-width: 767px) {
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

            .text {
                font-size: 14px;
            }

            .button {
                margin-top: -0px !important;
            }
            .caption{
                font-size: 18px;
            }

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
                                <h3 class="card-title pt-2" style="width:100%; text-align:center text">Create Voucher</h3>
                            </div>
                            <div class="card-header mt-3">
                                @php
                                    $vendors = App\Models\Vendor::where('client_id', Auth::guard('admin')->user()->id)
                                        ->latest()
                                        ->get();
                                @endphp
                                <form action="{{ route('expense.voucher.generate') }}" method="post" target="_blank">
                                    @csrf
                                    <input type="hidden" name="exp_id" value="{{ $exp->id }}">
                                    <input type="hidden" name="amount" value="{{ $exp->amount }}">
                                    <div class="row">
                                        <div class="form-group col-lg-8 col-md-8 col-sm-12">
                                            <select name="vendor_id" id="" class="form-control text" required>
                                                <option value="" selected disabled>Select One</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                id="generate">Generate</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- /.card-header -->

                            <div id="accordion">

                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0 text">
                                            Add New Vendor &rightarrow;
                                            <button class="btn btn-link collapsed pl-0 text" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                Click here
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row py-4">
                                                <div class="col-lg-8 col-md-10 col-sm-12 m-auto border p-4" style="background: #ddd">
                                                        {{-- <caption class="caption">Vendor Create Form</caption> --}}
                                                        <legend class="caption">Vendor Create Form</legend>
                                                    <hr>
                                                    <form action="{{ route('expense.voucher.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="exp_id" value="{{ $exp->id }}">
                                                        <input type="hidden" name="amount" value="{{ $exp->amount }}">
                                                        <div class=" form-group">
                                                            <label for="name" class="text">Name :</label>
                                                            <input type="text" class="form-control text" value=""
                                                                name="name" id="name" placeholder="Enter Name"
                                                                required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="phone" class="text">Phone :</label>
                                                            <input type="text" class="form-control text" value=""
                                                                name="phone" id="phone"
                                                                placeholder="Enter Phone Number" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="unit" class="text">Address :</label>
                                                            <input type="text" class="form-control text" value=""
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
                </div>
            </div>
        </section>
    </div>
@endsection
