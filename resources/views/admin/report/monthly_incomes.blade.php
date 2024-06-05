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
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Monthly Income </h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('incomesall.month') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                {{-- <div class="col-lg-3">
                                                    <select name="year" class="form-control" id="" required>
                                                        <option value="" selected disabled>Select Year</option>
                                                        <option value="2023">Year 2023
                                                        </option>
                                                        <option value="2024">Year 2024
                                                        </option>
                                                        <option value="2025">Year 2025
                                                        </option>
                                                        <option value="2026">Year 2026
                                                        </option>
                                                        <option value="2027">Year 2027
                                                        </option>
                                                        <option value="2028">Year 2028
                                                        </option>
                                                        <option value="2029">Year 2029
                                                        </option>
                                                        <option value="2030">Year 2030
                                                        </option>
                                                    </select>
                                                </div> --}}

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

                                                {{-- <div class="col-lg-3">
                                                    <select name="month" class="form-control" id="" required>
                                                        <option value="" selected disabled>Select Month </option>
                                                        <option value="1">January
                                                        </option>
                                                        <option value="2">February
                                                        </option>
                                                        <option value="3">March
                                                        </option>
                                                        <option value="4">April
                                                        </option>
                                                        <option value="5">May</option>
                                                        <option value="6">June
                                                        </option>
                                                        <option value="7">July
                                                        </option>
                                                        <option value="8">August
                                                        </option>
                                                        <option value="9">September
                                                        </option>
                                                        <option value="10">October
                                                        </option>
                                                        <option value="11">November
                                                        </option>
                                                        <option value="12">December
                                                        </option>
                                                    </select>
                                                </div> --}}

                                                <div class="col-lg-2">
                                                    <label for="" class="col-form-label"></label>
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                            @php
                                $data = Session::get('monthly_income');
                                $months = Session::get('months');
                                $opening_balance = Session::get('opening_balance');
                                $others_income = Session::get('others_income');
                            @endphp

                            @if (isset($data) && !empty($data))
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-6">
                                            <h3 class="card-title">Total Income for the Month of
                                                @if ($months->month == 1)
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
                                                @endif
                                            </h3>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            @if (isset($opening_balance) && !empty($data))
                                                @if ($opening_balance->flag == 1)
                                                    <h3 class="card-title"><strong>Opening Balance
                                                            {{ $opening_balance->profit }}</strong></h3>
                                                @else
                                                    <h3 class="card-title"><strong>Opening Loss
                                                            ({{ $opening_balance->loss }})</strong></h3>
                                                @endif
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="8%">Sl</th>
                                                    <th>Income Head</th>
                                                    <th width="20%">Total Income</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td class="text-left">{{ $months->charge }}</td>
                                                    <td class="text-right">{{ $data }}</td>
                                                </tr>
                                                @foreach ($others_income as $key => $item)
                                                    @php
                                                        $others_total = App\Models\OthersIncome::where(
                                                            'month',
                                                            $item->month,
                                                        )
                                                            ->where('year', $item->year)
                                                            ->where('client_id', Auth::guard('admin')->user()->id)
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
                                                <tr>
                                                    @if (isset($opening_balance))
                                                        <td colspan="2" class="text-right"><strong>Total Income without
                                                                O/P:
                                                            </strong></td>
                                                        @if (isset($others_total))
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data + $others_total }}</strong>
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data }}</strong>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td colspan="2" class="text-right"><strong>Total Income :
                                                            </strong></td>
                                                        @if (isset($others_total))
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data + $others_total }}</strong>
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data }}</strong>
                                                            </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if (isset($opening_balance))
                                                        <td colspan="2" class="text-right"><strong>Total Income with O/P:
                                                            </strong>
                                                        </td>

                                                        @if (isset($others_total) && isset($opening_balance) && !empty($data))
                                                            @if ($opening_balance->flag == 1)
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $data + $others_total + $opening_balance->profit }}</strong>
                                                                </td>
                                                            @else
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $data + $others_total - $opening_balance->loss }}</strong>
                                                                </td>
                                                            @endif
                                                        @elseif(isset($others_total) && !isset($opening_balance) && !empty($data))
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $data + $others_total }}</strong>
                                                            </td>
                                                        @elseif(!isset($others_total) && isset($opening_balance) && !empty($data))
                                                            @if ($opening_balance->flag == 1)
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $data + $opening_balance->profit }}</strong>
                                                                </td>
                                                            @else
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $data - $opening_balance->loss }}</strong>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @else
                                                    @endif

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @elseif (isset($month->month) && !empty($month->month))
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-8 col-sm-6">
                                                <h3 class="card-title">Total Income for the Month of
                                                    @if ($month->month == 1)
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
                                                    @endif
                                                </h3>
                                            </div>

                                            <div class="col-lg-4 col-sm-6">
                                                @if (isset($m_opening_balance))
                                                    @if ($m_opening_balance->flag == 1)
                                                        <h3 class="card-title"><strong>Opening Balance
                                                                {{ $m_opening_balance->profit }}</strong></h3>
                                                    @else
                                                        <h3 class="card-title"><strong>Opening Loss
                                                                ({{ $m_opening_balance->loss }})</strong></h3>
                                                    @endif
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="8%">Sl</th>
                                                        <th>Income Head</th>
                                                        <th width="20%">Total Income</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td class="text-left">{{ $month->charge }}</td>
                                                        <td class="text-right">{{ $m_income }}</td>
                                                    </tr>
                                                    @foreach ($m_other_income as $key => $item)
                                                        @php
                                                            $other_total = App\Models\OthersIncome::where(
                                                                'month',
                                                                $item->month,
                                                            )
                                                                ->where('year', $item->year)
                                                                ->where('client_id', Auth::guard('admin')->user()->id)
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
                                                    <tr>
                                                        @if (isset($m_opening_balance))
                                                            <td colspan="2" class="text-right"><strong>Total Income
                                                                    without O/P:
                                                                </strong></td>
                                                            @if (isset($other_total))
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $m_income + $other_total }}</strong>
                                                                </td>
                                                            @else
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $m_income }}</strong>
                                                                </td>
                                                            @endif
                                                        @else
                                                            <td colspan="2" class="text-right"><strong>Total Income
                                                                    :
                                                                </strong></td>
                                                            @if (isset($other_total))
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $m_income + $other_total }}</strong>
                                                                </td>
                                                            @else
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $m_income }}</strong>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if (isset($m_opening_balance))
                                                            <td colspan="2" class="text-right"><strong>Total Income with
                                                                    O/P:
                                                                </strong>
                                                            </td>

                                                            @if (isset($other_total) && isset($m_opening_balance) && !empty($m_income))
                                                                @if ($m_opening_balance->flag == 1)
                                                                    <td colspan="2" class="text-right">
                                                                        <strong>{{ $m_income + $other_total + $m_opening_balance->profit }}</strong>
                                                                    </td>
                                                                @else
                                                                    <td colspan="2" class="text-right">
                                                                        <strong>{{ $m_income + $other_total - $m_opening_balance->loss }}</strong>
                                                                    </td>
                                                                @endif
                                                            @elseif(isset($other_total) && !isset($m_opening_balance) && !empty($m_income))
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $m_income + $other_total }}</strong>
                                                                </td>
                                                            @elseif(!isset($other_total) && isset($m_opening_balance) && !empty($m_income))
                                                                @if ($opening_balance->flag == 1)
                                                                    <td colspan="2" class="text-right">
                                                                        <strong>{{ $m_income + $m_opening_balance->profit }}</strong>
                                                                    </td>
                                                                @else
                                                                    <td colspan="2" class="text-right">
                                                                        <strong>{{ $m_income - $m_opening_balance->loss }}</strong>
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        @else
                                                        @endif

                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                @else
                                <h5 class="text-center py-3">No Data Found</h5>
                            @endif
                        </div>
                    </div>
                </div>
        </section>
    </div>

@endsection
