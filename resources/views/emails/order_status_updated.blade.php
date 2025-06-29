{{-- <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Order Status Update</title>
    </head>

    <body>
        <h2>Your Order Status has been Updated</h2>
        <p>Dear {{ $order->name }},</p>
        <p>
            Your order status has been updated to:
            <strong>{{ $order->order_status }}</strong>.
        </p>

        <p>
            Your order is from the shop:
            <strong>{{ $shop->name }}</strong> (Shop ID: {{ $shop->logo }}).
        </p>

        <p>Thank you for shopping with us!</p>
        <img
            src="{{ asset($shop->logo) }}"
            alt="Logo Not Found"
            style="width: 100px; height: 100px"
        />
        <p>Address: {{ $shop->address }}</p>
        <p>Phone: {{ $shop->number }}</p>
        <p>Email: {{ $shop->email }}</p>
    </body>
</html>
--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Status Update</title>
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
                                    <a href="https://buytiq.com"
                                        style="
                                                text-decoration: none;
                                                font-family: sans-serif;
                                                color: #7922e6;
                                                font-size: 30px;
                                                font-weight: 900;
                                            "
                                        target="_blank">
                                        BUYTIQ
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle">
                                <div
                                    style="
                                            margin-top: 20px;
                                            background: #7922e6;
                                            padding: 20px;
                                        ">
                                    <h4
                                        style="
                                                font-family: sans-serif;
                                                font-size: 22px;
                                                color: #fff;

                                                font-weight: bold;
                                                margin: 0;
                                                padding: 0;
                                            ">
                                        Your Order Status has been Updated
                                    </h4>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="visit-blog" style="margin: 40px 50px">
                                    <h2
                                        style="
                                                font-family: sans-serif;
                                                font-size: 18px;
                                                color: #000;
                                                font-weight: bold;
                                                margin: 0;
                                                padding: 0;
                                            ">
                                        Dear {{ $order->name }}
                                    </h2>

                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 20px;
                                                font-weight: bold;
                                                color: #000;
                                            ">
                                        Your order status has been updated
                                        to:
                                        <strong>{{ $order->order_status }}</strong>.
                                    </p>

                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 16px;
                                                color: #000;
                                            ">
                                        Your order is from the shop:
                                        <strong>{{ $shop->name }}</strong>
                                        (Shop ID: {{ $shop->id }}).
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr align="end">
                            <td>
                                <div class="visit-blog" style="margin: 0 50px 40px 50px">
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 16px;
                                                color: #000;
                                            ">
                                        Thank you for shopping with us!
                                    </p>
                                    <img src="{{ asset($shop->logo) }}" alt="Logo Not Found"
                                        style="width: 100px; height: 100px" />
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 16px;
                                                color: #000;
                                            ">
                                        Address: {{ $shop->address }}
                                    </p>
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 16px;
                                                color: #000;
                                            ">
                                        Phone: {{ $shop->number }}
                                    </p>
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 16px;
                                                color: #000;
                                            ">
                                        Email: {{ $shop->email }}
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
                                            color: #969696;
                                            font-size: 14px;
                                            font-weight: 600;
                                            font-family: sans-serif;
                                        "
                                    href="https://www.facebook.com/buytiq/" target="_blank">
                                    Facebook
                                </a>
                                <a style="
                                            padding: 0 10px;
                                            color: #969696;
                                            font-size: 14px;
                                            font-weight: 600;
                                            font-family: sans-serif;
                                        "
                                    href="https://www.linkedin.com/company/buytiq" target="_blank">
                                    Linkedin
                                </a>
                                <a style="
                                            padding: 0 10px;
                                            color: #969696;
                                            font-size: 14px;
                                            font-weight: 600;
                                            font-family: sans-serif;
                                        "
                                    href="https://x.com/buytiq1" target="_blank">
                                    Twitter
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
