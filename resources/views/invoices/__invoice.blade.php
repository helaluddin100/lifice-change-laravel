<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            width: 100%;
            /* padding: 20px; */
            /* border: 1px solid #ddd; */
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .invoice-header h1 {
            margin: 0;
        }

        .order-info,
        .product-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .order-info td,
        .product-table td,
        .product-table th {
            padding: 8px;
            text-align: left;
        }

        .order-info tr {
            border-bottom: 1px solid #ddd;
        }

        .product-table th {
            background-color: #f4f4f4;
        }

        .total {
            text-align: right;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="invoice-header" style="background: {{ $shop->color }}">
            <h1>Invoice</h1>
            <p>Invoice #{{ $order->order_id }} - Date: {{ $order->created_at->format('d M, Y') }}</p>
        </div>
        <table class="order-info">
            <tr>
                <td><strong>Customer:</strong> {{ $order->name }}</td>
                <td><strong>Customer:</strong> {{ $order->name }}</td>
                <td><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y') }}</td>
            </tr>

        </table>
        <!-- Order Information -->
        <table class="order-info">
            <tr>
                <td><strong>Customer:</strong> {{ $order->name }}</td>
                <td><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Email:</strong> {{ $order->email }}</td>
                <td><strong>Phone:</strong> {{ $order->phone }}</td>
            </tr>
        </table>

        <!-- Product Information -->
        <table class="product-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_items as $item)
                    <tr>
                        <td>
                            {{ $item->product_details->name }}
                        </td>
                        <td>{{ $item->color }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            {{ number_format($item->price, 2) }}
                        </td>
                        <td>
                            {{ number_format($item->quantity * $item->price, 2) }}
                        </td>

                    </tr>
                @endforeach

                <tr>
                    <td colspan="4" class="total"></td>
                    <td class="total">Total</td>
                    <td>
                        {{ number_format($order->total_price, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="total"></td>
                    <td class="total">Delivery Charge</td>
                    <td>
                        {{ number_format($order->delivery_charge, 2) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="total"></td>
                    <td class="total">VAT/TAX</td>
                    <td>
                        {{ number_format(($order->total_price / 100) * $shop->vat_tax) }}
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="total"></td>
                    <td class="total">Sub Total</td>
                    <td>
                        @if ($shop->country == 1)
                            ৳
                        @else
                            $
                        @endif
                        {{ number_format($order->total_price + ($order->total_price / 100) * $shop->vat_tax + $order->delivery_charge) }}
                    </td>
                </tr>
            </tbody>
        </table>


    </div>

</body>

</html>
