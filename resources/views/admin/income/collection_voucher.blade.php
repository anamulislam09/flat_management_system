@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Create Voucher </h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('income.collection.all') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-3">
                                                    <select name="year" class="form-control" id="year" required>
                                                        @foreach (range(date('Y'), 2010) as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select name="month" class="form-control" id="month" required>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}"
                                                                @if ($i == date('m')) selected @endif>
                                                                {{ date('F', strtotime(date('Y') . '-' . $i . '-01')) }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label for="" class="col-form-label"></label>
                                                    <input type="submit" class="btn btn-primary" value="Submit">
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
                                    {{-- @php   
                    @foreach ($data as $key => $item)
                    $month = Ap\Models\Income::where('month', $item->month)->where('year', $item->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
                    @endforeach
             @endphp --}}
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-10">
                                                    <strong> Total Collection for the Month dfgdsfgd of @if ($months->month == 1)
                                                            January
                                                        @elseif ($months->month == 2)
                                                            February
                                                        @elseif ($months->month == 3)
                                                            March
                                                        @elseif ($months->month == 4)
                                                            April
                                                        @elseif ($months->month == 5)
                                                            May
                                                        @elseif ($months->month == 6)
                                                            June
                                                        @elseif ($months->month == 7)
                                                            July
                                                        @elseif ($months->month == 8)
                                                            August
                                                        @elseif ($months->month == 9)
                                                            September
                                                        @elseif ($months->month == 10)
                                                            October
                                                        @elseif ($months->month == 11)
                                                            November
                                                        @elseif ($months->month == 12)
                                                            December
                                                        @endif - {{ $months->year }}</strong>
                                                </div>
                                                <div class="col-2">
                                                    <form action="{{ route('income.voucher.generateall') }}" method="post"  >
                                                        @csrf
                                                        <input type="hidden" name="month" value="{{ $months->month }}">
                                                        <input type="hidden" name="year" value="{{ $months->year }}">

                                                        <label for="" class="col-form-label"></label>
                                                        <input type="submit" formtarget="_blank" class="btn btn-info text-end"
                                                            value="Generate all">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="dataTable" class="table table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th style="width: 8%">SL</th>
                                                <th>Flat Name</th>
                                                <th style="width: 15%" class="text-center">Payable</th>
                                                <th style="width: 15%" class="text-center">Paid Amount</th>
                                                <th style="width: 15%" class="text-center">Action</th>
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
                                                            href="{{ route('income.voucher.generate', $item->id) }}" target="_blank"
                                                            class="btn btn-sm btn-info">Voucher</a></td>
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
                                                    <div class="col-10">
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
                                                    <div class="col-2">
                                                        <form action="{{ route('income.voucher.generateall') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="month"
                                                                value="{{ $month->month }}">
                                                            <input type="hidden" name="year"
                                                                value="{{ $month->year }}">

                                                            <label for="" class="col-form-label"></label>
                                                            <input type="submit" class="btn btn-info text-end" formtarget="_blank"
                                                                value="Generate all">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-bordered table-striped mt-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 8%">SL</th>
                                                        <th>Flat Name</th>
                                                        <th style="width: 15%" class="text-center">Payable</th>
                                                        <th style="width: 15%" class="text-center">Paid Amount</th>
                                                        <th style="width: 15%" class="text-center">Action</th>
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
                                                                    class="btn btn-sm btn-info" target="_blank">Voucher</a></td>
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
                                        <h5 class="text-center py-3">No Data Found</h5>
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
