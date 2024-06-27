@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mt-4 ml-2" style="font-size: 25px">Package</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Package</li>
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
                                    <a href="{{ route('collections.all') }}"class="btn btn-light shadow rounded m-0"><span>See
                                            All</span></a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('collection.store') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header P-5">
                                        <div class="mb-3 mt-3 form">
                                            <label for="exampleInputEmail1">Select Client </label>
                                            <select class="form-control form-control-sm select2" name="client_id"
                                                id="client_id" style="width: 100%;" required>
                                                <option value="" selected disabled>Select Once</option>
                                                @foreach ($client as $item)
                                                    <option class="pb-3" value="{{ $item->id }}">
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mt-3 form">
                                            <label>Package Name</label>
                                            <input type="text" class="form-control" value="" id="package"
                                                name="package_name">
                                        </div>

                                        <div class="mb-3 mt-3 form">
                                            <label for="package_bill" class="form-label">Package Bill</label>
                                            <input type="text" class="form-control" value="" name="package_bill"
                                                id="package_bill">
                                        </div>
                                        <div class="mb-3 mt-3 form">
                                            <label for="amount" class="form-label">Collection Amount</label>
                                            <input type="text" class="form-control" value="{{ old('amount') }}"
                                                name="collection_amount" placeholder="Enter amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer clearfix form">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#client_id").change(function() {
                let client_id = $(this).val();
                // $("#package").html('<option value="">Select One</option>')
                $.ajax({
                    url: '/admin/get-package',
                    type: 'post',
                    data: 'client_id=' + client_id + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('#package').val(result.package.package_name);
                        $('#package_bill').val(result.package.amount);
                        // console.log(result);
                    }
                })
            })
        })
    </script>
@endsection
