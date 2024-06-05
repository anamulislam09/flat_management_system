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
              <div class="card-header bg-primary">

                @if (Route::current()->getName() == 'singleUser.paid')
                  <div class="col-lg-12">
                    <h3 class="card-title" style="width: 100%; text-align:center">Total Payable From <strong>{{ Auth::user()->name }}</strong>
                    </h3>
                  </div>
                @else
                  <div class="col-lg-12">
                    <h3 class="card-title" style="width: 100%; text-align:center">Total Due From <strong>{{ Auth::user()->name }}</strong></h3>
                  </div>
                @endif


              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>SL </th>
                      <th>Year</th>
                      <th>Month</th>
                      {{-- <th >Flat_Name</th> --}}
                      <th>Charge</th>
                      <th>Amount</th>
                      @if (Route::current()->getName() == 'singleUser.paid')
                        <th>Paid</th>
                      @else
                        <th>Due</th>
                      @endif
                      {{-- <th>Payble</th> --}}
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

                        $id = App\Models\User::where('user_id', Auth::user()->user_id)->first();
                        $total_amount = App\Models\Income::where('client_id', $id->client_id)
                            ->where('flat_id', $id->flat_id)
                            ->sum('amount');
                        $collection = App\Models\Income::where('client_id', $id->client_id)
                            ->where('flat_id', $id->flat_id)
                            ->sum('paid');
                      @endphp
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
                        {{-- <td>{{ $item->flat_name }}</td> --}}
                        <td>{{ $item->charge }}</td>
                        <td class="text-right">{{ $item->amount }}</td>
                        @if (Route::current()->getName() == 'singleUser.paid')
                          <td class="text-right">{{ $item->paid }}</td>
                        @else
                          <td class="text-right">{{ $item->due }}</td>
                        @endif

                      </tr>
                    @endforeach
                  </tbody>
                  @if (isset($data))
                  @else
                    <tr>
                      <td colspan="4" class="text-right"> <strong>Total :</strong></td>
                      <td class="text-right"><strong>{{ $total_amount }}</strong></td>
                      {{-- @if (isset($collection))
                        <td class="text-right"><strong>{{ $collection }}</strong></td>
                      @else
                        <td class="text-right"><strong>00</strong></td>
                      @endif --}}

                      @if (Route::current()->getName() == 'singleUser.paid')
                        @if (isset($collection))
                          <td class="text-right"><strong>{{ $collection }}</strong></td>
                        @else
                          <td class="text-right"><strong>00</strong></td>
                        @endif
                      @else
                        <td class="text-right"><strong>{{ $total_amount - $collection }}</strong></td>
                      @endif

                    </tr>
                  @endif
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  {{-- <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script> --}}
@endsection
