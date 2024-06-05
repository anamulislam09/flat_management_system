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
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Receiver Info Entry</h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    @php
                                        $receivers = App\Models\Addressbook::where(
                                            'client_id',
                                            Auth::guard('admin')->user()->id,
                                        )
                                            ->latest()
                                            ->get();
                                    @endphp
                                    <div class="col-8 m-auto p-5">
                                        <form action="{{ route('expense.voucher.generate') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="exp_id" value="{{ $exp->id }}">
                                            <input type="hidden" name="amount" value="{{ $exp->amount }}">
                                            <div class="form-group">
                                                <select name="receiver_id" id="" class="form-control" required>
                                                    <option value="" selected disabled>Select One</option>
                                                    @foreach ($receivers as $receiver)
                                                        <option value="{{ $receiver->id }}">{{ $receiver->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="">
                                                <button type="submit" class="btn btn-sm btn-primary"
                                                    id="generate">Generate</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div id="accordion">

                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            Add New Receiver Info
                                            <button class="btn btn-link collapsed" data-toggle="collapse"
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
                                                <div class="col-8 m-auto border p-5" style="background: #ddd">
                                                    <form action="{{ route('expense.voucher.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="exp_id" value="{{ $exp->id }}">
                                                        <input type="hidden" name="amount" value="{{ $exp->amount }}">
                                                        <div class=" form-group">
                                                            <label for="name" class="">Name :</label>
                                                            <input type="text" class="form-control" value=""
                                                                name="name" id="name" placeholder="Enter Name"
                                                                required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="phone" class="">Phone :</label>
                                                            <input type="text" class="form-control" value=""
                                                                name="phone" id="phone"
                                                                placeholder="Enter Phone Number" required>
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
                </div>
            </div>
        </section>
    </div>
@endsection
