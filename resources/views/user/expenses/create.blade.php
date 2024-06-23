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
                <h3 class="card-title pt-2" style="width:100%; text-align:center">Expense Entry</h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- /.card-header -->
                <div class="row">
                  <div class="col-12 m-auto border p-5">
                    <form action="{{ route('manager.expense.store') }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class=" col-lg-5 form-group">
                          <label for="unit" class="">Expense Category</label>
                          <select name="cat_id" class="form-control" id="" required>
                            <option value="" selected disabled>Select Once</option>
                            @foreach ($exp_cat as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                          </select>
                        </div>
                        <div class=" col-lg-5 form-group">
                          <label for="unit" class="">Expense Amount</label>
                          <input type="text" name="amount" class="form-control" placeholder="Enter Expense Amount"
                            required>
                        </div>
                        <div class="col-lg-2">
                          <button type="submit" class="btn btn-sm btn-primary float-end" style="margin-top: 35px"
                            id="">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @if (count($expDetails) < 1)
            @else
              <div class="card">
                <div class="card-body">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>SL</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Expense</th>
                        <th class="text-center">Amount</th>
                        <th width="20%" class="text-center">Action</th>
                    </thead>
                    <tbody>
                      @foreach ($expDetails as $key => $item)
                        @php
                          $data = DB::table('categories')
                              ->where('id', $item->cat_id)
                              ->first();
                          // total amounrt
                          $month = Carbon\Carbon::now()->month;
                          $year = Carbon\Carbon::now()->year;
                          $user = App\Models\User::where('user_id', Auth::user()->user_id)->first();
                          $total = App\Models\Expense::where('client_id', $user->client_id)
                              ->where('month', $month)
                              ->where('year', $year)
                              ->sum('amount');
                        @endphp
                        <tr>
                          <td>{{ $key + 1 }}</td>
                          <td class="text-center">{{ $item->year }}</td>

                          <td class="text-center">
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

                          <td>{{ $data->name }}</td>
                          <td class="text-right">{{ $item->amount }}</td>
                          <td class="text-center">
                            <a href="#" class="btn btn-sm btn-info edit" data-id="{{ $item->id }}"
                              data-toggle="modal" data-target="#editexp"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('manager.expense-details.delate', $item->id) }}" class="btn btn-sm btn-danger"><i
                                class="fas fa-trash"></i></a>
                            <a href="{{route('manager.expense.voucher.create', $item->id)}}" class="btn btn-sm"><span class="badge badge-primary">Voucher</span></a>
                          </td>

                        </tr>
                      @endforeach
                      <tr>
                        <td colspan="4" class="text-right"><strong>Total =</strong></td>
                        <td class="text-right"><strong>{{ $total }}</strong></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  </div>

  {{-- category edit model --}}
  <!-- Modal -->
  <div class="modal fade" id="editexp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Expense </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div id="modal_body">

        </div>

      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script>
    $('body').on('click', '.edit', function() {
      let exp_id = $(this).data('id');
      $.get("/expense-details/edit/" + exp_id, function(data) {
        $('#modal_body').html(data);
        // console.log(data);
      })
    })
  </script>

@endsection
