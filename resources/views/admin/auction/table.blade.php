<div class="container">
    <h1>Auctions List</h1>

    <!-- Hiển thị thông báo thành công nếu có -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Bảng hiển thị danh sách auctions -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Item</th>
                <th>Start Price</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>End Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auctions as $auction)
                <tr>
                    <td>{{ $auction->category->name }}</td>
                    <td>{{ $auction->item->title }}</td>
                    <td>{{ $auction->start_price }}</td>
                    <td>{{ $auction->start_date }}</td>
                    <td>{{ $auction->end_date }}</td>
                    <td>{{ ucfirst($auction->status) }}</td>
                    <td>{{ $auction->end_price ?? 'N/A' }}</td>
                    <td>
                        <!-- Nút edit -->
                        <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-primary btn-sm">Edit</a>

                        <!-- Form xóa -->
                        <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Nút thêm auction -->
    <a href="{{ route('auctions.create') }}" class="btn btn-success">Add Auction</a>
</div>
