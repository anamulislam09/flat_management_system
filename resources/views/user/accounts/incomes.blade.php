@extends('user.user_layouts.user')

@section('user_content')
    <style>
        input:focus {
            outline: none
        }

        .table td,
        .table th {
            padding: 0.4rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table tr td {
            text-align: center;
        }

        .table tr th {
            text-align: center;
        }
    </style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-lg-12">
                                    <h3 class="card-title">Income Statement</h3>
                                </div>
                            </div>
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Income Statement </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>SL </th>
                                                <th class="d-none">Year</th>
                                                <th class="d-none">Month</th>
                                                <th>Flat Name</th>
                                                <th>Charge</th>
                                                <th>Amount</th>
                                                <th>Collection</th>
                                                <th>Payble</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $key => $item)
                                                @php
                                                    $user = DB::table('users')
                                                        ->where('user_id', $item->auth_id)
                                                        ->exists();
                                                    $userName = DB::table('users')
                                                        ->where('user_id', $item->auth_id)
                                                        ->first();

                                                    $customer = DB::table('customers')
                                                        ->where('id', $item->client_id)
                                                        ->exists();

                                                    $data = DB::table('categories')
                                                        ->where('id', $item->cat_id)
                                                        ->first();

                                                    $id = App\Models\User::where(
                                                        'user_id',
                                                        Auth::user()->user_id,
                                                    )->first();
                                                    $total = App\Models\Income::where(
                                                        'client_id',
                                                        $id->client_id,
                                                    )->sum('amount');
                                                    $collection = App\Models\Income::where(
                                                        'client_id',
                                                        $id->client_id,
                                                    )->sum('paid');
                                                @endphp
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
                                                    <td>{{ $item->flat_name }}</td>
                                                    <td>{{ $item->charge }}</td>
                                                    <td>{{ $item->amount }}</td>
                                                    <td>{{ $item->paid }}</td>
                                                    <td>{{ $item->due }}</td>
                                                    @if ($user)
                                                        <td>{{ $userName->name }}</td>
                                                    @elseif ($customer)
                                                        <td><span class="badge badge-success">Admin</span></td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @if (isset($data))
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-right"> <strong>Total :</strong></td>
                                                <td class="text-right"><strong>{{ $total }}</strong></td>
                                                @if (isset($collection))
                                                    <td class="text-right"><strong>{{ $collection }}</strong></td>
                                                    <td class="text-right"><strong>{{ $total - $collection }}</strong></td>
                                                @else
                                                    <td class="text-right"><strong>00</strong></td>
                                                    <td class="text-right"><strong>{{ $total }}</strong></td>
                                                @endif
                                                <td></td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script> --}}
@endsection
