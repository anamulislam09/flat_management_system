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
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text" style="width:100%; text-align:center">Vendore Entry Form</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row py-4">
                                        <div class="col-8 m-auto border p-5" style="background: #ddd">
                                            <form action="{{ route('manager.vendor.store') }}" method="POST">
                                                @csrf
                                                <div class=" form-group">
                                                    <label for="name" class="text">Name :</label>
                                                    <input type="text" class="form-control text" value="" name="name"
                                                        id="name" placeholder="Enter Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone" class=" text">Phone :</label>
                                                    <input type="text" class="form-control text" value="" name="phone"
                                                        id="phone" placeholder="Enter Phone Number" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="unit" class="text">Address :</label>
                                                    <input type="text" class="form-control text" value="" name="address"
                                                        placeholder="Enter Address">
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
            </div>
        </section>
    </div>
@endsection
