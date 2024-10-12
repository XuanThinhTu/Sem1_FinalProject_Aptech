<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="container">
            <h1>Add New Auction</h1>

            <form action="{{ route('auctions.store') }}" method="POST">
                @csrf
                <!-- Selection for Category -->
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Selection for Item, dynamically updated based on selected Category -->
                <div class="form-group">
                    <label for="item_id">Item</label>
                    <select name="item_id" id="item_id" class="form-control">
                        <option value="">Select Item</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="step">Step</label>
                    <input type="number" name="step" id="step" class="form-control" value="1.00"
                        step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Auction</button>
            </form>
        </div>

        <!-- Script to load items based on category -->
        <script>
            document.getElementById('category_id').addEventListener('change', function() {
                var categoryId = this.value;
                var itemSelect = document.getElementById('item_id');
                itemSelect.innerHTML = '<option value="">Select Item</option>'; // Reset các item

                if (categoryId) {
                    // Gọi AJAX để lấy items theo category
                    fetch(`http://localhost/Sem1_FinalProject_Aptech/public/admin/items-by-category/${categoryId}`)
                        // fetch(`/admin/items-by-category/${categoryId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then(items => {
                            items.forEach(item => {
                                var option = document.createElement('option');
                                option.value = item.id;
                                option.text = item.title;
                                itemSelect.appendChild(option); // Thêm item vào dropdown
                            });
                        })
                        .catch(error => console.error('Error fetching items:', error));
                }
            });
        </script>
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
