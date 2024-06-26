@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text" style="width:100%; text-align:center">Opening Balance Entry</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row py-4">
                                    <div class="col-8 m-auto border p-5" style="background: #f1f1f1">
                                        <form action="{{ route('opening.balance.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="unit" class="">Amount of opening balance :</label>
                                                <input type="text" class="form-control" name="amount"
                                                    placeholder="Enter Amount">
                                            </div>
                                            <div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="radio" name="flag" value="1"
                                                        id="radioSuccess1" required>
                                                    <label for="radioSuccess1">Profit</label>
                                                </div>
                                                <div class="icheck-danger d-inline">
                                                    <input type="radio" name="flag" value="0"
                                                        id="radioDanger1" required>
                                                    <label for="radioDanger1" class="text-danger">Loss</label>
                                                </div>
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
