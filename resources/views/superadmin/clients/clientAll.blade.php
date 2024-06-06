@extends('layouts.admin')

@section('admin_content')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
          <div class="col-sm-6">
              <h1 class="mt-4 ml-2" style="font-size: 25px">Delete client data</h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Clients</li>
              </ol>
          </div>
      </div>
  </div>
    <!-- Main content -->
    <section class="content mt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-12 bg-primary py-3">
                    <h3 class="card-title" style="width:100%; text-align:center">Delete Client Data </h3>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row m-auto">
                  <div class="col-lg-8 col-md-10 col-sm-12 m-auto" style="border: 1px solid #ddd">
                    <form action="{{ route('client.data.delete') }}" method="POST">
                      @csrf
                      <div class="modal-body">
                        <div class="mb-3 mt-3 form-group">
                          <label for="user_name" class="form-label"> Client Name:</label>
                          <select name="id" id="" class="form-control" required>
                            <option value="" selected disabled>Select Once</option>
                            @foreach ($data as $item )
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Delete</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
