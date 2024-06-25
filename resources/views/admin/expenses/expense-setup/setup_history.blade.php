@extends('layouts.admin')

@section('admin_content')
<style>
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
  
    .table td,
    .table th {
        padding: .30rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        font-size: 14px;
    }
    .text {
            font-size: 14px !important;
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
                                <h3 class="card-title text" style="width:100%; text-align:center">Expense Schedule Setup
                                    History</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-header pb-0">
                                <!-- /.card-header -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-8 ">
                                        <div class="form-group">
                                            <label class="text">Select Expense</label>
                                            <select class="form-control form-control-sm select2 text" name="exp_id"
                                                id="exp_id" style="width: 100%;">
                                                <option value="" selected disabled>Select Expense</option>
                                                @foreach ($exp as $row)
                                                    <option class="pb-3" value="{{ $row->id }}">
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <strong class="d-flex justify-content-center mb-2 text"><span
                                                id="user"></span>&nbsp; Expense Setup History</strong>
                                        <hr>
                                        <div class="card-body table-responsive">
                                            <table id="dataTable" class="table table-bordered table-striped item-table">
                                                <thead>
                                                    <tr style="border-top: 1px solid #ddd">
                                                        <th width="10%">SL</th>
                                                        <th width="15%">Exp Name</th>
                                                        <th width="15%">Vendor</th>
                                                        <th width="15%">Interval Days</th>
                                                        <th width="15%">Start Date</th>
                                                        <th width="15%">End Date</th>
                                                        {{-- <th width="15%">Status </th>
                                                        <th width="15%">Action </th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody id="item-table">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // var searchRequest = null;
        $(function() {
            // $("#exp_id").change(function() {
            $('#exp_id').on('change', function() {
                let exp_id = $("#exp_id").val();
                // alert(exp_id);
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/expense-setup/history/all') }}/" + exp_id,
                    dataType: "json",
                    success: function(res) {
                        // console.log(res);

                        var tbody = '';
                        res.history.forEach((element, index) => {

                            const s_date = new Date(element.start_date)
                            var start_date = (s_date.getMonth() +
                                    1) + "/" + s_date.getDate() + "/" + s_date
                                .getFullYear();

                            const e_date = new Date(element.end_date)
                            var end_date = (e_date.getMonth() +
                                    1) + "/" + e_date.getDate() + "/" + e_date
                                .getFullYear();
                            tbody += '<tr>'
                            tbody += '<td>' + (index + 1) + '</td>'
                            tbody += '<td>' + element.name + '</td>'
                            tbody += '<td>' + element.vName + '</td>'
                            tbody += '<td>' + element.interval_days + '</td>'
                            tbody += '<td>' + start_date + '</td>'
                            tbody += '<td>' + end_date + '</td>'
                            tbody += '</tr>'

                        });
                        $('#item-table').html(tbody);
                        // if(!res.history.length){
                        //     $('#item-table').html('<p style="width:100% ; text-align:center;">No Data Found</p>');
                        // }
                    }
                });
            });
        });
    </script>
@endsection
