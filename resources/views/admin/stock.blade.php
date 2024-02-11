<x-layout.admin>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <x-nav />
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Stock</h1>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Items in Stock</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product</th>
                                                <th>Product Type</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product</th>
                                                <th>Product Type</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            ?>
                                            @foreach ($stock as $stockItem)
                                                <tr>
                                                    <td>{{ ++$count }}</td>
                                                    <td>{{ $stockItem->product->name }}</td>
                                                    <td>{{ $stockItem->product->product_type }}</td>
                                                    <td>{{ $stockItem->quantity }}</td>
                                                    <td>
                                                        <form
                                                            action="{{ route('stock.delete', ['id' => $stockItem->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to remove this product from stock?')">Remove</button>
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

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</x-layout.admin>
