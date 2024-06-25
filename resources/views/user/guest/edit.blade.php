<style>
    @media screen and (max-width: 767px) {
        .text {
            font-size: 13px !important;
     }
    }
</style>

<div id="modal_body">
    <form action="{{ route('manager.guestBook.update') }}" method="POST">
        @csrf
        <input type="hidden" name="guest_id" value="{{ $data->id }}">
        <div class="modal-body">
            <div class="">
                <label for="user_name" class="form-label text"> Guest Name</label>
                <input type="text" class="form-control text" value="{{ $data->name }}" name="name" readonly>
            </div>
            <div class="">
                <label for="user_phone" class="form-label text"> Guest Phone</label>
                <input type="text" class="form-control text" value="{{ $data->phone }}" name="phone" readonly>
            </div>

            <div class="">
                <label for="nid_no" class="form-label text"> Address</label>
                <input type="text" class="form-control text" value="{{ $data->address }}" name="address" readonly>
            </div>

            <div class="">
                <label class="text">Where will you go?</label>
                <select name="flat_id" id="" class="form-control text" required>
                    <option value="" selected disabled>Select Flat</option>
                    @foreach ($flats as $flat)
                        <option value="{{ $flat->flat_id }}">{{ $flat->flat_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class=" mb-3">
                <label class="text">Purpose</label>
                <textarea name="purpose" id="" class="form-control text" placeholder="Enter Purpose"></textarea>
            </div>
            <div class="">
                <img src="{{ asset('images/' . $data->image) }}" style="width: 80px; margin:auto;"
                    alt="{{ $data->image }}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger text" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary text">Update</button>
        </div>
    </form>
</div>
