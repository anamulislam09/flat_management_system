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
              <div class="card-header bg-primary">
                <div class="row">
                  <div class="col-lg-10 col-sm-12">
                    <h3 class="card-title">Expense Summary for the Month of <strong> @if ('1' == date('m'))
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
                    @endif - {{date('Y')}}</h3></strong>
                  </div>
                  @if (count($expSummary) < 1)
                  @else
                  <div class="col-lg-2 col-sm-12">
                    <a href="{{route('manager.expense.voucher.generateall')}}" class="btn btn-light">General Voucher</a>
                  </div>
                  @endif
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if (count($expSummary) < 1)
                <div class="card">
                    <div class="card-header text-center">
                        {{-- <strong><span>Data not Found!</span></strong> --}}
                        <section class="page_404">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-md-12 col-sm-12">
                                        <div class="col-sm-12 text-center">
                                            <div class="four_zero_four_bg">
                                                <h1 class="text-center ">404</h1>
                                            </div>
                                            <div class="contant_box_404">
                                                <h3 class="h2">
                                                    Data Not Found!
                                                </h3>
                                                <p>Pls! Expense Create First</p>
                                                <a href="{{ route('manager.expense.create') }}" class="link_404 btn btn-primary">Create Expense
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                @else
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Expense</th>
                        <th class="text-center">Amount</th>
                    </thead>
                    <tbody>
                      @foreach ($expSummary as $key => $item)
                        @php
                          $data = DB::table('categories')
                              ->where('id', $item->cat_id)
                              ->first();
                              $user = App\Models\User::where('user_id', Auth::user()->user_id)->first();
                          $amount = App\Models\Exp_detail::where('client_id', $user->client_id)
                              ->where('month', $item->month)
                              ->where('year', $item->year)
                              ->where('cat_id', $item->cat_id)
                              ->sum('amount');
                          // dd($amount);
                          $total = App\Models\Exp_detail::where('client_id', $user->client_id)
                              ->where('month', $item->month)
                              ->where('year', $item->year)
                              ->sum('amount');
                        @endphp
                        <tr>
                          <td>{{ $key + 1 }}</td>
                          <td>{{ $data->name }}</td>
                          <td class="text-right">{{ $amount }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2" class="text-right"> <strong>Total :</strong></td>
                        <td class="text-right"><strong>{{ $total }}</strong></td>
                      </tr>
                    </tfoot>
                @endif
                </table>
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
          {{-- <form action="{{ route('expense.voucher') }}" method="POST"> --}}
          @csrf
          <input type="hidden" name="id" value="">
          <div class="modal-body">
            <div class="mb-3 mt-3">
              <label for="" class="form-label"> Name :</label>
              <input type="text" class="form-control" value="" name="name">
            </div>

            <div class="mb-3 mt-3">
              <label for="" class="form-label"> Email :</label>
              <input type="email" class="form-control" value="" name="email">
            </div>
            <div class="mb-3 mt-3">
              <label for="" class="form-label"> Phone :</label>
              <input type="text" class="form-control" value="" name="phone">
            </div>
            <div class="mb-3 mt-3">
              <label for="" class="form-label"> Address :</label>
              <input type="text" class="form-control" value="" name="address">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          </form>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        </div>

      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
@endsection
