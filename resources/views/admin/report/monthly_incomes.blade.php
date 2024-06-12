@extends('layouts.admin')

@section('admin_content')
<style>
    input:focus { outline: none; }
    @media screen and (max-width: 767px) {
        .card-title a { font-size: 15px; }
        table, thead, tbody, tr, td, th { font-size: 13px !important; padding: 5px !important; }
        .card-header { padding: .25rem 1.25rem; }
        .text { font-size: 14px !important; }
        .form { margin-bottom: 9px !important; width: 250px; float: left; }
        .form2 { float: right; width: 100px; }
    }
    .table td, .table th { padding: .30rem; vertical-align: top; border-top: 1px solid #dee2e6; font-size: 14px; }
    .text { font-size: 15px !important; }
</style>
<div class="content-wrapper">
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-center">
                            <h3 class="card-title pt-2">Monthly Income</h3>
                        </div>
                        <div class="card-header">
                            <form action="{{ route('handle.monthly.income') }}" method="post" class="row my-4">
                                @csrf
                                <div class="col-lg-3">
                                    <select name="year" class="form-control" required>
                                        <option value="" disabled>Select Year</option>
                                        @foreach (range(date("Y"), 2010) as $yearOption)
                                            <option value="{{ $yearOption }}" @if($yearOption == $year) selected @endif>{{ $yearOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select name="month" class="form-control" required>
                                        <option value="" disabled>Select Month</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" @if($i == $months) selected @endif>{{ date("F", mktime(0, 0, 0, $i, 10)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </form>
                        </div>

                        @if ($m_income || $m_other_income->isNotEmpty())
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-sm-6">
                                        <h3 class="card-title text">Total Income for the Month of <strong>{{ date('F', mktime(0, 0, 0, $months, 10)) }}</strong></h3>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        @if ($m_opening_balance)
                                            <h3 class="card-title text"><strong>
                                                Opening {{ $m_opening_balance->flag == 1 ? 'Balance' : 'Loss' }} {{ $m_opening_balance->flag == 1 ? $m_opening_balance->profit : '(' . $m_opening_balance->loss . ')' }}
                                            </strong></h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="8%">Sl</th>
                                            <th>Income Head</th>
                                            <th width="20%">Total Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-left">{{ $month->charge ?? 'Main Income' }}</td>
                                            <td class="text-right">{{ $m_income }}</td>
                                        </tr>
                                        @foreach ($m_other_income as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 2 }}</td>
                                                <td class="text-left">{{ $item->income_info }}</td>
                                                <td class="text-right">{{ $item->amount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $others_total = $m_other_income->sum('amount');
                                            $total_income_without_op = $m_income + $others_total;
                                            $total_income_with_op = $m_opening_balance
                                                ? ($m_opening_balance->flag == 1 ? $total_income_without_op + $m_opening_balance->profit : $total_income_without_op - $m_opening_balance->loss)
                                                : $total_income_without_op;
                                        @endphp
                                        <tr>
                                            <td colspan="2" class="text-right"><strong>Total Income without O/P:</strong></td>
                                            <td class="text-right"><strong>{{ $total_income_without_op }}</strong></td>
                                        </tr>
                                        @if ($m_opening_balance)
                                            <tr>
                                                <td colspan="2" class="text-right"><strong>Total Income with O/P:</strong></td>
                                                <td class="text-right"><strong>{{ $total_income_with_op }}</strong></td>
                                            </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <h5 class="text-center py-3 text">No Income Available</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
