@extends('user.user_layouts.user')

@section('user_content')
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
        /* padding: 5px !important; */
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
            /* padding: 5px !important; */
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
                                        <a href="{{ route('manager.ledger-posting.store') }}"
                                            class="btn btn-sm btn-primary button">Ledger
                                            Posting</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="" class="table table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Particulars</th>
                                                <th>SubTotal</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
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
                                            $user = App\Models\User::where('user_id', Auth::user()->user_id)->first();
                                            $openingBlance = DB::table('balances')
                                                ->where('month', $month - 1)
                                                ->where('year', $previousDate[0])
                                                ->where('client_id', $user->client_id)
                                                ->first();

                                            $manualOpeningBlance = DB::table('opening_balances')
                                                ->where('month', $month)
                                                ->where('year', $year)
                                                ->where('client_id', $user->client_id)
                                                ->first();

                                            // opening balannce of last year
                                            $lastYear = date('Y') - 1;
                                            $lastmonth = 12;

                                            $lastYopeningBlance = DB::table('balances')
                                                ->where('month', $lastmonth)
                                                ->where('year', $lastYear)
                                                ->where('client_id', $user->client_id)
                                                ->first();

                                            // total of this month
                                            $income = DB::table('incomes')
                                                ->where('month', $month)
                                                ->where('year', $year)
                                                ->where('client_id', $user->client_id)
                                                ->SUM('paid');

                                            $others_income = DB::table('others_incomes')
                                                ->where('month', $month)
                                                ->where('year', $year)
                                                ->where('client_id', $user->client_id)
                                                ->sum('amount');
                                        @endphp
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td colspan="1" class=""> <strong>Opening Balance </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                @if ($month == 1)
                                                    @if (!$lastYopeningBlance)
                                                        <td><strong>0.00</strong></td>
                                                    @else
                                                        @if ($lastYopeningBlance->flag == 1)
                                                            <td><strong>{{ number_format($lastYopeningBlance->amount, 2) }}</strong></td>
                                                        @else
                                                            <td><strong>({{ number_format($lastYopeningBlance->amount, 2) }})</strong></td>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if (!$openingBlance && !$manualOpeningBlance)
                                                        <td><strong>0.00</strong></td>
                                                    @elseif (!$openingBlance && $manualOpeningBlance)
                                                        {{-- <td><strong>000</strong></td> --}}
                                                        @if ($manualOpeningBlance->flag == 1)
                                                            <td><strong>{{ number_format($manualOpeningBlance->amount, 2) }}</strong></td>
                                                        @else
                                                            <td><strong>({{ number_format($manualOpeningBlance->amount, 2) }})</strong></td>
                                                        @endif
                                                    @else
                                                        @if ($openingBlance->flag == 1)
                                                            <td><strong>{{ number_format($openingBlance->amount, 2) }}</strong></td>
                                                        @else
                                                            <td><strong>({{ number_format($openingBlance->amount, 2) }})</strong></td>
                                                        @endif
                                                    @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td colspan="1">Total Collection of This
                                                    Month</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ number_format($income, 2) }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td colspan="1">Other Income of This
                                                    Month</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ number_format($others_income, 2) }}</td>
                                                <td>{{ number_format($income + $others_income, 2) }}</td>
                                            </tr>
                                            @if (count($expense) > 0)
                                                @foreach ($expense as $key => $item)
                                                    @php
                                                        $data = DB::table('categories')
                                                            ->where('id', $item->cat_id)
                                                            ->first();
                                                        $total_exp = App\Models\Expense::where(
                                                            'client_id',
                                                            $user->client_id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('cat_id', $item->cat_id)
                                                            ->sum('amount');
                                                        $total = App\Models\Expense::where(
                                                            'client_id',
                                                            $user->client_id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->sum('amount');
                                                    @endphp
                                                    <tr>
                                                        <td style="border-right:1px solid #ddd">{{ $key + 4 }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td>{{ number_format($total_exp, 2) }}</td>
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
                                                <td></td>
                                                <td colspan="2">Total Expenses of this month
                                                </td>
                                                @if (count($expense) > 0)
                                                    <td>{{ number_format($total, 2) }}</td>
                                                @else
                                                    <td>0.00</td>
                                                @endif
                                                <td></td>
                                                @if (count($expense) > 0)
                                                    <td>({{ number_format($total,2) }})</td>
                                                @else
                                                    <td>0.00</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="3"><strong>Total
                                                    </strong></td>
                                                @if (count($expense) > 0)
                                                    <td><strong>{{ number_format($total, 2) }}</strong></td>
                                                @else
                                                    <td><strong>0.00</strong></td>
                                                @endif
                                                <td><strong>{{ number_format($income + $others_income, 2) }}</strong></td>
                                                <td class="botderd">
                                                    @if (count($expense) > 0)
                                                        @if (!$openingBlance && !$manualOpeningBlance && !$others_income)
                                                            <strong
                                                                style="border-right:1px solid #ddd">{{ number_format($income - $total,2) }}</strong>
                                                        @elseif (!$openingBlance && !$manualOpeningBlance && $others_income)
                                                            <strong
                                                                style="border-right:1px solid #ddd">{{ number_format($income + $others_income - $total, 2) }}</strong>
                                                        @elseif (!$openingBlance && $manualOpeningBlance)
                                                            @if ($manualOpeningBlance->flag == 1)
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ number_format($manualOpeningBlance->amount + $income + $others_income - $total, 2) }}</strong>
                                                            @else
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ number_format($income + $others_income - $manualOpeningBlance->amount - $total, 2) }}</strong>
                                                            @endif
                                                        @elseif($openingBlance)
                                                            @if ($openingBlance->flag == 1)
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ number_format($openingBlance->amount + $income + $others_income - $total, 2) }}</strong>
                                                            @else
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ number_format($income + $others_income - $openingBlance->amount - $total, 2) }}</strong>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if (!$openingBlance && !$manualOpeningBlance && !$others_income)
                                                            <strong
                                                                style="border-right:1px solid #ddd">{{ number_format($income, 2) }}</strong>
                                                        @elseif (!$openingBlance && $manualOpeningBlance)
                                                            @if ($manualOpeningBlance->flag == 1)
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ number_format($manualOpeningBlance->amount + $income + $others_income, 2) }}</strong>
                                                            @else
                                                                <strong
                                                                    style="border-right:1px solid #ddd">{{ number_format($income + $others_income - $manualOpeningBlance->amount, 2) }}</strong>
                                                            @endif
                                                        @elseif($openingBlance)
                                                            @if ($openingBlance->flag == 1)
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ number_format($openingBlance->amount + $income + $others_income, 2) }}</strong>
                                                            @else
                                                                <strong style="border-right:1px solid #ddd">
                                                                    {{ number_format($income + $others_income - $openingBlance->amount, 2) }}</strong>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- <hr> --}}
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
