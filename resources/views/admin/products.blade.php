<x-layout.admin>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <x-nav />
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Products</h1>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex"
                                style="justify-content: space-between; align-items: center">
                                <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
                                <a class=" btn btn-primary" href="#" data-toggle="modal" data-target="#addModal">
                                    <i class="fas fa-plus fa-sm fa-fw"></i>
                                    Add
                                </a>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product</th>
                                                <th>Type</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            ?>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ ++$count }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ ucfirst($product->product_type) }}</td>
                                                    <td>₦{{ $product->price }}</td>
                                                    <td>{{ $product->status }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info"
                                                            onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', '{{ ucfirst($product->product_type) }}')">Add
                                                            to Stock</button>
                                                    </td>
                                                    <td>
                                                        <form
                                                            action="{{ route('product.delete', ['id' => $product->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Sales App by Randisoft {{ date('Y') }}</span>
                </div>
            </div>
        </footer>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a New Product</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="product_type">Product Type:</label>
                            <select id="product_type" class="form-control">
                                <option value="whole">Whole</option>
                                <option value="piece">Piece</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input type="text" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Product Price:</label>
                            <input type="number" step="0.01" id="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button class="btn btn-success" id="add" type="button">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#add').on('click', function(e) {
                e.preventDefault()
                var formData = {
                    '_token': $('input[name=_token]').val(),
                    'product_type': $('#product_type').val(),
                    'name': $('#name').val(),
                    'price': $('#price').val(),
                    'status': $('#status').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route('product.store') }}',
                    data: formData,
                    success: function(data) {
                        $('#name').val('');
                        $('#price').val('');
                        $('#status').val('active');
                        // alert(data.message)
                        toastr.success(data.message);
                    },
                    error: function(error) {
                        var errors = error.responseJSON.errors;
                        var errorMessage = "Errors:"
                        $.each(errors, function(key, value) {
                            errorMessage += "\n" + value
                        })
                        alert(errorMessage)
                    }
                })
            })
        })
    </script>
    <script>
        function openStockModal(productId, productName, productType) {
            // Set modal content dynamically
            document.getElementById('stockProductId').value = productId;
            document.getElementById('productName').value = productName;
            document.getElementById('productType').value = productType;

            // Open the modal
            $('#stockModal').modal('show');
        }
    </script>

    <div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="stockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add this item to Stock</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="product_type">Product Type:</label>
                                    <input id="productType" type="text" disabled class="form-control">
                                    <input type="text" id="stockProductId" hidden>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input id="productName" type="text" disabled class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Item Quantity:</label>
                            <input type="number" step="1" id="quantity" class="form-control" required>
                        </div>
                        <button class="btn btn-success" id="stock" type="button">Add to Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#stock').on('click', function(e) {
                e.preventDefault()
                var formData = {
                    '_token': $('input[name=_token]').val(),
                    'product_id': $('#stockProductId').val(),
                    'quantity': $('#quantity').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route('product.stock') }}',
                    data: formData,
                    success: function(data) {
                        $('#quantity').val('');
                        toastr.success(data.message);
                    },
                    error: function(error) {
                        var errors = error.responseJSON.errors;
                        var errorMessage = "Errors:"
                        $.each(errors, function(key, value) {
                            errorMessage += "\n" + value
                        })
                        alert(errorMessage)
                    }
                })
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</x-layout.admin>
