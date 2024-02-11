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
                                    <input type="text" id="stockProductId">
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