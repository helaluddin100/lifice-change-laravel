<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>

<body>
    <h1>Congratulations! {{ $shop->name }}</h1>
    <p>You have received a new order in your shop. Below are the details:</p>
    <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
    <p><strong>Customer Name:</strong> {{ $order->name }}</p>
    <p><strong>Total Price:</strong> {{ $order->total_price }}</p>
    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
    <p>Thank you for shopping with us!</p>
</body>

</html>
