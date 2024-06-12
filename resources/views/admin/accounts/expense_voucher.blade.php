@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none
        } 
        @media screen and (max-width: 767px) {
            .card-title a {
                font-size: 15px;
            }

            table,
            thead,
            tbody,
            tr,
            td,
            th {
                font-size: 13px !important;
                padding: 5px !important;
            }

            .card-header {
                padding: .25rem 1.25rem;
            }

            .text {
                font-size: 14px !important;
            }

            .form {
                margin-bottom: 9px !important;
            }
        }

        .table td,
        .table th {
            padding: .30rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }
        .text {
                font-size: 14px !important;
            }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 col-md-9 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Expense Voucher</h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('account.expense.all') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-4 col-md-4 col-sm-12 form">
                                                    <select name="year" class="form-control text" id="year" required>
                                                        @foreach (range(date('Y'), 2010) as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 form">
                                                    <select name="month" class="form-control text" id="month" required>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}"
                                                                @if ($i == date('m')) selected @endif>
                                                                {{ date('F', strtotime(date('Y') . '-' . $i . '-01')) }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-12">
                                                    <label for="" class="col-form-label"></label>
                                                    <input type="submit" class="btn btn-primary text" value="Submit">
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
                                                <div class="col-lg-9 col-md-8 col-sm-12 text form">
                                                    Total Expenses for the Month of
                                                    <strong class="text">  @if ($months->month == 1)
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
                                                        @endif </strong>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <form action="{{ route('account.expense.voucher.generateall') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="month" value="{{ $months->month }}">
                                                        <input type="hidden" name="year" value="{{ $months->year }}">

                                                        <label for="" class="col-form-label"></label>
                                                        <input type="submit" class="btn btn-sm btn-info text-end text"
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
                                                    <th>SL</th>
                                                    <th>Expense</th>
                                                    <th class="text-right">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key => $item)
                                                    @php
                                                        $data = DB::table('categories')
                                                            ->where('id', $item->cat_id)
                                                            ->first();
                                                        $sub_total = App\Models\Expense::where(
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
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td class="text-right">
                                                            {{ $sub_total }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" class="text-right"> <strong>Total :</strong></td>
                                                    <td class="text-right"><strong>{{ $total }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    @if (isset($month->month) && !empty($month->month))
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-8 col-sm-12 text form">
                                                        Total Expenses for the month of
                                                        <strong class="text"> @if ($month->month == 1)
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
                                                            @endif </strong>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <form action="{{ route('account.expense.voucher.generateall') }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="month"
                                                                value="{{ $month->month }}">
                                                            <input type="hidden" name="year"
                                                                value="{{ $month->year }}">

                                                            <label for="" class="col-form-label "></label>
                                                            <input type="submit" class="btn btn-sm btn-info text-end text"
                                                                value="Voucher all">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-bordered table-striped mt-3">
                                                <thead>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Expense</th>
                                                        <th class="text-right">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($exp as $key => $exp_item)
                                                        @php
                                                            $data = DB::table('categories')
                                                                ->where('id', $exp_item->cat_id)
                                                                ->first();
                                                            $sub_total = App\Models\Expense::where(
                                                                'client_id',
                                                                Auth::guard('admin')->user()->id,
                                                            )
                                                                ->where('month', $exp_item->month)
                                                                ->where('year', $exp_item->year)
                                                                ->where('cat_id', $exp_item->cat_id)
                                                                ->sum('amount');
                                                            $total = App\Models\Expense::where(
                                                                'client_id',
                                                                Auth::guard('admin')->user()->id,
                                                            )
                                                                ->where('month', $exp_item->month)
                                                                ->where('year', $exp_item->year)
                                                                ->sum('amount');
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">{{ $key + 1 }}</td>
                                                            <td>{{ $data->name }}</td>
                                                            <td class="text-right">
                                                                {{ $sub_total }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2" class="text-right"> <strong>Total :</strong></td>
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

    <!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit USer </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal_body">

                </div>

            </div>
        </div>
    </div>


    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
@endsection
