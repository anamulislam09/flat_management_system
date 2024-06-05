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
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Opening Balance Entry</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row py-4">
                                    <div class="col-8 m-auto border p-5" style="background: #ddd">
                                        <form action="{{ route('opening.balance.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="unit" class="">Amount of opening profit :</label>
                                                <input type="text" class="form-control" name="profit"
                                                    placeholder="Enter Amount" >
                                            </div>
                                            <div class="form-group">
                                                <label for="unit" class="">Amount of opening loss :</label>
                                                <input type="text" class="form-control" name="loss"
                                                    placeholder="Enter amount">
                                                    <span style="font-size: 14px">Note: Please input only one option. Either Profit or loss.</span>
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
        </section>
    </div>

@endsection
