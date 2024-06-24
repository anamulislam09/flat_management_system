@extends('layouts.admin')

@section('admin_content')
    <style>
        @media screen and (max-width: 767px) {

            table,
            thead,
            tbody,
            tr,
            td {
                font-size: 14px;
            }

            .text {
                font-size: 14px !important;
            }

            .button {
                font-size: 14px;
            }

            .voucher {
                margin-top: 7px;
            }
        }

        .text {
            font-size: 14px !important;
        }

        table,
        thead,
        tbody,
        tr,
        td {
            font-size: 14px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <h3 class="card-title d-block text">Expense Summary for the Month of <strong>
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
                                                @endif - {{ date('Y') }}</h3></strong>
                                    </div>

                                    @if (count($expSummary) < 1)
                                    @else
                                        <div class="col-lg-2 col-md-2 col-sm-4 voucher">
                                            <a href="{{ route('expense.voucher.generateall') }}" target="_blank"
                                                class="btn btn-sm btn-light button">Voucher</a>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (count($expSummary) < 1)
                                    <div class="card">
                                        <div class="card-header text-center">
                                            {{-- <strong><span>Data not Found!</span></strong> --}}
                                            <section class="page_404">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12 col-md-12 col-sm-12">
                                                            <div class="col-sm-12 text-center">
                                                                <div class="contant_box_404 text">
                                                                    <h3 class="h2">
                                                                        Expense Not Found!
                                                                    </h3>
                                                                    <p>Pls! Expense Create First</p>
                                                                    <a href="{{ route('expense.create') }}"
                                                                        class="link_404 btn btn-primary">Create Expense
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table id="" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">SL</th>
                                                    <th class="text-center">Expense</th>
                                                    <th class="text-center">Amount</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($expSummary as $key => $item)
                                                    @php
                                                        $data = DB::table('categories')
                                                            ->where('id', $item->cat_id)
                                                            ->first();
                                                        $amount = App\Models\Expense::where(
                                                            'client_id',
                                                            Auth::guard('admin')->user()->id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('cat_id', $item->cat_id)
                                                            ->sum('amount');
                                                        // dd($amount);
                                                        $total = App\Models\Expense::where(
                                                            'client_id',
                                                            Auth::guard('admin')->user()->id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->sum('amount');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td class="text-right">{{ $amount }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" class="text-right"> <strong>Total :</strong></td>
                                                    <td class="text-right"><strong>{{ $total }}</strong></td>
                                                </tr>
                                            </tfoot>
                                @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
