@extends('layouts.admin')

@section('admin_content')
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
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header bg-primary text-center">
                                <div style="float: left">
                                    <h3 class="card-title pt-2 text" style="width:100%; text-align:center">Edit Schedule Setup
                                    </h3>
                                </div>
                                <div style="float: right">
                                    <a href="{{route('expense.setup')}}" class="btn btn-light shadow text" style="float:right">Cancel Edit</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row">
                                    <div class="col-lg-12 border p-4" style="background: #f0eeee">
                                        <form action="{{ route('expense.setup.update') }}" method="POST" id="form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $exp->id }}">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class=" form-group">
                                                        <label for="floor" class="text">Select Expense</label>
                                                        <select name="exp_id" id="exp_id" class="form-control text">
                                                            <option value="" selected disabled>Select Once</option>
                                                            @foreach ($expenses as $expense)
                                                                <option
                                                                    value="{{ $expense->id }}"@if ($expense->id == $exp->exp_id) selected @endif>
                                                                    {{ $expense->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class=" form-group">
                                                        <label for="floor" class="text">Select Vendor</label>
                                                        <select name="vendor_id" id="vendor_id" class="form-control text" required>
                                                            <option value="" selected disabled>Select Once</option>
                                                            @foreach ($vendor as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="unit" class="text">Interval Days :</label>
                                                        <input type="text" class="form-control text"
                                                            value="{{ $exp->interval_days }}" name="days" id="days"
                                                            placeholder="Enter Interval Days" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="submit" id="submitBtn" class="btn btn-sm btn-primary text"
                                                            style="margin-top: 35px">Submit</button>
                                                    </div>
                                                </div>
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
