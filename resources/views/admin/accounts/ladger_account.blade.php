@extends('layouts.admin')

@section('admin_content')
<style>
    input:focus {
        outline: none
    }

    table,
    thead,
    tbody,
    tr,
    td {
        font-size: 14px;
        padding: 5px !important;
        /* padding: .30rem; */
    }
    .text {
            font-size: 15px;
        }

    @media screen and (max-width: 767px) {
        .card-title a {
            font-size: 14px;
        }

        table,
        thead,
        tbody,
        tr,
        td {
            font-size: 14px;
            padding: 5px !important;
        }

        .text {
            font-size: 14px;
        }

        .button {
            margin-top: 5px !important;
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
                                <h3 class="card-title" style="width:100%; text-align:center">Ledger Account </h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-10 col-md-9 col-sm-12">
                                        @php
                                            $month = Carbon\Carbon::now()->month;
                                            $year = Carbon\Carbon::now()->year;
                                        @endphp
                                        <h3 class="card-title text">Account for the Month of
                                            <strong>{{ date('F', strtotime(date('Y'))) }} -{{ date('Y') }}</strong>

                                            </strong>
                                        </h3>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-12">
                                        <a href="{{ route('ledger-posting.store') }}"
                                            class="btn btn-sm btn-primary button">Ledger
                                            Posting</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                {{-- <th>Year</th>
                      <th>Month</th> --}}
                                                <th>Expense</th>
                                                <th>SubTotal</th>
                                                <th>Total Cost</th>
                                                <th>Income</th>
                                                <th>Balance</th>
                                        </thead>
                                        @php
                                            $month = Carbon\Carbon::now()->month;
                                            $year = Carbon\Carbon::now()->year;
                                            // oprning blance of this year
                                            $previousDate = explode(
                                                '-',
                                                date('Y-m', strtotime(date('Y-m') . ' -1 month')),
                                            );

                                            $openingBlance = DB::table('balances')
                                                ->where('month', $month - 1)
                                                ->where('year', $previousDate[0])
                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                ->first();

                                            $manualOpeningBlance = DB::table('opening_balances')
                                                ->where('month', $month)
                                                ->where('year', $year)
                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                ->first();

                                            // opening balannce of last year
                                            $lastYear = date('Y') - 1;
                                            $lastmonth = 12;

                                            $lastYopeningBlance = DB::table('balances')
                                                ->where('month', $lastmonth)
                                                ->where('year', $lastYear)
                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                ->first();

                                            // total of this month
                                            $income = DB::table('incomes')
                                                ->where('month', $month)
                                                ->where('year', $year)
                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                ->SUM('paid');

                                            $others_income = DB::table('others_incomes')
                                                ->where('month', $month)
                                                ->where('year', $year)
                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                ->sum('amount');
                                        @endphp
                                        <tbody>
                                            <tr>
                                                <td colspan="5" class=""> <strong>Opening
                                                        Balance</strong></td>
                                                @if ($month == 1)
                                                    @if (!$lastYopeningBlance)
                                                        <td><strong>00</strong></td>
                                                    @else
                                                        @if ($lastYopeningBlance->flag == 1)
                                                            <td><strong>{{ $lastYopeningBlance->amount }}</strong></td>
                                                        @else
                                                            <td><strong>({{ $lastYopeningBlance->amount }})</strong></td>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if (!$openingBlance && !$manualOpeningBlance)
                                                        <td><strong>0</strong></td>
                                                    @elseif (!$openingBlance && $manualOpeningBlance)
                                                        {{-- <td><strong>000</strong></td> --}}
                                                        @if ($manualOpeningBlance->flag == 1)
                                                            <td><strong>{{ $manualOpeningBlance->profit }}</strong></td>
                                                        @else
                                                            <td><strong>({{ $manualOpeningBlance->loss }})</strong></td>
                                                        @endif
                                                    @else
                                                        @if ($openingBlance->flag == 1)
                                                            <td><strong>{{ $openingBlance->amount }}</strong></td>
                                                        @else
                                                            <td><strong>({{ $openingBlance->amount }})</strong></td>
                                                        @endif
                                                    @endif
                                                @endif
                                            </tr>
                                            @if (count($expense) > 0)
                                                @foreach ($expense as $key => $item)
                                                    @php
                                                        $data = DB::table('categories')
                                                            ->where('id', $item->cat_id)
                                                            ->first();
                                                        $total_exp = App\Models\Expense::where(
                                                            'client_id',
                                                            Auth::guard('admin')->user()->id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('cat_id', $item->cat_id)
                                                            ->sum('amount');
                                                        $total = App\Models\Expense::where(
                                                            'client_id',
                                                            Auth::guard('admin')->user()->id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->sum('amount');
                                                    @endphp
                                                    <tr>
                                                        <td style="border-right:1px solid #ddd">{{ $key + 1 }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td>{{ $total_exp }}</td>
                                                        <td rowspan=""></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6">NO Expense Available</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="3"><strong>Total Cost of This Month
                                                    </strong></td>
                                                @if (count($expense) > 0)
                                                    <td><strong>{{ $total }}</strong></td>
                                                @else
                                                    <td><strong>0</strong></td>
                                                @endif
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><strong>Total Income of This
                                                        Month</strong></td>
                                                <td><strong>{{ $income }}</strong></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><strong>Other Income of This
                                                        Month</strong></td>
                                                <td><strong>{{ $others_income }}</strong></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"><strong>Balance of This Month
                                                    </strong></td>
                                                <td>
                                                    @if (count($expense) > 0)
                                                        @if (!$openingBlance && !$manualOpeningBlance && !$others_income)
                                                            <strong
                                                                style="border-right:1px solid #ddd">{{ $income - $total }}</strong>
                                                        @elseif (!$openingBlance && !$manualOpeningBlance && $others_income)
                                                            <strong
                                                                style="border-right:1px solid #ddd">{{ $income + $others_income - $total }}</strong>
                                                        @elseif (!$openingBlance && $manualOpeningBlance)
                                                            @if ($manualOpeningBlance->flag == 1)
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ $manualOpeningBlance->profit + $income + $others_income - $total }}</strong>
                                                            @else
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ $income + $others_income - $manualOpeningBlance->loss - $total }}</strong>
                                                            @endif
                                                        @elseif($openingBlance)
                                                            @if ($openingBlance->flag == 1)
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ $openingBlance->amount + $income + $others_income - $total }}</strong>
                                                            @else
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ $income + $others_income - $openingBlance->amount - $total }}</strong>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if (!$openingBlance && !$manualOpeningBlance && !$others_income)
                                                            <strong
                                                                style="border-right:1px solid #ddd">{{ $income }}</strong>
                                                        @elseif (!$openingBlance && $manualOpeningBlance)
                                                            @if ($manualOpeningBlance->flag == 1)
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ $manualOpeningBlance->profit + $income + $others_income }}</strong>
                                                            @else
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ $income + $others_income - $manualOpeningBlance->loss }}</strong>
                                                            @endif
                                                        @elseif($openingBlance)
                                                            @if ($openingBlance->flag == 1)
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ $openingBlance->amount + $income + $others_income }}</strong>
                                                            @else
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ $income + $others_income - $openingBlance->amount }}</strong>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
