@extends('user.user_layouts.user')

@section('user_content')
   
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
    .text { font-size: 14px !important; }
</style>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-9 col-sm-12">
                    <div class="card">
                        <div class="card-header bg-primary text-center">
                            <h3 class="card-title text" style="width:100%; text-align:center">Yearly Income</h3>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-12" style="border: 1px solid #ddd">
                                    <form action="{{ route('manager.incomesall.year') }}" method="post">
                                        @csrf
                                        <div class="row my-4">
                                            <div class="col-lg-5 col-md-5 col-sm-12 form">
                                                <select name="year" class="form-control text" id="year" required>
                                                    @foreach (range(date('Y'), 2010) as $yr)
                                                        <option value="{{ $yr }}" @if($yr == session('currentYear', $currentYear)) selected @endif>{{ $yr }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <label for="" class="col-form-label"></label>
                                                <input type="submit" class="btn btn-primary text" value="Filter">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @php
                            $yearly_income = session('yearly_income', $y_income);
                            $currentYear = session('currentYear', $currentYear);
                            $years = session('year', $years);
                            $opening_balance = session('opening_balance', $y_opening_balance);
                            $others_income = session('others_income', $y_other_income);
                        @endphp

                        @if ($yearly_income == 0)
                            <h5 class="text-center py-3 text">No Data Found</h5>
                        @else
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <h3 class="card-title text form">Total Income For The Year of <strong>{{ $currentYear }}</strong></h3>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        @if ($opening_balance)
                                            <h3 class="card-title text"><strong>
                                                Opening {{ $opening_balance->flag == 1 ? 'Balance' : 'Loss' }} {{ $opening_balance->flag == 1 ? $opening_balance->profit : $opening_balance->loss }}
                                            </strong></h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="" class="table table-bordered table-striped">
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
                                            <td class="text-left">{{ $years->charge }}</td>
                                            <td class="text-right">{{ $yearly_income }}</td>
                                        </tr>
                                        @foreach ($others_income as $key => $item)
                                            @php
                                              $user = App\Models\User::where(
                                                        'user_id',
                                                        Auth::user()->user_id,
                                                    )->first();
                                                $others_total = App\Models\OthersIncome::where('year', $item->year)
                                                    ->where('client_id', $user->client_id)
                                                    ->sum('amount');
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $key + 2 }}</td>
                                                <td class="text-left">{{ $item->income_info }}</td>
                                                <td class="text-right">{{ $item->amount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $total_income_without_op = $yearly_income + $others_total;
                                            $total_income_with_op = $opening_balance
                                                ? ($opening_balance->flag == 1 ? $total_income_without_op + $opening_balance->profit : $total_income_without_op - $opening_balance->loss)
                                                : $total_income_without_op;
                                        @endphp
                                        <tr>
                                            <td colspan="2" class="text-right"><strong>Total Income without O/P:</strong></td>
                                            <td class="text-right"><strong>{{ $total_income_without_op }}</strong></td>
                                        </tr>
                                        @if ($opening_balance)
                                            <tr>
                                                <td colspan="2" class="text-right"><strong>Total Income with O/P:</strong></td>
                                                <td class="text-right"><strong>{{ $total_income_with_op }}</strong></td>
                                            </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
