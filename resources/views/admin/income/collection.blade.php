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
                                        <h3 class="card-title" style="width:100%; text-align:center text">Collection Entry
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (count($data) > 1)
                                    <div class="card">
                                        <div class="card-header text">
                                            Total Collection for the Month of<strong>
                                                <?php
                                                $currentMonth = date('F');
                                                echo "$currentMonth";
                                                ?>
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="" class="table table-bordered table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Flat Name</th>
                                                    <th>Current Amount</th>
                                                    <th>Previous Due</th>
                                                    <th>Payable</th>
                                                    <th>Balance</th>
                                                    <th>Paid</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($data as $key => $item)
                                                    @php
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
                                                                    <a href="{{ route('income.voucher.generate', $item->id) }}"
                                                                        target="_blank"><span
                                                                            class="badge badge-info">Voucher</span></a>
                                                                @elseif($item->status == 2)
                                                                    <span class="badge badge-warning">Due</span>
                                                                    <a
                                                                        href="{{ route('income.voucher.generate', $item->id) }}" target="_blank"><span
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
                                    <h5 class="text-center py-3 text">No Data Found</h5>
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
