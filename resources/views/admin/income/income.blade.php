@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none
        }

        table,
        thead,
        tbody,
        tr,
        td {
            font-size: 14px;
            padding: 5px !important;
            /* padding: .30rem; */
        }

        @media screen and (max-width: 767px) {
            .card-title a {
                font-size: 14px;
            }

            table,
            thead,
            tbody,
            tr,
            td {
                font-size: 14px;
                padding: 5px !important;
            }

            .text {
                font-size: 15px;
            }

            .button {
                margin-top: -0px !important;
            }

            .date {
                margin-bottom: 15px;
            }
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
                            <div class="card-header bg-primary">
                                <div class="row ">
                                    <div class="col-lg-10 col-sm-12">
                                        <h3 class="card-title text" style="width:100%; text-align:center">Service Charge
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('income.store') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                {{-- <div class="col-lg-3">
                                                    <strong><span>Service charge</span></strong>
                                                </div> --}}
                                                <div class="col-lg-3 date">
                                                    {{-- <label for="" class="col-form-label">Select Year</label> --}}
                                                    <select name="year" class="form-control text" id="">
                                                        <option value="" selected disabled>Select Year</option>
                                                        <option value="2023"
                                                            @if ('2023' == date('Y')) selected @endif>Year 2023
                                                        </option>
                                                        <option value="2024"
                                                            @if ('2024' == date('Y')) selected @endif>Year 2024
                                                        </option>
                                                        <option value="2025"
                                                            @if ('2025' == date('Y')) selected @endif>Year 2025
                                                        </option>
                                                        <option value="2026"
                                                            @if ('2026' == date('Y')) selected @endif>Year 2026
                                                        </option>
                                                        <option value="2027"
                                                            @if ('2027' == date('Y')) selected @endif>Year 2027
                                                        </option>
                                                        <option value="2028"
                                                            @if ('2028' == date('Y')) selected @endif>Year 2028
                                                        </option>
                                                        <option value="2029"
                                                            @if ('2029' == date('Y')) selected @endif>Year 2029
                                                        </option>
                                                        <option value="2030"
                                                            @if ('2030' == date('Y')) selected @endif>Year 2030
                                                        </option>
                                                    </select>
                                                </div>
                                                {{-- 'month', date('m'))->where('year', date('Y') --}}
                                                <div class="col-lg-3 date">
                                                    {{-- <label for="" class="col-form-label">Select Month</label> --}}
                                                    <select name="month" class="form-control text" id="">
                                                        <option value="" selected disabled>Select Month </option>
                                                        <option value="1"
                                                            @if ('1' == date('m')) selected @endif>January
                                                        </option>
                                                        <option value="2"
                                                            @if ('2' == date('m')) selected @endif>February
                                                        </option>
                                                        <option value="3"
                                                            @if ('3' == date('m')) selected @endif>March
                                                        </option>
                                                        <option value="4"
                                                            @if ('4' == date('m')) selected @endif>April
                                                        </option>
                                                        <option value="5"
                                                            @if ('5' == date('m')) selected @endif>May</option>
                                                        <option value="6"
                                                            @if ('6' == date('m')) selected @endif>June
                                                        </option>
                                                        <option value="7"
                                                            @if ('7' == date('m')) selected @endif>July
                                                        </option>
                                                        <option value="8"
                                                            @if ('8' == date('m')) selected @endif>August
                                                        </option>
                                                        <option value="9"
                                                            @if ('9' == date('m')) selected @endif>September
                                                        </option>
                                                        <option value="10"
                                                            @if ('10' == date('m')) selected @endif>October
                                                        </option>
                                                        <option value="11"
                                                            @if ('11' == date('m')) selected @endif>November
                                                        </option>
                                                        <option value="12"
                                                            @if ('12' == date('m')) selected @endif>December
                                                        </option>
                                                    </select>
                                                </div>

                                                @if (Route::current()->getName() == 'income.create')
                                                    <div class="col-lg-2">
                                                        <label for="" class="col-form-label"></label>
                                                        <input type="submit" class="btn btn-sm btn-primary text" value="Generate">
                                                    </div>
                                                @else
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            @if (count($data) > 1)
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 text">
                                                    Service Charge for the Month of <strong>
                                                        @if ('1' == date('m'))
                                                            January
                                                        @elseif ('2' == date('m'))
                                                            February
                                                        @elseif ('3' == date('m'))
                                                            March
                                                        @elseif ('4' == date('m'))
                                                            April
                                                        @elseif ('5' == date('m'))
                                                            May
                                                        @elseif ('6' == date('m'))
                                                            June
                                                        @elseif ('7' == date('m'))
                                                            July
                                                        @elseif ('8' == date('m'))
                                                            August
                                                        @elseif ('9' == date('m'))
                                                            September
                                                        @elseif ('10' == date('m'))
                                                            October
                                                        @elseif ('11' == date('m'))
                                                            November
                                                        @elseif ('12' == date('m'))
                                                            December
                                                        @endif - {{ date('Y') }}
                                                    </strong>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 text">
                                                    @if (isset($opening_balance) && !empty($data))
                                                        @if ($opening_balance->flag == 1)
                                                            <h3 class="card-title"><strong>Opening Balance
                                                                    {{ $opening_balance->profit }}</strong></h3>
                                                        @else
                                                            <h3 class="card-title"><strong>Opening Loss
                                                                    {{ $opening_balance->loss }}</strong></h3>
                                                        @endif
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="table-responsive">
                                                <table id="" class="table table-bordered table-striped mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th> SL</th>
                                                            <th>Flat Name</th>
                                                            {{-- <th>Charge</th> --}}
                                                            <th class="text-right">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @if (isset($data) && !empty($data)) --}}
                                                        @foreach ($data as $key => $item)
                                                            @php
                                                                $total = App\Models\Income::where('month', $item->month)
                                                                    ->where('year', $item->year)
                                                                    ->where(
                                                                        'client_id',
                                                                        Auth::guard('admin')->user()->id,
                                                                    )
                                                                    ->sum('amount');
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $key + 1 }}</td>
                                                                <td>{{ $item->flat_name }}</td>
                                                                {{-- <td>{{ $item->charge }}</td> --}}
                                                                <td class="text-right">{{ $item->amount }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2" class="text-right"> <strong>Total :</strong>
                                                            </td>
                                                            <td class="text-right"><strong>{{ $total }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <h5 class="text-center py-3 text">Data Not Found</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
@endsection
