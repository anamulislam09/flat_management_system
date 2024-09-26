@extends('layouts.admin')
@section('admin_content')

    <style>
        h3 {
            font-size: 20px !important;
        }

        p {
            font-size: 14px !important
        }

        .text {
            font-size: 14px !important
        }

        .link {
            font-size: 12px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="m-0 " style="font-size: 28px">Dashboard</h2>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item" style="font-size: 14px"><a
                                    href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" style="font-size: 14px">Dashboard </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        @php
            $user = App\Models\User::where('client_id', Auth::guard('admin')->user()->id)->count();
            $flat = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->count();
            $total_exp = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)->sum('amount');
            $total_income = App\Models\Income::where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
            $manualOpeningBlance = DB::table('opening_balances')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->first();
            $total_others_income = DB::table('others_incomes')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->sum('amount');

            $balance = App\Models\Balance::where('client_id', Auth::guard('admin')->user()->id)->latest()->value('amount');
            $clients = App\Models\Client::where('role', 1)->count();
            $category = App\Models\Category::count();
            $packages = App\Models\Package::count();
            $spanerAdmin = Auth::guard('admin')->user()->id;
            $total_colloection = App\Models\Payment::sum('paid');

            // this month transactions
            $flats = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->count();
            $expense = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            $income = App\Models\Income::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('paid');
            // $manualOpeningBalance = DB::table('opening_balances')->where('client_id', Auth::guard('admin')->user()->id)->where('entry_datetime', $date)->first();
            $others_income = DB::table('others_incomes')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            // $month_balance = App\Models\Balance::where('client_id', Auth::guard('admin')->user()->id)
            //     ->where('date', date('Y-m-d'))
            //     ->value('amount');
            $timestamp = strtotime(date('Y-m'));
            $month = date('n', $timestamp); // 'n' gives month without leading zeros
            $year = date('Y', $timestamp);
            $Monthly_Manual_Opening_Balance = DB::table('opening_balances')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->where('year', date('Y'))
                ->where('month', $month)
                ->first();

            $openingBlance = DB::table('balances')
                ->where('month', $month - 1)
                ->where('year', $year)
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->first();
        @endphp
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                @if ($spanerAdmin == 1001)
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total Clients</p>
                                    <h3>{{ $clients }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('client.all') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <p>Total Category</p>
                                    <h3>{{ $category }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('category.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>Total Packages</p>
                                    <h3>{{ $packages }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('category.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3>{{ number_format($total_colloection, 2) }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('collections.all') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card " style="margin-top: -20px !important">
                        <div class="card-header row ">
                            <h4><input value="{{ date('Y-m') }}" type="month" name="date" class="form-control text"
                                    id="date"></h4>
                        </div>
                    </div>
                    <div class="row" id="datewiseData">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3 id="flats">{{ $flat }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3 id="expense"><span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('expenses.month') }}" class="small-box-footer link">More info <i
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
                                    <h3 id="income"><span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('income.statement') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3 id="balance"><span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('blance.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row" id="todaydata">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3>{{ $flat }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3>{{ number_format($expense, 2) }}<span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('expenses.year') }}" class="small-box-footer link">More info <i
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
                                    <h3>{{ number_format($income ,2) }}<span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('income.statement') }}" class="small-box-footer link">More info <i
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
                                    <h3>{{ number_format($others_income, 2) }}<span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    @if (isset($Monthly_Manual_Opening_Balance))
                                        @if ($Monthly_Manual_Opening_Balance->flag == 1)
                                            <p>Opening Balance (Profit)</p>
                                            <h3>{{ number_format($Monthly_Manual_Opening_Balance->amount, 2) }}<span
                                                    style="font-size: 14px"> TK</span>
                                            </h3>
                                        @else
                                            <p>Opening Balance (Loss)</p>
                                            <h3>{{ number_format($Monthly_Manual_Opening_Balance->amount, 2) }}<span
                                                    style="font-size: 14px"> TK</span>
                                            </h3>
                                        @endif
                                    @elseif (isset($openingBlance))
                                        @if ($openingBlance->flag == 1)
                                            <p>Opening Balance </p>
                                            <h3>{{ number_format($openingBlance->amount , 2) }}<span style="font-size: 14px"> TK</span>
                                            </h3>
                                        @else
                                            <p>Opening Balance (Loss)</p>
                                            <h3>{{ number_format($openingBlance->amount , 2) }}<span style="font-size: 14px"> TK</span>
                                            </h3>
                                        @endif
                                    @else
                                        <p>Opening Balance </p>
                                        <h3>0.00<span style="font-size: 14px"> TK</span>
                                        </h3>
                                    @endif
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Balance</p>
                                    @if (isset($Monthly_Manual_Opening_Balance))
                                    
                                        @if ($Monthly_Manual_Opening_Balance->flag == 1)
                                            <h3>{{ number_format($income + $others_income + $Monthly_Manual_Opening_Balance->amount - $expense, 2) }}
                                                <span style="font-size: 14px"> TK</span></h3>
                                        @else
                                            <h3>{{ number_format($income + $others_income - ($expense + $Monthly_Manual_Opening_Balance->amount),2) }}
                                                <span style="font-size: 14px"> TK</span></h3>
                                        @endif
                                    @elseif (isset($openingBlance))
                                        @if ($openingBlance->flag == 1)
                                            <h3>{{ number_format($income + $others_income + $openingBlance->amount - $expense, 2) }}
                                                <span style="font-size: 14px"> TK</span></h3>
                                        @else
                                        <h3>{{ number_format($income + $others_income - ($expense + $openingBlance->amount), 2) }}
                                            <span style="font-size: 14px"> TK</span></h3>
                                        @endif
                                    @else
                                        <h3>0.00<span style="font-size: 14px"> TK</span>
                                        </h3>
                                    @endif
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('blance.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="title " style="font-size: 20px">Total Transactions</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total User</p>
                                    <h3>{{ $user }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('users.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3>{{ $flat }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3>{{ number_format($total_exp, 2) }}<span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('expenses.year') }}" class="small-box-footer link">More info <i
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
                                    <h3>{{ number_format($total_income, 2) }}<span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('income.statement') }}" class="small-box-footer link">More info <i
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
                                    <h3>{{ number_format($total_others_income, 2) }}<span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    @if (isset($manualOpeningBlance))
                                        @if ($manualOpeningBlance->flag == 1)
                                            <p>Opening Balance (Profit)</p>
                                            <h3>{{ number_format($manualOpeningBlance->amount, 2) }}<span style="font-size: 14px"> TK</span>
                                            </h3>
                                        @else
                                            <p>Opening Balance (Loss)</p>
                                            <h3>{{ number_format($manualOpeningBlance->amount, 2) }}<span style="font-size: 14px"> TK</span>
                                            </h3>
                                        @endif
                                    @else
                                        <p>Opening Balance </p>
                                        <h3>0.00<span style="font-size: 14px"> TK</span>
                                        </h3>
                                    @endif
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3>{{ number_format($balance, 2) }} <span style="font-size: 14px"> TK</span></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('blance.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                @endif
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
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
                    url: "{{ url('admin/get-transaction') }}/" + date,
                    dataType: "json",
                    success: function(res) {
                        console.log(res);
                        $('#flats').text(res.flats);
                        $('#expense').text(res.expense ? parseFloat(res.expense).toFixed(2) : 0);
                        $('#income').text(res.income ? parseFloat(res.income).toFixed(2) : 0);
                        // $('#manualOpeningBalance').text(res.manualOpeningBalance);
                        // $('#others_income').text(res.others_income);
                        $('#balance').text(res.balance ? parseFloat(res.balance).toFixed(2) : 0);
                    }
                });
            });
        });
    </script>

@endsection
