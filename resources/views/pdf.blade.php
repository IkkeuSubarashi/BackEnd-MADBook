<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation #{{ $quotation->id }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="font-weight-bold">Quotation #{{ $quotation->id }}</h2>
                <p><strong>Subject: </strong>{{ $quotation->subject }}</p>
            </div>
        </div>

        <!-- Borrower Information -->
        <div class="row mb-4">
            <div class="col-6">
                <p><strong>For:</strong> {{ $quotation->c_name }}</p>
                <p><strong>Phone:</strong> {{ $quotation->c_no }}</p>
                <p><strong>Address:</strong> {{ $quotation->c_address }}</p>
            </div>
            <div class="col-6 text-right">
                <p><strong>Quote No:</strong> {{ $quotation->id }}</p>
                <p><strong>Issue Date:</strong> {{ $quotation->issue_date }}</p>
                <p><strong>Valid Until:</strong> {{ $quotation->valid_date }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotation->q_items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>RM {{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="row mb-4">
            <div class="col-12 text-right font-weight-bold">
                <p>Total: RM {{ number_format($quotation->q_total, 2) }}</p>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="row">
            <div class="col-12">
                <p><strong>Notes:</strong> {{ $quotation->notes }}</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for modals, tooltips, etc.) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
