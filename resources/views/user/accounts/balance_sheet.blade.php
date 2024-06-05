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
                                <h3 class="card-title pt-2" style="width:100%; text-align:center">Balance Sheet</h3>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="#" method="post">
                                            @csrf
                                            <div class="row my-4">
                                                {{-- <div class="col-lg-3">
                                                    <strong><span>Balance Sheet </span></strong>
                                                </div> --}}
                                                <div class="col-lg-3">
                                                    <select name="year" class="form-control" id="year" required>
                                                        @foreach (range(date('Y'), 2010) as $year)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select name="month" class="form-control" id="month" required>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}"
                                                                @if ($i == date('m')) selected @endif>
                                                                {{ date('F', strtotime(date('Y') . '-' . $i . '-01')) }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                {{-- <div class="col-lg-2">
                                                    <label for="" class="col-form-label"></label>
                                                    <input type="submit" class="btn btn-primary" value="Generate">
                                                </div> --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-10 col-sm-12">
                                        <h3 class="card-title">Balance Sheet For the Month of <span
                                                id="result_month"></span></h3>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Total Income</th>
                                                <th class="text-center">Total Expense</th>
                                                <th class="text-center">Balance</th>
                                                <th class="text-center">Flag</th>
                                        </thead>
                                        <tbody id="table-body">
                                            <tr>
                                                <td class="text-right" id="income"></td>
                                                <td class="text-right" id="expense"></td>
                                                <td class="text-right" id="balance"></td>
                                                <td class="text-center"><span id="flag"
                                                        class="badge badge-light text-bold"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            balanceSheeat();
            $('#year, #month').on('change', function() {
                balanceSheeat();
            });
        });

        function balanceSheeat() {
            let year = $("#year").val();
            let month = $("#month").val();
            $("#result_month").html($("#month option:selected").text());
            $.ajax({
                url: "{{ url('account/balance-sheet') }}/" + year + '/' + month,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $('#income').html(res.income);
                    $('#expense').html(res.expense);
                    $('#balance').html(res.balance);
                    $('#flag').html(res.flag);
                }
            });
        }
    </script>
@endsection
