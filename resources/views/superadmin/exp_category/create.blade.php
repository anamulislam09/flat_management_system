@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <div style="float: left">
                                    <h3 class="card-title pt-2" style="width:100%; text-align:center">Add Expense
                                    </h3>
                                </div>
                                <div style="float: right">
                                    <a href="{{ route('category.index') }}" class="btn btn-primary" style="float:right"> See All</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('category.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3 mt-3">
                                        <label for="name" class="form-label">Expense Category:</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                            name="name" id="name" placeholder="Enter Expense Category">
                                    </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
