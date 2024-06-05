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
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Monthly Expenses </h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('expensesall.month') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-3">
                                                    <select name="year" class="form-control" id="year" required>
                                                        @foreach (range( date("Y"),2010) as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select name="month" class="form-control" id="month" required>
                                                        @for ($i = 1 ; $i <= 12; $i++)
                                                                <option value="{{ $i }}" @if($i==date('m')) selected @endif>{{ date("F",strtotime(date("Y")."-".$i."-01")) }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                {{-- @if (Route::current()->getName() == 'income.create') --}}
                                                <div class="col-lg-2">
                                                    <label for="" class="col-form-label"></label>
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                </div>
                                                {{-- @else --}}
                                                {{-- @endif --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @php
                                    $monthly_expense = Session::get('monthly_expense');
                                    $months = Session::get('months');
                                @endphp
                                @if (isset($monthly_expense) && !empty($monthly_expense))
                                    {{-- @php   
                    @foreach ($data as $key => $item)
                    $month = Ap\Models\Income::where('month', $item->month)->where('year', $item->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
                    @endforeach
             @endphp --}}
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-9">
                                                    <strong> Total Expenses For The Month of @if ($months->month == 1)
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
                                            </div>
                                        </div>
                                    </div>

                                    <table id="" class="table table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th style="width: 8%">SL</th>
                                                <th>Expense Head</th>
                                                <th style="width: 20%">Amount</th>
                                                {{-- <th style="width: 15%" class="text-center">Status</th> --}}
                                                {{-- <th style="width: 15%" class="text-center">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>



                                            @foreach ($monthly_expense as $key => $item)
                                                @php
                                                    $data = DB::table('categories')
                                                        ->where('id', $item->cat_id)
                                                        ->first();

                                                    $sub_total = App\Models\Exp_detail::where(
                                                        'client_id',
                                                        Auth::guard('admin')->user()->id,
                                                    )
                                                        ->where('month', $item->month)
                                                        ->where('year', $item->year)
                                                        ->where('cat_id', $item->cat_id)
                                                        ->sum('amount');
                                                    $total = App\Models\Exp_detail::where(
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
                                @else
                                    @if (isset($month->month) && !empty($month->month))
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <strong> Total Expenses For The Month of @if ($month->month == 1)
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
                                                </div>
                                            </div>
                                        </div>

                                        <table id="" class="table table-bordered table-striped mt-3">
                                            <thead>
                                                <tr>
                                                    <th style="width: 8%">SL</th>
                                                    <th>Expense Head</th>
                                                    <th style="width: 20%">Amount</th>
                                                    {{-- <th style="width: 15%" class="text-center">Status</th> --}}
                                                    {{-- <th style="width: 15%" class="text-center">Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>



                                                @foreach ($monthly_exp as $key => $exp_item)
                                                    @php
                                                        $data = DB::table('categories')
                                                            ->where('id', $exp_item->cat_id)
                                                            ->first();

                                                        $sub_total = App\Models\Exp_detail::where(
                                                            'client_id',
                                                            Auth::guard('admin')->user()->id,
                                                        )
                                                            ->where('month', $exp_item->month)
                                                            ->where('year', $exp_item->year)
                                                            ->where('cat_id', $exp_item->cat_id)
                                                            ->sum('amount');
                                                        $total = App\Models\Exp_detail::where(
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
