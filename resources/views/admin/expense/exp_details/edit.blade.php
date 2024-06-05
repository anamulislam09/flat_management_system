<form action="{{route('expense-details.update')}}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $data->id }}">
    <div class="modal-body">
        <div class="mb-3 mt-3">
            <label for="category_name" class="form-label"> Expense Name:</label>
            <select name="cat_id" class="form-control" id="" required>
                <option value="" selected disabled>Select Once</option>
                @foreach ($exp_cat as $item)
                    <option value="{{ $item->id }}" @if ($item->id == $data->cat_id) selected @endif >{{ $item->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 mt-3">
            <label for="" class="form-label"> Expense Amount:</label>
           <input type="text" class="form-control" value="{{ $data->amount }}" name="amount">
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>