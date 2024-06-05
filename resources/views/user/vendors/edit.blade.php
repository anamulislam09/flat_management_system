<div class="card-body">
    <form action="{{ route('manager.vendor.update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id }}">
                {{-- <input type="hidden" name="amount" value="{{ $exp->amount }}"> --}}
        <div class=" form-group">
            <label for="name" class="">Name :</label>
            <input type="text" class="form-control" value="{{ $data->name }}" name="name" id="name" required>
        </div>


        <div class="form-group">
            <label for="phone" class="">Phone :</label>
            <input type="text" class="form-control" value="{{ $data->phone }}" name="phone" id="phone"
                required>
        </div>

        <div class="form-group">
            <label for="unit" class="">Address :</label>
            <input type="text" class="form-control" value="{{ $data->address }}" name="address">
        </div>
        <div class="">
            <button type="submit" class="btn btn-sm btn-primary" id="generate">Submit</button>
        </div>
    </form>
</div>
