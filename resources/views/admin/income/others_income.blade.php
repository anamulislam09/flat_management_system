@extends('layouts.admin')

@section('admin_content')
<style>
    input:focus {
        outline: none
    }
    .text {
            font-size: 15px;
        }

    @media screen and (max-width: 767px) {
        .card-title a {
            font-size: 14px;
        }

        .text {
            font-size: 15px;
        }

        .button {
            margin-top: -0px !important;
        }

        .date {
            margin-bottom: 15px;
        }
    }
</style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center text">
                                <h3 class="card-title text" style="width:100%; text-align:center">Others Income Entry </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row py-5">
                                    <div class="col-lg-10 col-md-10 col-sm-12 m-auto border py-5">
                                        <form action="{{ route('others.income.store') }}" method="POST">
                                            @csrf
                                            <div class=" form-group">
                                                <label for="floor" class="text">Income Info </label>
                                                <input type="text" class="form-control text" value="" name="income_info"
                                                    id="income_info" placeholder="Enter Income Info" required>
                                            </div>
                                            <div class=" form-group">
                                                <label for="floor" class="text">Amount </label>
                                                <input type="text" class="form-control text" value="" name="amount"
                                                    id="amount" placeholder="Enter Income Amount" required>
                                            </div>
                                            
                                            <div class="">
                                                <button type="submit" class="btn btn-primary btn-end text"
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
