@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-9 col-sm-12">
                                        <h3 class="card-title">Total Expense End of the Month</h3>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        {{-- <a href="{{ route('expense.create') }}" class="btn btn-outline-primary">Add New</a> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Year</th>
                                            <th>Month</th>
                                            <th>Total</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->year }}</td>

                                                <td>
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
                                                <td>{{ $item->total }}</td>
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
