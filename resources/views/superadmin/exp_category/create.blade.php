@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-6">
                      <h1 class="mt-4 ml-2" style="font-size: 25px">Expense Category</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                          <li class="breadcrumb-item active">Expense Category</li>
                      </ol>
                  </div>
              </div>
          </div>
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-header bg-primary p-1">
                                <h3 class="card-title">
                                    <a href="{{ route('category.index') }}"class="btn btn-light shadow rounded m-0"><span>See All</span></a>
                                </h3>
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
