@extends('user.user_layouts.user')

@section('user_content')
<style>
    input:focus {
        outline: none
    }

    table,
    thead,
    tbody,
    tr,
    td,
    th {
        font-size: 14px !important;
        padding: 5px !important;
    }

    .text {
        font-size: 14px !important;
    }

    @media screen and (max-width: 767px) {

        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: right !important;
        }

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

        .button {
            margin-top: -0px !important;
        }
    }
</style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text" style="width:100%; text-align:center">Income Statement </h3>
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

                                                    $client = DB::table('clients')
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
                                                    @elseif ($client)
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
