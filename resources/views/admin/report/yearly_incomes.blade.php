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
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Yearly Income </h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('incomesall.year') }}" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="col-lg-3">
                                                    <select name="year" class="form-control" id="year" required>
                                                        @foreach (range(date('Y'), 2010) as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                                $data = Session::get('yearly_income');
                                $year = Session::get('year');
                                $opening_balance = Session::get('opening_balance');
                                $others_income = Session::get('others_income');
                            @endphp

                            @if (isset($data) && !empty($data))
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-6">
                                            <h3 class="card-title">Total Income For The Year of {{ $year->year }}</h3>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
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
                                <!-- /.card-header -->
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
                                                <td class="text-left">{{ $year->charge }}</td>
                                                <td class="text-right">{{ $data }}</td>
                                            </tr>
                                            @foreach ($others_income as $key => $item)
                                                @php
                                                    $others_total = App\Models\OthersIncome::where('year', $item->year)
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
                                                    <td colspan="2" class="text-right"><strong>Total Income without O/P:
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
                                                    <td colspan="2" class="text-right"><strong>Total Income with O/P: </strong>
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
                            @else
                                @if (isset($y_income) && !empty($y_income))
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-8 col-sm-6">
                                                <h3 class="card-title">Total Income for the Year of {{ $years->year }}</h3>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                @if (isset($y_opening_balance) && !empty($y_income))
                                                    @if ($y_opening_balance->flag == 1)
                                                        <h3 class="card-title"><strong>Opening Balance
                                                                {{ $y_opening_balance->profit }}</strong></h3>
                                                    @else
                                                        <h3 class="card-title"><strong>Opening Loss
                                                                {{ $y_opening_balance->loss }}</strong></h3>
                                                    @endif
                                                @else
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

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td class="text-left">{{ $years->charge }}</td>
                                                    <td class="text-right">{{ $y_income }}</td>
                                                </tr>
                                                @foreach ($y_other_income as $key => $item)
                                                    @php
                                                        $other_total = App\Models\OthersIncome::where(
                                                            'year',
                                                            $item->year,
                                                        )
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
                                                    @if (isset($y_opening_balance))
                                                        <td colspan="2" class="text-right"><strong>Total Income Without
                                                                O/P:
                                                            </strong></td>
                                                        @if (isset($other_total))
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $y_income + $other_total }}</strong>
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $y_income }}</strong>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td colspan="2" class="text-right"><strong>Total Income :
                                                            </strong></td>
                                                        @if (isset($other_total))
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $y_income + $other_total }}</strong>
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $y_income }}</strong>
                                                            </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if (isset($y_opening_balance))
                                                        <td colspan="2" class="text-right"><strong>Total Income with O/P:
                                                            </strong>
                                                        </td>

                                                        @if (isset($other_total) && isset($y_opening_balance) && !empty($y_income))
                                                            @if ($y_opening_balance->flag == 1)
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $y_income + $other_total + $y_opening_balance->profit }}</strong>
                                                                </td>
                                                            @else
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $y_income + $other_total - $y_opening_balance->loss }}</strong>
                                                                </td>
                                                            @endif
                                                        @elseif(isset($other_total) && !isset($y_opening_balance) && !empty($y_income))
                                                            <td colspan="2" class="text-right">
                                                                <strong>{{ $y_income + $other_total }}</strong>
                                                            </td>
                                                        @elseif(!isset($other_total) && isset($y_opening_balance) && !empty($y_income))
                                                            @if ($y_opening_balance->flag == 1)
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $y_income + $y_opening_balance->profit }}</strong>
                                                                </td>
                                                            @else
                                                                <td colspan="2" class="text-right">
                                                                    <strong>{{ $y_income - $y_opening_balance->loss }}</strong>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @else
                                                    @endif

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <h5 class="text-center py-3">No Data Found</h5>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
