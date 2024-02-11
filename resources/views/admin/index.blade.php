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
                                                                <div class="product-container">
                                                                    @foreach ($transaction as $saleItem)
                                                                        <div class="product">
                                                                            <p class="product-name">
                                                                                {{ $saleItem->product->name }} -
                                                                                {{ ucfirst($saleItem->product->product_type) }}
                                                                            </p>
                                                                            <div class="quantity-price">
                                                                                <p class="quantity">
                                                                                    Quantity: {{ $saleItem->quantity }}
                                                                                </p>
                                                                                <p class="amount">
                                                                                    Amount: ₦{{ number_format($saleItem->amount, 2) }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <br>
                                                                <form
                                                                    action="{{ route('complete.sale', ['transactionId' => $firstSale->trans_id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button class="btn btn-success" id="stock"
                                                                        type="submit" title="To complete this sale">
                                                                        <i class="fas fa-check fa-sm fa-fw"></i>
                                                                        Confirm Sales (Total:
                                                                        ₦{{ number_format($totalAmount, 2) }})
                                                                    </button>
                                                                </form>
                                                                <style>
                                                                    .product-container {
                                                                        display: flex;
                                                                        flex-wrap: nowrap;
                                                                        /* Ensure products are in a single row */
                                                                    }

                                                                    .product {
                                                                        padding: 10px;
                                                                        /* Adjust as needed for spacing between products */
                                                                        border-right: 1px solid #ccc;
                                                                    }

                                                                    .product-name {
                                                                        font-weight: bold;
                                                                        font-size: .8em
                                                                    }

                                                                    .quantity-price {
                                                                        display: flex;
                                                                        flex-direction: column;
                                                                        font-size: .8em
                                                                    }
                                                                </style>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</x-layout.admin>
