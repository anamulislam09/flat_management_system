@extends('user.user_layouts.user')
@section('user_content')
<style>
 @media screen and (max-width: 767px) {
  
        .card-title a {
            font-size: 15px;
        }
  
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
                    <div class="col-12 ">
                        {{-- <div class="card ">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-10 col-sm-12">
                                        <h3 class="card-title text">User Password Reset</h3>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-lg-7 col-md-8 col-sm-12 m-auto">
                                <!-- /.card-header -->
                                <div class="card mt-5" >
                                    <div class="card-header text-center">
                                        {{-- <h3 class="card-title">Password Reset Form</h3> --}}
                                        <strong class="text"><span>Password Reset Form</span></strong>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('user.password.reset.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $data->user_id}}">
                                            <div class="mb-3 mt-3">
                                                <label for="password" class="form-label text">Change Password:</label>
                                                <input type="text" class="form-control text" value=""
                                                    name="password" id="password" placeholder="Enter New Password">
                                            </div>
                                    
                                    <!-- /.card-body -->
                                    <div class=" clearfix">
                                        <button type="submit" class="btn btn-primary text">Reset</button>
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
