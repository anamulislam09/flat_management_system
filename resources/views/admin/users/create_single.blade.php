@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <style>
        .table td,
        .table th {
            padding: 0.6rem;
        }


        /*======================
                                                    404 page
                                                =======================*/


        .page_404 {
            padding: 40px 0;
            background: #fff;
            font-family: 'Arvo', serif;
        }

        .page_404 img {
            width: 100%;
        }

        .four_zero_four_bg {

            background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
            height: 400px;
            background-position: center;
        }


        .four_zero_four_bg h1 {
            font-size: 80px;
        }

        .four_zero_four_bg h3 {
            font-size: 80px;
        }

        .link_404 {
            color: #fff !important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }

        .contant_box_404 {
            margin-top: -50px;
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
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">New User Entry</h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-10 col-sm-12">
                                        <h3 class="card-title">Add More User</h3>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-10 p-5 m-auto"
                                                style="border: 1px solid #ddd; background:#eeecec">
                                                {{-- <h2 class="text-center"><strong>User Entry Form</strong></h2> --}}
                                                <form action="{{ route('user.store') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="">ID </label>
                                                        <input type="text" name="user_id" class="form-control"
                                                            placeholder="User ID" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Name </label>
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="User name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">NID/NRC Number </label>
                                                        <input type="text" name="nid_no"class="form-control"
                                                            placeholder="User NID or NRC No">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Address</label>
                                                        <textarea name="address" class="form-control"" id="" cols="" rows="1" placeholder="User Address"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Phone/Passport </label>
                                                        <input type="text" name="phone"class="form-control"
                                                            placeholder="User phone" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="email" name="email"class="form-control"
                                                            placeholder="User email">
                                                        <span style="font-size: 14px">Note: Please, create id for manual
                                                            user.</span>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary" value="Submit">
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
        </section>
    </div>
@endsection
