@extends('user.user_layouts.user')
@section('user_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{Auth::user()->name}} Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('user.Profile') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @php

            $user_id = App\Models\User::where('user_id', Auth::user()->user_id)->first();

            $user = App\Models\User::where('client_id', $user_id->client_id)->count();
            $flat = App\Models\Flat::where('client_id', $user_id->client_id)->count();
            $total_exp = App\Models\Exp_detail::where('client_id', $user_id->client_id)->sum('amount');
            $total_income = App\Models\Income::where('client_id', $user_id->client_id)->sum('paid');
            $manualOpeningBlance = DB::table('opening_balances')
                ->where('client_id', $user_id->client_id)
                ->first();
            $others_income = DB::table('others_incomes')
                ->where('client_id', $user_id->client_id)
                ->sum('amount');

            $balance = App\Models\MonthlyBlance::where('client_id', $user_id->client_id)->sum('amount');
            $Customers = App\Models\Customer::where('role', 1)->count();
            $category = App\Models\Category::count();
            $superAdmin = Auth::user()->user_id;

            // user transaction start here
            $total_paid = App\Models\Income::where('client_id', $user_id->client_id)
                ->where('flat_id', $user_id->flat_id)
                ->sum('paid');
            $total_amount = App\Models\Income::where('client_id', $user_id->client_id)
                ->where('flat_id', $user_id->flat_id)
                ->sum('amount');
            // user transaction ends here

             // this month transactions 
            $flats = App\Models\Flat::where('client_id', $user_id->client_id)->count();
            $expense = App\Models\Exp_detail::where('client_id', $user_id->client_id)->where('date', date('Y-m'))->sum('amount');
            $income = App\Models\Income::where('client_id', $user_id->client_id)->where('date', date('Y-m'))->sum('paid');
            $others_income = DB::table('others_incomes')->where('client_id', $user_id->client_id)->where('date', date('Y-m'))->sum('amount');
            $balance = App\Models\MonthlyBlance::where('client_id', $user_id->client_id)->where('date', date('Y-m'))->sum('amount');

        @endphp

        <section class="content">
            <div class="container-fluid">

                @if (Auth::user()->role_id == 0)
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info text-center">
                                <div class="inner">
                                    <p>Total Paid</p>
                                    <h3>{{ $total_paid }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning text-center">
                                <div class="inner ">
                                    <p>Total Due</p>
                                    <h3>{{ $total_amount - $total_paid }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <hr>
                    <p>All Transaction</p>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total User</p>
                                    <h3>{{ $user }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3>{{ $flat }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3>{{ $total_exp }}<sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>Total Service Charge</p>
                                    <h3>{{ $total_income }}<sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Others Income</p>
                                    <h3>{{ $others_income }}<sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    @if (isset($manualOpeningBlance))
                                        @if ($manualOpeningBlance->flag == 1)
                                            <p>Opening Balance (Profit)</p>
                                            <h3>{{ $manualOpeningBlance->profit }}<sup style="font-size: 20px">TK</sup>
                                            </h3>
                                        @else
                                            <p>Opening Balance (Loss)</p>
                                            <h3>{{ $manualOpeningBlance->loss }}<sup style="font-size: 20px">TK</sup></h3>
                                        @endif
                                    @else
                                        <p>Opening Balance </p>
                                        <h3>0<sup style="font-size: 20px">TK</sup>
                                        </h3>
                                    @endif
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background: #FB5200">
                                <div class="inner">
                                    <p>Total Collection</p>

                                    @if (isset($manualOpeningBlance))
                                        @if ($manualOpeningBlance->flag == 1)
                                            <h3>{{ $total_income + $others_income + $manualOpeningBlance->profit }} <sup
                                                    style="font-size: 20px">TK</sup></h3>
                                        @else
                                            <h3>{{ $total_income + $others_income - $manualOpeningBlance->loss }} <sup
                                                    style="font-size: 20px">TK</sup></h3>
                                        @endif
                                    @else
                                        <h3>{{ $total_income + $others_income }} <sup style="font-size: 20px">TK</sup></h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3>{{ $balance }} <sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @else

                <div class="card " style="margin-top: -20px !important">
                    <div class="card-header row ">
                        <h4><input value="{{ date('Y-m') }}" type="month" name="date" class="form-control"
                                id="date"></h4>
                    </div>
                </div>
                <div class="row" id="datewiseData">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box " style="background: #df8e15">
                            <div class="inner text-white">
                                <p>No of Flat</p>
                                <h3 id="flats">{{$flat}}</h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('manager.flat.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner text-white">
                                <p>Total Expenses</p>
                                <h3 id="expense"><sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('manager.expenses.year') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <p>Total Service Charge</p>
                                <h3 id="income"><sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('manager.income.statement') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <p>Others Income</p>
                                <h3 id="others_income"><sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <p>Balance</p>
                                <h3 id="balance"><sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('manager.blance.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row" id="todaydata">
                    <div class="col-lg-3 col-6">
                        <div class="small-box " style="background: #df8e15">
                            <div class="inner text-white">
                                <p>No of Flat</p>
                                <h3>{{ $flat }}</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('manager.flat.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner text-white">
                                <p>Total Expenses</p>
                                <h3>{{ $expense }}<sup style="font-size: 20px">TK</sup></h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('manager.expenses.year') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <p>Total Service Charge</p>
                                <h3>{{ $income }}<sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route('manager.income.statement') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <p>Others Income</p>
                                <h3>{{ $others_income }}<sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <p>Balance</p>
                                <h3>{{ $balance }} <sup style="font-size: 20px">TK</sup></h3>

                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('manager.blance.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="title">Total Transactions</h4>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total User</p>
                                    <h3>{{ $user }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('manager.users.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3>{{ $flat }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('manager.flat.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3>{{ $total_exp }}<sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('manager.expenses.year') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>Total Service Charge</p>
                                    <h3>{{ $total_income }}<sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('manager.income.statement') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Others Income</p>
                                    <h3>{{ $others_income }}<sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    @if (isset($manualOpeningBlance))
                                        @if ($manualOpeningBlance->flag == 1)
                                            <p>Opening Balance (Profit)</p>
                                            <h3>{{ $manualOpeningBlance->profit }}<sup style="font-size: 20px">TK</sup>
                                            </h3>
                                        @else
                                            <p>Opening Balance (Loss)</p>
                                            <h3>{{ $manualOpeningBlance->loss }}<sup style="font-size: 20px">TK</sup></h3>
                                        @endif
                                    @else
                                        <p>Opening Balance </p>
                                        <h3>0<sup style="font-size: 20px">TK</sup>
                                        </h3>
                                    @endif
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box" style="background: #FB5200">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    @if (isset($manualOpeningBlance))
                                        @if ($manualOpeningBlance->flag == 1)
                                            <h3>{{ $total_income + $others_income + $manualOpeningBlance->profit }} <sup
                                                    style="font-size: 20px">TK</sup></h3>
                                        @else
                                            <h3>{{ $total_income + $others_income - $manualOpeningBlance->loss }} <sup
                                                    style="font-size: 20px">TK</sup></h3>
                                        @endif
                                    @else
                                        <h3>{{ $total_income + $others_income }} <sup style="font-size: 20px">TK</sup></h3>
                                    @endif
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3>{{ $balance }} <sup style="font-size: 20px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('manager.blance.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var searchRequest = null;

    $(document).ready(function() {
        $("#datewiseData").hide();
        $("#date").on('change', function() {
            $("#datewiseData").show();
            $("#todaydata").hide();
            var date = $(this).val();
            // alert(date);
            $.ajax({
                type: "GET",
                url: "{{ url('get-transaction') }}/" + date,
                dataType: "json",
                success: function(res) {
                    console.log(res);
                        $('#flats').text(res.elats);
                        $('#expense').text(res.expense);
                        $('#income').text(res.income);
                        // $('#manualOpeningBalance').text(res.manualOpeningBalance);
                        $('#others_income').text(res.others_income);
                        $('#balance').text(res.balance);
                    }
                });
            });
        });
    </script>
@endsection
