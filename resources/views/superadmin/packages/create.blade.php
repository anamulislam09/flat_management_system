@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
            <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-6">
                      <h1 class="mt-4 ml-2" style="font-size: 25px">Package</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                          <li class="breadcrumb-item active">Package</li>
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
                                    <a href="{{ route('package.all') }}"class="btn btn-light shadow rounded m-0"><span>See All</span></a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('package.store') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-header P-5">
                                        <div class="mb-3 mt-3 form">
                                            <label for="package_name" class="form-label">Package Name</label>
                                            <input type="text" class="form-control" value="{{ old('package_name') }}"
                                                name="package_name" placeholder="Enter Package Name" required>
                                        </div>
                                        <div class="mb-3 mt-3 form">
                                            <label for="amount" class="form-label">Package Amount</label>
                                            <input type="text" class="form-control" value="{{ old('amount') }}"
                                                name="amount" placeholder="Enter amount">
                                        </div>
                                        <div class="mb-3 mt-3 form">
                                            <label for="duration" class="form-label">Package Duration <sub
                                                    style="color: #ee8049">(days)</sub></label>
                                            <input type="text" class="form-control" value="{{ old('duration') }}"
                                                name="duration" placeholder="Enter Package Duration">
                                            <span style="font-size: 14px">Note: Duration will days.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer clearfix form">
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
