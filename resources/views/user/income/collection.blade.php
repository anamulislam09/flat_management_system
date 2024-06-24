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
                            <div class="card-header bg-primary">
                                <div class="row ">
                                    <div class="col-lg-10 col-sm-12 pt-2">
                                        <h3 class="card-title text" style="width:100%; text-align:center">Collection Entry
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (count($data) > 1)
                                    <div class="card">
                                        <div class="card-header text">
                                            Total Collection for the Month of
                                            <strong>
                                                @if ('1' == date('m'))
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
                                                @endif - {{ date('Y') }}
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th style="width: 8%">SL</th>
                                                    <th style="width: 10%">Flat Name</th>
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
                                                        $user = App\Models\User::where(
                                                            'user_id',
                                                            Auth::user()->user_id,
                                                        )->first();
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
                                                            ->where('client_id', $user->client_id)
                                                            ->first();

                                                        // total all amount start here
                                                        $total = App\Models\Income::where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('client_id', $user->client_id)
                                                            ->sum('amount');
                                                        $previous_total = App\Models\Income::where(
                                                            'month',
                                                            $item->month - 1,
                                                        )
                                                            ->where('year', $item->year)
                                                            ->where('client_id', $user->client_id)
                                                            ->sum('due');
                                                        $current_total = App\Models\Income::where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('client_id', $user->client_id)
                                                            ->sum('due');
                                                        $collect_total = App\Models\Income::where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('client_id', $user->client_id)
                                                            ->sum('paid');
                                                        // total all amount ends here
                                                    @endphp

                                                    <form action="{{ route('manager.income.collection.store') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="flat_id" value="{{ $item->flat_id }}">
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->flat_name }}</td>
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
                                                                        href="{{ route('manager.income.voucher.generate', $item->id) }}"><span
                                                                            class="badge badge-info">Voucher</span></a>
                                                                @elseif($item->status == 2)
                                                                    <span class="badge badge-warning">Due</span>
                                                                    <a
                                                                        href="{{ route('manager.income.voucher.generate', $item->id) }}" target="_blank"><span
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
                                    @else
                                        <h5 class="text-center py-3 text">No Data Found</h5>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
