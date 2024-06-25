@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none;
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
                float: left;
            }

            .form2 {
                float: right;
                width: 100px;
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
            font-size: 15px !important;
        }
    </style>
    <div class="content-wrapper">
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 col-md-9 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text" style="width:100%; text-align:center">Expense Voucher</h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('account.expense.all') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-4 col-md-4 col-sm-12 form">
                                                    <select name="year" class="form-control text" id="year"
                                                        required>
                                                        @foreach (range(date('Y'), 2010) as $yearOption)
                                                            <option value="{{ $yearOption }}"
                                                                @if ($yearOption == $year) selected @endif>
                                                                {{ $yearOption }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12 form">
                                                    <select name="month" class="form-control text" id="month"
                                                        required>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}"
                                                                @if ($i == $months) selected @endif>
                                                                {{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-12">
                                                    <label for="" class="col-form-label"></label>
                                                    <input type="submit" class="btn btn-primary text" value="Filter">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (session('message'))
                                    <div class="alert alert-warning">{{ session('message') }}</div>
                                @endif

                                @if ($monthly_exp->isNotEmpty())
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-lg-9 col-md-8 col-sm-12 text form">
                                                    Total Expenses for the Month of
                                                    <strong class="text">
                                                        {{ date('F', mktime(0, 0, 0, $months, 10)) }}
                                                    </strong>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-12">
                                                    <form action="{{ route('account.expense.voucher.generateall') }}"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="month" value="{{ $months }}">
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <label for="" class="col-form-label"></label>
                                                        <input type="submit" class="btn btn-sm btn-info text-end text"
                                                            value="Generate all">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="" class="table table-bordered table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Expense</th>
                                                    <th class="text-right">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($monthly_exp as $key => $item)
                                                    @php
                                                        $category = DB::table('categories')
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
                                                        <td>{{ $category->name }}</td>
                                                        <td class="text-right">{{ $sub_total }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" class="text-right"> <strong>Total :</strong></td>
                                                    <td class="text-right">
                                                        <strong>{{ $total }}</strong></td>
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
@endsection
