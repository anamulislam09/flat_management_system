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
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">User Entry 
                                 </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">

                                        @php
                                            $flat = App\Models\Flat::where(
                                                'client_id',
                                                Auth::guard('admin')->user()->id,
                                            )->exists();
                                            $user = App\Models\User::where(
                                                'client_id',
                                                Auth::guard('admin')->user()->id,
                                            )->exists();
                                        @endphp

                                        @if (!$flat)
                                            <section class="page_404">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12 col-md-12 col-sm-12">
                                                            <div class="col-sm-12 text-center">
                                                                <div class="four_zero_four_bg">
                                                                    <h1 class="text-center ">404</h1>
                                                                </div>
                                                                <div class="contant_box_404">
                                                                    <h3 class="h2">
                                                                        Flat Not Found!
                                                                    </h3>

                                                                    <p>Pls! Flat create first</p>

                                                                    <a href="{{ route('users.index') }}"
                                                                        class="link_404">See Users</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            @elseif($user)
                                        <section class="page_404">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12 col-md-12 col-sm-12">
                                                        <div class="col-sm-12 text-center">
                                                            <div class="four_zero_four_bg">
                                                                <h1 class="text-center ">WELCOME</h1>
                                                            </div>
                                                            <div class="contant_box_404">
                                                                <h3 class="h2">
                                                                    You Have Already Creaded!
                                                                </h3>
                                                                <a href="{{route('users.index')}}" class="link_404">See Users</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        @endif
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
