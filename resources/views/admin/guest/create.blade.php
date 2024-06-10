@extends('layouts.admin')
@section('admin_content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Guest</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Guest</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header p-1">
                <h3 class="card-title ">
                  <a href="{{ route('guestBook.index') }}"class="btn btn-light shadow rounded m-0 text-dark"><span>See
                      All</span></a>
                </h3>
              </div>
              <form action="{{ route('guestBook.store') }}" method="POST" enctype="multipart/form-data">
                @csrf()
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-12 col-md-6 col-lg-6 mb-0">
                      <label>Guest Name</label>
                      <input class="form-control" type="text" name="name" id="name"
                        placeholder=" Enter Guest Name" required>
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                      <label>Phone</label>
                      <input class="form-control" type="text" name="phone" id="phone"
                        placeholder=" Enter valid phone" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                      <label>Address</label>
                      <input class="form-control" type="text" name="address" id="address"
                        placeholder="Enter Address">
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-6 ">
                      <label>Where you Go</label>
                      <select name="flat_id" id="" class="form-control" required>
                        <option value="" selected disabled>Select Flat</option>
                        @foreach ($flats as $flat)
                          <option value="{{ $flat->flat_id }}">{{ $flat->flat_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-sm-12 col-md-6 col-lg-6" align="center">
                      <label>Take Photo</label>
                      <div id="my_camera" class="pre_capture_frame" onClick="activateWebcam()"></div>
                      <input type="hidden" name="captured_image_data" id="captured_image_data">
                      <br>
                      <input type="button" class="btn btn-info btn-round btn-file" value="Take Snapshot"
                        onClick="take_snapshot()">
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-6" align="center">
                      <label>Result</label>
                      <div id="results">
                        <img style="width: 350px;" class="after_capture_frame" src="image_placeholder.jpg" />
                      </div>
                    </div>

                  </div><!--  end row -->
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>

  <script language="JavaScript">
    // Configure a few settings and attach camera 250x187
    // Function to activate the webcam when clicking on the camera div
    function activateWebcam() {
      Webcam.set({
        width: 150,
        height: 150,
        image_format: 'jpeg',
        jpeg_quality: 90
      });
      Webcam.attach('#my_camera');
    }

    function take_snapshot() {
      // Take snapshot and get image data
      Webcam.snap(function(data_uri) {
        // Display results in page
        document.getElementById('results').innerHTML =
          '<img class="after_capture_frame" src="' + data_uri + '"/>';
        $("#captured_image_data").val(data_uri);
      });
    }

    function saveSnap() {
      var base64data = $("#captured_image_data").val();
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "capture_image_upload.php",
        data: {
          image: base64data
        },
        success: function(data) {
          alert(data);
        }
      });
    }
  </script>
@endsection
