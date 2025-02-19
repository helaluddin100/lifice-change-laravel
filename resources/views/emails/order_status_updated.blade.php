<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
</head>

<body>
    <h2>Your Order Status has been Updated</h2>
    <p>Dear {{ $order->name }},</p>
    <p>Your order status has been updated to: <strong>{{ $order->order_status }}</strong>.</p>

    <p>Your order is from the shop: <strong>{{ $shop->name }}</strong> (Shop ID: {{ $shop->logo }}).</p>

    <p>Thank you for shopping with us!</p>
    <img src="{{ asset($shop->logo) }}" alt="Logo Not Found" style="width: 100px; height: 100px;">
    <p>Address: {{ $shop->address }}</p>
    <p>Phone: {{ $shop->number }}</p>
    <p>Email: {{ $shop->email }}</p>
</body>

</html>
