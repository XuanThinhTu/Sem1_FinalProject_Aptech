<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="container">
                    <h1>Edit Auction</h1>

                    <form action="{{ route('auctions.update', $auction->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Selection for Category -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $auction->item->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selection for Item -->
                        <div class="form-group">
                            <label for="item_id">Item</label>
                            <select name="item_id" id="item_id" class="form-control">
                                <option value="{{ $auction->item->id }}" selected>{{ $auction->item->title }}</option>
                            </select>
                        </div>

                        <!-- Các trường thông tin khác -->
                        @include('admin.auctions.form-fields', ['auction' => $auction])

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Auction</button>
                        </div>
                    </form>
                </div>

                <script>
                    // Tương tự như phần create, AJAX để load items theo category
                    document.getElementById('category_id').addEventListener('change', function() {
                        var categoryId = this.value;
                        var itemSelect = document.getElementById('item_id');
                        itemSelect.innerHTML = '<option value="">Select Item</option>'; // Reset items

                        if (categoryId) {
                            fetch(`/items-by-category/${categoryId}`)
                                .then(response => response.json())
                                .then(items => {
                                    items.forEach(item => {
                                        var option = document.createElement('option');
                                        option.value = item.id;
                                        option.text = item.title;
                                        itemSelect.appendChild(option);
                                    });
                                });
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>
</body>

</html>
