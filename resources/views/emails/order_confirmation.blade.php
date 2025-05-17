{{-- <!DOCTYPE html>
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

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Confirmation</title>
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td width="100%" align="center" valign="top" bgcolor="#eeeeee" height="20"></td>
            </tr>
            <tr>
                <td bgcolor="#eeeeee" align="center" style="padding: 0px 15px 0px 15px">
                    <table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="'0"
                        style="
                                max-width: 600px;
                                width: 100%;
                                border-radius: 5px;
                            "
                        align="center">
                        <tr>
                            <td align="center" style="margin-bottom: 30px; width: 100%">
                                <div style="margin-top: 40px">
                                    <img style="
                                                text-align: center;
                                                width: 60px;
                                            "
                                        src="https://iili.io/3rCS2OQ.png" alt="BuyTiq" />
                                    <h2
                                        style="
                                                font-family: sans-serif;
                                                font-size: 20px;
                                                color: #7922e6;
                                                font-weight: bold;
                                                margin-top: 10px;
                                                text-align: center;
                                                padding: 0;
                                            ">
                                        Congratulations!
                                    </h2>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div
                                    style="
                                            border-top: 1px solid #7922e6;
                                            padding-top: 20px;
                                        ">
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                color: #000;
                                                margin: 0px;
                                                margin-bottom: 10px;

                                                padding: 0;
                                                margin-left: 20px;
                                            ">
                                        <strong>Order ID:</strong> {{ $order->order_id }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p
                                    style="
                                            font-family: sans-serif;
                                            color: #000;
                                            margin: 0px;
                                            margin-bottom: 10px;
                                            padding: 0;
                                            margin-left: 20px;
                                        ">
                                    <strong>Customer Name:</strong> {{ $order->name }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p
                                    style="
                                            font-family: sans-serif;
                                            color: #000;
                                            margin: 0px;
                                            margin-bottom: 10px;
                                            padding: 0;
                                            margin-left: 20px;
                                        ">
                                    <strong>Total Price:</strong> {{ $order->total_price }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p
                                    style="
                                            font-family: sans-serif;
                                            color: #000;
                                            margin: 0px;
                                            margin-bottom: 10px;
                                            padding: 0;
                                            margin-left: 20px;
                                        ">
                                    <strong>Address: </strong> {{ $order->address }} , {{ $order->upazila }},
                                </p>
                                <p
                                    style="
                                            font-family: sans-serif;
                                            color: #000;
                                            margin: 0px;
                                            margin-bottom: 10px;
                                            padding: 0;
                                            margin-left: 20px;
                                        ">
                                    {{ $order->district }}, {{ $order->division }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p
                                    style="
                                            font-family: sans-serif;
                                            color: #000;
                                            margin: 0px;
                                            margin-bottom: 10px;
                                            padding: 0;
                                            margin-left: 20px;
                                        ">
                                    <strong>Payment Method:</strong> {{ $order->payment_method }}
                                </p>
                            </td>
                        </tr>
                        <tr align="center">
                            <td>
                                <div style="margin: 30px 0">
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                color: #7922e6;
                                                margin: 0px;
                                                margin-bottom: 10px;
                                                text-align: center;
                                                padding: 0;
                                                font-size: 20px;
                                            ">
                                        Thank you for shopping with us!
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td bgcolor="#eeeeee" align="center" style="padding: 20px 0px">
                    <table border="0" cellpadding="0" cellspacing="'0"
                        style="
                                max-width: 600px;
                                width: 100%;
                                padding: 0 15px;
                            "
                        align="center">
                        <tr>
                            <td align="center" style="text-align: center">
                                <div
                                    style="
                                            display: flex;
                                            width: 100%;
                                            justify-content: center;
                                            align-items: center;
                                            gap: 20px;
                                        ">
                                </div>
                                <a href="https://buytiq.com/contact"
                                    style="
                                            font-size: 18px;
                                            padding: 20px 0;
                                            font-weight: 600;
                                            color: #000;
                                            display: block;
                                            text-decoration: none;
                                            font-family: sans-serif;
                                        ">CONTACT
                                    US</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="
                                        text-align: center;
                                        padding: 0 15px;
                                        margin-top: 20px;
                                    ">
                                <a style="
                                            padding: 0 10px;
                                            text-decoration: none;
                                        "
                                    href="https://www.facebook.com/buytiq/" target="_blank">
                                    <img src="https://iili.io/3rBy2j9.png" alt="" />
                                </a>
                                <a style="
                                            padding: 0 10px;
                                            text-decoration: none;
                                            width: 30px;
                                            height: 30px;
                                        "
                                    href="https://www.linkedin.com/in/buytiq" target="_blank">
                                    <img src="https://iili.io/3rCHp3J.png" alt="" />
                                </a>
                                <a style="
                                            padding: 0 10px;
                                            text-decoration: none;
                                            width: 30px;
                                            height: 30px;
                                        "
                                    href="https://www.instagram.com/buytiq_official" target="_blank">
                                    <img src="https://iili.io/3rCdk0u.png" alt="" />
                                </a>

                                <a style="
                                            padding: 0 10px;
                                            text-decoration: none;
                                            width: 30px;
                                            height: 30px;
                                        "
                                    href="https://x.com/buytiq1" target="_blank">
                                    <img src="https://iili.io/3rC2GB1.png" alt="" />
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding-top: 30px">
                                <a href="https://buytiq.com"
                                    style="
                                            text-decoration: none;
                                            font-family: sans-serif;
                                            color: #969696;
                                            font-size: 14px;
                                            font-weight: 400;
                                        ">Home</a>

                                <a href="https://buytiq.com/privacy-policy"
                                    style="
                                            padding: 0 20px;
                                            text-decoration: none;
                                            font-family: sans-serif;
                                            color: #969696;
                                            font-size: 14px;
                                            font-weight: 400;
                                        ">Privacy
                                    Policy</a>
                                <a href="https://buytiq.com/terms"
                                    style="
                                            text-decoration: none;
                                            font-family: sans-serif;
                                            color: #969696;
                                            font-size: 14px;
                                            font-weight: 400;
                                        ">Terms
                                    & Conditions</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="margin-top: 20px; display: block">
                                <hr />
                                <p
                                    style="
                                            margin: 5px 0;
                                            margin-top: 10px;
                                            font-family: sans-serif;
                                            color: #969696;
                                            font-size: 12px;
                                            line-height: 18px;
                                        ">
                                    This email was sent by BuyTiq (
                                    Mohammadpur, Dhaka, Bangladesh). You
                                    were sent this email because you agreed
                                    to get latest updates from us . If you
                                    don't want these updates anymore, you
                                    can mute or
                                    <span><a href=""
                                            style="
                                                    text-decoration: underline;
                                                    font-size: 12px;
                                                    font-family: sans-serif;
                                                    color: #969696;
                                                    font-weight: 700;
                                                ">Unsubscribe</a></span>
                                </p>
                                <p>
                                    <a href="https://buytiq.com" target="_blank"
                                        style="
                                                text-decoration: underline;
                                                font-size: 12px;
                                                font-family: sans-serif;
                                                color: #969696;
                                                font-weight: 500;
                                            ">https://buytiq.com</a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
