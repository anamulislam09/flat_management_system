@extends('user.user_layouts.user')

@section('user_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Balance Statement </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th class="d-none">Year</th>
                                            <th class="d-none">Month</th>
                                            <th>Expense</th>
                                            <th>Income</th>
                                            <th>Balance</th>
                                            <th>Flag</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="d-none">{{ $item->year }}</td>
                                                <td class="d-none">
                                                    @if ($item->month == 1)
                                                        January
                                                    @elseif ($item->month == 2)
                                                        February
                                                    @elseif ($item->month == 3)
                                                        March
                                                    @elseif ($item->month == 4)
                                                        April
                                                    @elseif ($item->month == 5)
                                                        May
                                                    @elseif ($item->month == 6)
                                                        June
                                                    @elseif ($item->month == 7)
                                                        July
                                                    @elseif ($item->month == 8)
                                                        August
                                                    @elseif ($item->month == 9)
                                                        September
                                                    @elseif ($item->month == 10)
                                                        October
                                                    @elseif ($item->month == 11)
                                                        November
                                                    @elseif ($item->month == 12)
                                                        December
                                                    @endif
                                                </td>

                                                <td>{{ $item->total_expense}}</td>
                                                <td>{{ $item->total_income}}</td>
                                                <td>{{ $item->amount}}</td>
                                                <td>
                                                    @if ($item->flag == 1)
                                                    <span class="badge badge-success">Profit</span>
                                                    @elseif ($item->flag == 0)
                                                    <span class="badge badge-danger">Loss</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

