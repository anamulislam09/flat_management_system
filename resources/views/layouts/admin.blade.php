<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>flat-management-system</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  {{-- <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}"> --}}
  <!-- sweetalert -->
  <link rel="stylesheet" href="{{asset('admin/plugins/sweetalert2/sweetalert2.css')}}">
  <!-- toaste -->
  <link rel="stylesheet" href="{{asset('admin/plugins/toastr/toastr.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

   <!-- Select2 -->
   <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

</head>
<body>

  {{-- @guest
    
  @else --}}
  <div class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center mb-0">
    <img class="animation__wobble" src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
  @include('layouts.admin_partial.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 @include('layouts.admin_partial.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('admin_content')
  <!-- /.content-wrapper -->
  {{-- @endguest --}}
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

</div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
{{-- <script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script> --}}
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('admin/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('admin/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('admin/dist/js/demo.js')}}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{asset('admin/dist/js/pages/dashboard2.js')}}"></script> --}}

<!-- sweetalert -->
<script src="{{asset('admin/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
 <!-- toaste -->
<script src="{{asset('admin/plugins/toastr/toastr.min.js')}}"></script>

<!-- DataTables  & Plugins -->
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script> 
<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>

{{-- sweetalert --}}
<script src="{{ asset('admin/plugins/select2/js/select2.full.min.js')}}"></script>

<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()
    $('.select2').select2()
  })
</script>


<!-- AdminLTE App -->
{{-- <script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script> --}}
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('admin/dist/js/demo.js')}}"></script> --}}
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

{{-- sweetalert for delete --}}
{{-- <script>
  $(document).on("click", "#delete", function(e){
    e.preventDefault();
    var link = $(this).attr('href');
    swal({
      title: "Are you want to delete?",
      text: "Once Delete,this will be permanently delete!",
      icon:"warning",
      button:true,
      dangerMode:true,
    })
    .then((willDelete) => {
      if(willDelete){
        window.location.href = link
      }else{
        swal("Safe Data");
      }
    });
  });
</script> --}}

<script>
  function confirmAlert(element, message = "You won't be able to revert this!", buttonText = 'Yes, delete it!', title = 'Are you sure?') {
      $(document).on('click', element, function(event) {
          var form = $(this).closest("form");
          event.preventDefault();
          Swal.fire({
              title: title,
              text: message,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: buttonText,
              customClass: {
                  confirmButton: 'btn btn-primary',
                  cancelButton: 'btn btn-outline-danger ml-1'
              },
              buttonsStyling: false
          }).then(function(result) {
              if (result.value) {
                  if (result.isConfirmed) {
                      form.submit();
                  }
              }
          });
      });
  }

  //sweetalert 2
  $(document).ready(function() {
      // layout theme change
      $(document).on('click', '.confirm-text', function(event) {
          var form = $(this).closest("form");
          // var name = $(this).data("name");
          event.preventDefault();
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              customClass: {
                  confirmButton: 'btn btn-primary',
                  cancelButton: 'btn btn-outline-danger ml-1'
              },
              buttonsStyling: false
          }).then(function(result) {
              if (result.value) {
                  if (result.isConfirmed) {
                      form.submit();
                  }
              }
          });
      });


  })
</script>


{{-- before logout showing alert message --}}
<script>
  $(document).on('click', '#logout', function(e){
    e.preventDefault();
    var link = $(this).attr('action');
    swal({
      title: "Are you want to Logout?",
      text: "",
      icon:"warning",
      button:true,
      dangerMode:true,
    })
    .then((willDelete) => {
      if(willDelete){
        window.location.href = link
      }else{
        swal("Not Logout");
      }
    });
  });
</script>

{{-- toaster message --}}

<script>
  @if (Session::has('message'))
  var type = "{{Session::get('alert-type','info')}}"
    switch (type) {
      case 'info':
        toastr.info("{{Session::get('message')}}");
        break;
      case 'success':
        toastr.success("{{Session::get('message')}}");
        break;
      case 'warning':
        toastr.warning("{{Session::get('message')}}");
        break;
      case 'error':
        toastr.error("{{Session::get('message')}}");
        break;
    }
  @endif
</script>

</body>
</html>