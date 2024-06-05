@extends('user.user_layouts.user')

@section('user_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">New Flat Entry</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                               <div class="row py-5">
                                <div class="col-7 m-auto border p-5" style="background: #ddd">
                                    <form action="{{ route('manager.flat.singlestore') }}" method="POST">
                                        @csrf
                                            <div class=" form-group">
                                                <label for="flat_name" class="">Flat Name</label>
                                                <input type="text" class="form-control" value="" name="flat_name"
                                                    id="" placeholder="Enter flat name" required>
                                            </div>
                                            <div class=" form-group">
                                                <label for="flat_name" class="">Flat Location</label>
                                                <input type="text" class="form-control" value="" name="floor_no"
                                                    id="" placeholder="Enter flat location" required>
                                            </div>
                                            {{-- <div class=" form-group">
                                                <label for="amount" class="">Service Charge</label>
                                                <input type="text" class="form-control" value="" name="amount"
                                                    id="" placeholder="Enter service charge" required>
                                            </div> --}}
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
