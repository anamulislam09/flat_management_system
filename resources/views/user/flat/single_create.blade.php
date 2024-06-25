@extends('user.user_layouts.user')
@section('user_content')

<style>
    @media screen and (max-width: 767px) {
  
  
        .card-header {
            padding: .25rem 1.25rem;
        }
  
        .text {
            font-size: 14px !important;
        }
  
        .button {
            margin-top: -0px !important;
        }
    }
    .text {
            font-size: 14px !important;
        }
  </style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text " style="width:100%; text-align:center">New Flat Entry</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row py-5">
                                    <div class="col-lg-7 col-md-8 col-sm-12 m-auto border p-5" style="background: #ddd">
                                        <form action="{{ route('manager.flat.singlestore') }}" method="POST">
                                            @csrf
                                            <div class=" form-group">
                                                <label for="flat_name" class="text">Flat Name</label>
                                                <input type="text" class="form-control text" value="" name="flat_name"
                                                    id="" placeholder="Enter flat name" required>
                                            </div>
                                            <div class=" form-group">
                                                <label for="flat_name" class="text">Flat Location</label>
                                                <input type="text" class="form-control text" value="" name="floor_no"
                                                    id="" placeholder="Enter flat location" required>
                                            </div>
                                            <div class="">
                                                <button type="submit" class="btn btn-sm btn-primary text"
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
