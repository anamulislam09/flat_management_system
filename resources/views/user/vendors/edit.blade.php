<div class="card-body">
    <form action="{{ route('manager.vendor.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id }}">
                {{-- <input type="hidden" name="amount" value="{{ $exp->amount }}"> --}}
        <div class=" form-group">
            <label for="name" class=" text">Name :</label>
            <input type="text" class="form-control text" value="{{ $data->name }}" name="name" id="name" required>
        </div>


        <div class="form-group">
            <label for="phone" class=" text">Phone :</label>
            <input type="text" class="form-control text" value="{{ $data->phone }}" name="phone" id="phone"
                required>
        </div>

        <div class="form-group">
            <label for="unit" class=" text">Address :</label>
            <input type="text" class="form-control text" value="{{ $data->address }}" name="address">
        </div>
        <div class="">
            <button type="submit" class="btn btn-sm btn-primary text" id="generate">Submit</button>
        </div>
    </form>
</div>
