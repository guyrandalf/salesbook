<x-layout.admin>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <x-nav />
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Sales Book</h1>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="row" style="align-items: center; justify-content: space-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Daily Sales Record</h6>
                                    <button class="btn btn-sm btn-primary" onclick="openSalesModal()">
                                        <i class="fas fa-plus fa-sm fa-fw"></i>
                                        Create New
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Trans. ID</th>
                                                <th>Tot. Amt</th>
                                                <th>Tot. Qty</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Trans. ID</th>
                                                <th>Tot. Amt</th>
                                                <th>Tot. Qty</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php $count = 0; ?>
                                            @foreach ($sales->groupBy('trans_id') as $transaction)
                                                @php
                                                    $totalAmount = $transaction->sum('amount');
                                                    $totalQuantity = $transaction->sum('quantity');
                                                    $firstSale = $transaction->first();
                                                    $modalId = 'viewModal' . $firstSale->trans_id; // Unique modal ID
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$count }}</td>
                                                    <td>{{ $firstSale->trans_id }}</td>
                                                    <td>₦{{ number_format($totalAmount, 2) }}</td>
                                                    <td>{{ $totalQuantity }}</td>
                                                    @if ($firstSale->status === 0)
                                                        <td>
                                                            <span class="btn btn-warning btn-icon-split btn-sm">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-info"></i>
                                                                </span>
                                                                <span class="text">Pending</span>
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span class="btn btn-success btn-icon-split btn-sm">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-check"></i>
                                                                </span>
                                                                <span class="text">Confirmed</span>
                                                            </span>
                                                        </td>
                                                    @endif
                                                    <td>{{ $firstSale->created_at }}</td>
                                                    <td>
                                                        <!-- Button to trigger the modal directly without JavaScript -->
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#{{ $modalId }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye fa-sm fa-fw"></i>
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>

                                                <!-- Modal for this iteration -->
                                                <div class="modal fade" id="{{ $modalId }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="{{ $modalId }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="align-items: center">
                                                                <div class="d-flex" style="flex-direction: column">
                                                                    <div>
                                                                        @if ($firstSale->status === 0)
                                                                            <span
                                                                                class="btn btn-warning btn-icon-split btn-sm">
                                                                                <span class="icon text-white-50">
                                                                                    <i class="fas fa-info"></i>
                                                                                </span>
                                                                                <span class="text">Pending</span>
                                                                            </span>
                                                                        @else
                                                                            <span
                                                                                class="btn btn-success btn-icon-split btn-sm">
                                                                                <span class="icon text-white-50">
                                                                                    <i class="fas fa-check"></i>
                                                                                </span>
                                                                                <span class="text">Confirmed</span>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Transaction ID: <span
                                                                            class="text-success">{{ $firstSale->trans_id }}
                                                                        </span>
                                                                    </h5>
                                                                </div>
                                                                <button class="close" type="button"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-flex">
                                                                    <div class="items">
                                                                        <p>Product</p>
                                                                        <p>Quantity</p>
                                                                        <p>Amount</p>
                                                                    </div>
                                                                    @foreach ($transaction as $saleItem)
                                                                        <div class="values">
                                                                            <p>{{ $saleItem->product->name }} -
                                                                                {{ ucfirst($saleItem->product->product_type) }}
                                                                            </p>
                                                                            <p>{{ $saleItem->quantity }}</p>
                                                                            <p>₦{{ $saleItem->amount }}</p>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
        function openSalesModal() {
            $('#salesModal').modal('show');
        }
    </script>

    <div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Purchasing Items</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <style>
                    .form-control {
                        font-size: .8em !important;
                    }
                </style>
                <div class="modal-body">
                    <form action="{{ route('sale.store') }}" method="post">
                        @csrf
                        <div id="productRowsContainer">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label for="product_type">Product Name & Type</label>
                                        <select name="product_id[]" id="productType"
                                            class="form-control product-select">
                                            <option value="" disabled selected>Select an Item</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->product->id }}">
                                                    {{ $product->product->name }}
                                                    ({{ $product->product->product_type }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input id="price" name="price[]" type="text"
                                            class="form-control price-input">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input id="quantity" name="quantity[]" type="text"
                                            class="form-control quantity-input">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="total">Total</label>
                                        <input id="total" type="text" disabled
                                            class="form-control total-input">
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <label for="total">Rem.</label>
                                        <button type="button"
                                            class="form-control btn btn-danger remove-row">x</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex" style="justify-content: space-between; align-items: center">
                            <button title="click to add new row for another item" type="button"
                                class="btn btn-warning add-row">
                                <i class="fas fa-plus fa-sm fa-fw"></i>
                                Add New
                            </button>
                            <button class="btn btn-success" id="stock" type="submit"
                                title="click to complete customer purchase">
                                <i class="fas fa-save fa-sm fa-fw"></i>
                                Complete Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->


    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            // Event delegation for existing and dynamically added fields
            $('#stock').prop('disabled', true);
            $(document).on('input', '.quantity-input, .product-select', function() {
                computeTotal();

                // Event listener for product select dropdown
                if ($(this).hasClass('product-select') || $(this).hasClass('quantity-input')) {
                    var productId = $(this).closest('.row').find('.product-select').val();
                    var row = $(this).closest('.row');
                    var enteredQuantity = parseInt(row.find('.quantity-input').val()) || 0;

                    // Make an AJAX request to fetch stock quantity
                    $.ajax({
                        url: '/get-stock-quantity/' + productId, // Replace with your actual route
                        type: 'GET',
                        success: function(response) {
                            var stockQuantity = response.quantity;

                            // Check if entered quantity exceeds stock
                            // var enteredQuantity = parseInt(row.find('.quantity-input').val()) ||
                            //     0;
                            if (enteredQuantity > stockQuantity) {
                                toastr.warning('Quantity exceeds available stock (' +
                                    stockQuantity + ').');
                                // Optionally, you can reset the quantity to the available stock
                                row.find('.quantity-input').val(stockQuantity);
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching stock quantity:', error);
                        }
                    });
                }
            });


            function computeTotal() {
                var overallTotal = 0;

                // Iterate over each row to calculate individual totals and overall total
                $('.row').each(function() {
                    var row = $(this);
                    var quantity = parseInt(row.find('.quantity-input').val()) || 0;
                    var price = parseInt(row.find('.price-input').val()) || 0;
                    var total = quantity * price;

                    // Update the individual total for the row
                    row.find('.total-input').val(total);

                    // Add the row total to the overall total
                    overallTotal += total;
                })

                // Display the overall total in the "Complete Sale" button
                $('#stock').html('<i class="fas fa-save fa-sm fa-fw"></i> Complete Sale (₦' + overallTotal + ')');

                var isLastRowEmpty = $('#productRowsContainer .row:last').find(
                    'select.product-select, input.price-input, input.quantity-input').filter(function() {
                    return $(this).val() === ''
                }).length > 0

                $('#stock').prop('disabled', isLastRowEmpty);
            }

            $('.add-row').on('click', function() {
                var currentRow = $('#productRowsContainer .row:last');
                $('#stock').prop('disabled', true);

                // Check if any input in the current row is empty
                if (currentRow.find('select.product-select').val() === '' ||
                    currentRow.find('input.price-input').val() === '' ||
                    currentRow.find('input.quantity-input').val() === '') {
                    toastr.error('Please fill in all fields for the current row.');
                    return;
                }

                var newRow = currentRow.clone();
                // Remove the selected option from the cloned row
                var selectedOption = currentRow.find('select.product-select').val();
                newRow.find('select.product-select option[value="' + selectedOption + '"]').remove();

                newRow.find('input.price-input').val('');
                newRow.find('input.quantity-input').val('');
                newRow.find('input.total-input').val('');

                // Remove any existing remove button
                newRow.find('.remove-row').remove()

                if ($('#productRowsContainer .row').length > 0) {
                    // Remove any existing .form-group in the last .col-1
                    newRow.find('.col-1:last .form-group').remove();

                    newRow.find('.col-1:last').append(
                        '<div class="form-group">' +
                        '<label for="total">Rem.</label>' +
                        '<button type="button" class="form-control btn btn-danger remove-row">x</button>' +
                        '</div>'
                    );
                }

                $('#productRowsContainer').append(newRow);
                // computeTotal();
            });

            // Event delegation for remove button
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.row').remove();
                computeTotal();
            });

            $('#stock').on('click', function(event) {
                // Check if any input in the first row is empty
                if ($('#productRowsContainer .row:first').find('select.product-select').val() === '' ||
                    $('#productRowsContainer .row:first').find('input.price-input').val() === '' ||
                    $('#productRowsContainer .row:first').find('input.quantity-input').val() === '') {
                    toastr.error('All fields in the first row are required.');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>

</x-layout.admin>
