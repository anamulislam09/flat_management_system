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

        table, thead, tbody, tr, td, th {
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
            width: 250px;
            float: left;
        }

        .form2 {
            float: right;
            width: 100px;
        }
    }

    .table td, .table th {
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
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-7 col-sm-12">
                    <div class="card">
                        <div class="card-header bg-primary text-center">
                            <h3 class="card-title text" style="width:100%; text-align:center">Yearly Expenses</h3>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-12" style="border: 1px solid #ddd">
                                    <form action="{{ route('expensesall.year') }}" method="post">
                                        @csrf
                                        <div class="row my-4">
                                            <div class="col-lg-7 col-md-8 col-sm-8 form">
                                                <select name="year" class="form-control text" id="year" required>
                                                    @foreach (range(date('Y'), 2010) as $yr)
                                                        <option value="{{ $yr }}" @if($yr == session('currentYear', $currentYear)) selected @endif>{{ $yr }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 form2">
                                                <label for="" class="col-form-label"></label>
                                                <input type="submit" class="btn btn-sm btn-primary text" value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                $yearly_expense = session('yearly_expense', $yearly_expense);
                                $currentYear = session('currentYear', $currentYear);
                            @endphp

                            @if ($yearly_expense->isEmpty())
                                <h5 class="text-center py-3 text">No Data Found</h5>
                            @else
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-12 text">
                                                Total Expenses For The Year of <strong>{{ $currentYear }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table id="" class="table table-bordered table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Expense Head</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($yearly_expense as $key => $item)
                                            @php
                                                $data = DB::table('categories')
                                                    ->where('id', $item->cat_id)
                                                    ->first();
                                                $sub_total = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)
                                                    ->where('year', $item->year)
                                                    ->where('cat_id', $item->cat_id)
                                                    ->sum('amount');
                                                $total = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)
                                                    ->where('year', $item->year)
                                                    ->sum('amount');
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td class="text-right">{{ $sub_total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-right"><strong>Total :</strong></td>
                                            <td class="text-right"><strong>{{ $total }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
