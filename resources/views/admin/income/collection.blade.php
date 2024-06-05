@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none
        }

        .table td,
        .table th {
            padding: 0.4rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table tr td {
            text-align: center;
        }

        .table tr th {
            text-align: center;
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
                            <div class="card-header bg-primary">
                                <div class="row ">
                                    <div class="col-lg-10 col-sm-12 pt-2">
                                        <h3 class="card-title" style="width:100%; text-align:center">Collection Entry</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('income.store') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                {{-- <div class="col-lg-3">
                                                    <strong><span>Collection of Service Charge</span></strong>
                                                </div> --}}
                                                <div class="col-lg-3">
                                                    {{-- <label for="" class="col-form-label">Select Year</label> --}}
                                                    <select name="year" class="form-control" id="">
                                                        <option value="" selected disabled>Select Year</option>
                                                        <option value="2023"
                                                            @if ('2023' == date('Y')) selected @endif>Year 2023
                                                        </option>
                                                        <option value="2024"
                                                            @if ('2024' == date('Y')) selected @endif>Year 2024
                                                        </option>
                                                        <option value="2025"
                                                            @if ('2025' == date('Y')) selected @endif>Year 2025
                                                        </option>
                                                        <option value="2026"
                                                            @if ('2026' == date('Y')) selected @endif>Year 2026
                                                        </option>
                                                        <option value="2027"
                                                            @if ('2027' == date('Y')) selected @endif>Year 2027
                                                        </option>
                                                        <option value="2028"
                                                            @if ('2028' == date('Y')) selected @endif>Year 2028
                                                        </option>
                                                        <option value="2029"
                                                            @if ('2029' == date('Y')) selected @endif>Year 2029
                                                        </option>
                                                        <option value="2030"
                                                            @if ('2030' == date('Y')) selected @endif>Year 2030
                                                        </option>
                                                    </select>
                                                </div>
                                                {{-- 'month', date('m'))->where('year', date('Y') --}}
                                                <div class="col-lg-3">
                                                    {{-- <label for="" class="col-form-label">Select Month</label> --}}
                                                    <select name="month" class="form-control" id="">
                                                        <option value="" selected disabled>Select Month </option>
                                                        <option value="01"
                                                            @if ('01' == date('m')) selected @endif>January
                                                        </option>
                                                        <option value="02"
                                                            @if ('02' == date('m')) selected @endif>February
                                                        </option>
                                                        <option value="03"
                                                            @if ('03' == date('m')) selected @endif>March
                                                        </option>
                                                        <option value="04"
                                                            @if ('04' == date('m')) selected @endif>April
                                                        </option>
                                                        <option value="05"
                                                            @if ('05' == date('m')) selected @endif>May</option>
                                                        <option value="06"
                                                            @if ('06' == date('m')) selected @endif>June
                                                        </option>
                                                        <option value="07"
                                                            @if ('07' == date('m')) selected @endif>July
                                                        </option>
                                                        <option value="08"
                                                            @if ('08' == date('m')) selected @endif>August
                                                        </option>
                                                        <option value="09"
                                                            @if ('09' == date('m')) selected @endif>September
                                                        </option>
                                                        <option value="10"
                                                            @if ('10' == date('m')) selected @endif>October
                                                        </option>
                                                        <option value="11"
                                                            @if ('11' == date('m')) selected @endif>November
                                                        </option>
                                                        <option value="12"
                                                            @if ('12' == date('m')) selected @endif>December
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (count($data) > 1)
                                    <div class="card">
                                        <div class="card-header">
                                            <strong> Total Collection for the Month of @if ('1' == date('m'))
                                                    January
                                                @elseif ('2' == date('m'))
                                                    February
                                                @elseif ('3' == date('m'))
                                                    March
                                                @elseif ('4' == date('m'))
                                                    April
                                                @elseif ('5' == date('m'))
                                                    May
                                                @elseif ('6' == date('m'))
                                                    June
                                                @elseif ('7' == date('m'))
                                                    July
                                                @elseif ('8' == date('m'))
                                                    August
                                                @elseif ('9' == date('m'))
                                                    September
                                                @elseif ('10' == date('m'))
                                                    October
                                                @elseif ('11' == date('m'))
                                                    November
                                                @elseif ('12' == date('m'))
                                                    December
                                                @endif - {{ date('Y') }}</strong>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th style="width: 8%">SL</th>
                                                    <th style="width: 10%">Flat Name</th>
                                                    {{-- <th style="width: 15%">Charge</th> --}}
                                                    <th style="width: 15%">Current Amount</th>
                                                    <th style="width: 12%">Previous Due</th>
                                                    <th style="width: 10%">Payable</th>
                                                    <th style="width: 10%">Balance</th>
                                                    <th style="width: 10%">Paid</th>
                                                    <th style="width: 15%">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($data as $key => $item)
                                                    @php
                                                        // $month = Carbon::now()->month;
                                                        // $year = Carbon::now()->year;
                                                        $previousDate = explode(
                                                            '-',
                                                            date('Y-m', strtotime(date('Y-m') . ' -1 month')),
                                                        );

                                                        $previousMonthData = App\Models\Income::where(
                                                            'month',
                                                            $item->month - 1,
                                                        )
                                                            ->where('year', $previousDate[0])
                                                            ->where('flat_id', $item->flat_id)
                                                            ->where('client_id', Auth::guard('admin')->user()->id)
                                                            ->first();

                                                        // total all amount start here
                                                        $total = App\Models\Income::where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('client_id', Auth::guard('admin')->user()->id)
                                                            ->sum('amount');
                                                        $previous_total = App\Models\Income::where(
                                                            'month',
                                                            $item->month - 1,
                                                        )
                                                            ->where('year', $item->year)
                                                            ->where('client_id', Auth::guard('admin')->user()->id)
                                                            ->sum('due');
                                                        $current_total = App\Models\Income::where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('client_id', Auth::guard('admin')->user()->id)
                                                            ->sum('due');
                                                        $collect_total = App\Models\Income::where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('client_id', Auth::guard('admin')->user()->id)
                                                            ->sum('paid');
                                                        // total all amount ends here
                                                    @endphp

                                                    <form action="{{ route('income.collection.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="flat_id" value="{{ $item->flat_id }}">
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->flat_name }}</td>
                                                            {{-- <td>{{ $item->charge }}</td> --}}
                                                            <td>{{ $item->amount }}</td>
                                                            @if (!$previousMonthData)
                                                                <td>000</td>
                                                            @else
                                                                <td>{{ $previousMonthData->due }}</td>
                                                            @endif
                                                            @if (!$previousMonthData)
                                                                <td>{{ $item->amount }}</td>
                                                            @else
                                                                <td>{{ $item->amount + $previousMonthData->due }}</td>
                                                            @endif
                                                            <td>{{ $item->due }}</td>
                                                            <td><input type="text"
                                                                    style="width:100%; border:none; border-radius:20px; text-align:center"
                                                                    name="paid" value="{{ old('paid') }}"
                                                                    placeholder="000" required></td>
                                                            <td>
                                                                @if ($item->status == 1)
                                                                    <span class="badge badge-success">Paid</span>
                                                                    <a
                                                                        href="{{ route('income.voucher.generate', $item->id) }}"><span
                                                                            class="badge badge-info">Voucher</span></a>
                                                                @elseif($item->status == 2)
                                                                    <span class="badge badge-warning">Due</span>
                                                                    <a
                                                                        href="{{ route('income.voucher.generate', $item->id) }}"><span
                                                                            class="badge badge-info">Voucher</span></a>
                                                                @else
                                                                    <input type="submit" class="btn btn-sm btn-primary"
                                                                        value="Collect">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </form>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" class="text-right"> <strong>Total :</strong></td>
                                                    <td class="text-right"><strong>{{ $total }}</strong></td>
                                                    <td class="text-right"><strong>{{ $previous_total }}</strong></td>
                                                    <td class="text-right"><strong>{{ $total + $previous_total }}</strong>
                                                    </td>
                                                    <td class="text-right"><strong>{{ $current_total }}</strong></td>
                                                    <td class="text-right"><strong>{{ $collect_total }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <h5 class="text-center py-3">No Data Found</h5>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
@endsection
