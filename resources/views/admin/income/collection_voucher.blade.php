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
            text-align: center;
        }

        .text {
            font-size: 15px;
        }

        @media screen and (max-width: 767px) {
            .card-title a {
                font-size: 15px;
            }

            table,
            thead,
            tbody,
            tr,
            td {
                font-size: 14px;
                padding: 0px !important;
                text-align: center;
            }

            .text {
                font-size: 14px;
            }

            .button {
                margin-top: 10px !important;
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

                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2 text" style="width:100%; text-align:center">Create Voucher </h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('income.collection.all') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-3 date">
                                                    <select name="year" class="form-control text" id="year"
                                                        required>
                                                        @foreach (range(date('Y'), 2010) as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select name="month" class="form-control text date" id="month"
                                                        required>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}"
                                                                @if ($i == $months) selected @endif>
                                                                {{ date('F', strtotime(date('Y') . '-' . $i . '-01')) }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="" class="col-form-label text"></label>
                                                    <input type="submit" class="btn btn-primary btn-sm text"
                                                        value="Filter">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @php
                                    $data = Session::get('data');
                                    $months = Session::get('months');
                                @endphp

                                @if (isset($data) && !empty($data))
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-10 text">
                                                    <strong> Total Collection for the Month dfgdsfgd of
                                                        <strong>
                                                            {{ date('F', mktime(0, 0, 0, $months->month, 10)) }}
                                                        </strong>
                                                    </strong>
                                                </div>
                                                <div class="col-2">
                                                    <form action="{{ route('income.voucher.generateall') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="month" value="{{ $months->month }}">
                                                        <input type="hidden" name="year" value="{{ $months->year }}">

                                                        <label for="" class="col-form-label"></label>
                                                        <input type="submit" formtarget="_blank"
                                                            class="btn btn-info text-end btn-sm text button"
                                                            value="Generate all">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="" class="table table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th style="width: 8%">SL</th>
                                                <th style="width: 20%">Flat Name</th>
                                                <th style="width: 20%" class="text-center">Payable</th>
                                                <th style="width: 20%" class="text-center">Paid Amount</th>
                                                <th style="width: 32%" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($data as $key => $item)
                                                @php

                                                    $total = App\Models\Income::where('month', $item->month)
                                                        ->where('year', $item->year)
                                                        ->where('status', '!=', 0)
                                                        ->where('client_id', Auth::guard('admin')->user()->id)
                                                        ->sum('paid');

                                                    $due = App\Models\Income::where('month', $item->month)
                                                        ->where('year', $item->year)
                                                        ->where('status', '!=', 0)
                                                        ->where('client_id', Auth::guard('admin')->user()->id)
                                                        ->sum('due');

                                                    $month = Carbon\Carbon::now()->month;
                                                    $year = Carbon\Carbon::now()->year;
                                                    $previousMonthData = App\Models\Income::where(
                                                        'month',
                                                        $item->month - 1,
                                                    )
                                                        ->where('year', $item->year)
                                                        ->where('flat_id', $item->flat_id)
                                                        ->where('client_id', Auth::guard('admin')->user()->id)
                                                        ->first();

                                                    $data = App\Models\Income::where('month', $item->month)
                                                        ->where('year', $item->year)
                                                        ->where('client_id', Auth::guard('admin')->user()->id)
                                                        ->where('flat_id', $item->flat_id)
                                                        ->first();
                                                    if (isset($previousMonthData->due)) {
                                                        $amount = $previousMonthData->due + $data->amount;
                                                    }

                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->flat_name }}</td>
                                                    @if (isset($previousMonthData->due) && !empty($previousMonthData->due))
                                                        <td class="text-right"> {{ $amount }}</td>
                                                    @else
                                                        @if (isset($data->amount) && !empty($data->amount))
                                                            <td class="text-right"> {{ $data->amount }}</td>
                                                        @else
                                                        @endif
                                                    @endif
                                                    <td class="text-right"> {{ $item->paid }}</td>
                                                    <td class="text-center"><a
                                                            href="{{ route('income.voucher.generate', $item->id) }}"
                                                            target="_blank" class="badge badge-info">Voucher</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-right"> <strong>Total :</strong></td>
                                                <td class="text-right"><strong>{{ $total + $due }}</strong></td>
                                                <td class="text-right"><strong>{{ $total }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    @if (isset($month) && !empty($month))
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-9 col-sm-12 text">
                                                        <strong> Total Collection for the Month of @if ($month->month == 1)
                                                                January
                                                            @elseif ($month->month == 2)
                                                                February
                                                            @elseif ($month->month == 3)
                                                                March
                                                            @elseif ($month->month == 4)
                                                                April
                                                            @elseif ($month->month == 5)
                                                                May
                                                            @elseif ($month->month == 6)
                                                                June
                                                            @elseif ($month->month == 7)
                                                                July
                                                            @elseif ($month->month == 8)
                                                                August
                                                            @elseif ($month->month == 9)
                                                                September
                                                            @elseif ($month->month == 10)
                                                                October
                                                            @elseif ($month->month == 11)
                                                                November
                                                            @elseif ($month->month == 12)
                                                                December
                                                            @endif - {{ $month->year }}</strong>
                                                    </div>
                                                    <div class="col-lg-2 col-md-3 col-sm-12">
                                                        <form action="{{ route('income.voucher.generateall') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="month"
                                                                value="{{ $month->month }}">
                                                            <input type="hidden" name="year"
                                                                value="{{ $month->year }}">

                                                            <label for="" class="col-form-label"></label>
                                                            <input type="submit"
                                                                class="btn btn-info text-end btn-sm text button"
                                                                formtarget="_blank" value="Generate all">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="" class="table table-bordered table-striped mt-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 8%">SL</th>
                                                        <th style="width: 20%">Flat Name</th>
                                                        <th style="width: 20%" class="text-center">Payable</th>
                                                        <th style="width: 20%" class="text-center">Paid Amount</th>
                                                        <th style="width: 32%" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($income as $key => $item)
                                                        @php

                                                            $total = App\Models\Income::where('month', $item->month)
                                                                ->where('year', $item->year)
                                                                ->where('status', '!=', 0)
                                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                                ->sum('paid');

                                                            $due = App\Models\Income::where('month', $item->month)
                                                                ->where('year', $item->year)
                                                                ->where('status', '!=', 0)
                                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                                ->sum('due');

                                                            $month = Carbon\Carbon::now()->month;
                                                            $year = Carbon\Carbon::now()->year;
                                                            $previousMonthData = App\Models\Income::where(
                                                                'month',
                                                                $item->month - 1,
                                                            )
                                                                ->where('year', $item->year)
                                                                ->where('flat_id', $item->flat_id)
                                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                                ->first();

                                                            $data = App\Models\Income::where('month', $item->month)
                                                                ->where('year', $item->year)
                                                                ->where('client_id', Auth::guard('admin')->user()->id)
                                                                ->where('flat_id', $item->flat_id)
                                                                ->first();
                                                            if (isset($previousMonthData->due)) {
                                                                $amount = $previousMonthData->due + $data->amount;
                                                            }

                                                        @endphp
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->flat_name }}</td>
                                                            @if (isset($previousMonthData->due) && !empty($previousMonthData->due))
                                                                <td class="text-right"> {{ $amount }}</td>
                                                            @else
                                                                @if (isset($data->amount) && !empty($data->amount))
                                                                    <td class="text-right"> {{ $data->amount }}</td>
                                                                @else
                                                                @endif
                                                            @endif
                                                            <td class="text-right"> {{ $item->paid }}</td>
                                                            <td class="text-center"><a
                                                                    href="{{ route('income.voucher.generate', $item->id) }}"
                                                                    class="badge badge-info" target="_blank">Voucher</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="text-right"> <strong>Total :</strong>
                                                        </td>
                                                        <td class="text-right"><strong>{{ $total + $due }}</strong></td>
                                                        <td class="text-right"><strong>{{ $total }}</strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @else
                                        <h5 class="text-center py-3 text">No Data Found</h5>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
@endsection
