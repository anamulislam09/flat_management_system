<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css" />
@php

    $user = DB::table('users')
        ->where('user_id', Auth::user()->user_id)
        ->first();
    $flat = DB::table('flats')
        ->where('client_id', $user->client_id)
        ->where('flat_unique_id', $data->flat_id)
        ->first();
@endphp
<div class="modal-header">
    <h6 class="modal-title" id="exampleModalLabel">User Edit Form &nbsp;</h6>
    <h6 class="modal-title" id="exampleModalLabel"> User Id {{ $data->user_id }} & &nbsp;</h6>
    <h6 class="modal-title" id="exampleModalLabel">  
        @if (!empty($flat))
            <td>Flat Name {{ $flat->flat_name }}</td>
        @else
            <td>Flat Name --------.</td>
        @endif
    </h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div id="modal_body">
    <form action="{{ route('manager.users.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id }}">
        <input type="hidden" name="client_id" value="{{ $data->client_id }}">
        <div class="modal-body">
            <div class="mb-3 mt-3">
                <label for="user_name" class="form-label"> User Name:</label>
                <input type="text" class="form-control" value="{{ $data->name }}" name="name">
            </div>

            <div class="mb-3 mt-3">
                <label for="user_email" class="form-label"> User Email:</label>
                <input type="text" class="form-control" value="{{ $data->email }}" name="email">
            </div>
            <div class="mb-3 mt-3">
                <label for="user_phone" class="form-label"> User Phone/Passport:</label>
                <input type="text" class="form-control" value="{{ $data->phone }}" name="phone">
            </div>

            <div class="mb-3 mt-3">
                <label for="nid_no" class="form-label"> User NID/NRC:</label>
                <input type="text" class="form-control" value="{{ $data->nid_no }}" name="nid_no">
            </div>

            <div class="mb-3 mt-3">
                <label for="address" class="form-label"> Address:</label>
                <input type="text" class="form-control" value="{{ $data->address }}" name="address">
            </div>

            <div class="mb-3 mt-3">
                <h6> Status</h6>
                <input type="checkbox" name="status" value="1" @if ($data->status == 1) checked @endif
                    data-bootstrap-switch data-off-color="danger" data-on-color="success">
            </div>

            {{-- <div class="mb-3 mt-3">
            <label for="exampleInputEmail1"> Role  </label>
            <select name="role_id" id="" class="form-control">
                <option value="" selected disabled>Selecte once</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}"
                        @if ($role->id == $data->role_id) selected @endif>
                        {{ $role->name }}</option>
                @endforeach
            </select>
        </div> --}}

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

{{-- CHECKBOX  --}}
<script>
    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>
