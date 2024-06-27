@php
    $client = App\Models\Customer::where('role', 1)->get();
@endphp
<form action="{{ route('collection.update') }}" method="POST">
    @csrf
    <input type="text" name="id" value="{{ $data->id }}">
    <input type="text" name="client_id" value="{{ $data->customer_id }}">
    <input type="text" name="amount" value="{{ $data->payment_amount }}">
    <input type="text" name="due_amount" value="{{ $data->due }}">
    <div class="modal-body">
        <div class="mb-3 mt-3">
            <label for="exampleInputEmail1">Select Client </label>
            <select name="client_id" id="client_id" class="form-control" required>
                <option value="" selected disabled>Select Once</option>
                @foreach ($client as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $data->customer_id) selected @endif>
                        {{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 mt-3">
            <label>Package Name</label>
            <input type="text" class="form-control" value="{{ $package->package_name }}" id="package"
                name="package_name">
        </div>
        {{-- <div class="mb-3 mt-3">
                    <label for="package_bill" class="form-label">Package Bill</label>
                    <input type="text" class="form-control" value=""
                        name="package_bill" id="package_bill">
                </div> --}}
        <div class="mb-3 mt-3">
            <label for="amount" class="form-label">Collection Amount</label>
            <input type="text" class="form-control" value="{{ old('amount') }}" name="collection_amount"
                placeholder="Enter amount">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
