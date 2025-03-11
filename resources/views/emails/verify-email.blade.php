<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $user->name }}</title>
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
                                    <a href="https://buytiq.com" style="text-decoration: none" target="_blank">
                                        <img style="
                                                    text-align: center;
                                                    width: 150px;
                                                "
                                            src="https://i.postimg.cc/xjLdQ9ZT/logo-2.png" alt="BuyTiq" />
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
                                    <img style="width: 150px"
                                        src="https://i.postimg.cc/W47DsTzk/1597218650916-xxxxc.png" alt="" />
                                    <h3
                                        style="
                                                font-family: sans-serif;
                                                font-size: 14px;
                                                color: #fff;
                                                font-weight: 400;
                                            ">
                                        THANKS FOR SIGNING UP!
                                    </h3>
                                    <h4
                                        style="
                                                font-family: sans-serif;
                                                font-size: 28px;
                                                color: #fff;

                                                font-weight: bold;
                                                margin: 0;
                                                padding: 0;
                                            ">
                                        Verify Your E-mail Address
                                    </h4>
                                </div>
                            </td>
                        </tr>

                        <tr align="center">
                            <td>
                                <div class="visit-blog" style="margin: 40px 0">
                                    <h2
                                        style="
                                                font-family: sans-serif;
                                                font-size: 24px;
                                                color: #000;
                                                font-weight: bold;
                                                margin: 0;
                                                padding: 0;
                                            ">
                                        Hello, {{ $user->name }}
                                    </h2>
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 16px;
                                                color: #000;
                                            ">
                                        Your 6-digit verification code is:
                                    </p>
                                    <p
                                        style="
                                                font-family: sans-serif;
                                                font-size: 28px;
                                                font-weight: bold;
                                                color: #000;
                                            ">
                                        {{ $verificationCode }}
                                    </p>
                                    {{-- <p
                                            style="
                                                font-family: sans-serif;
                                                font-size: 16px;
                                                color: #000;
                                            "
                                        >
                                            Or, click the button below to verify
                                            your email:
                                        </p>
                                        <div style="margin-top: 30px">
                                            <a
                                                href="{{ $url }}"
                                                style="
                                                    font-family: sans-serif;
                                                    font-size: 18px;
                                                    background: #7922e6;
                                                    padding: 10px 30px;
                                                    margin-top: 10px;
                                                    color: #fff;
                                                    text-decoration: none !important;
                                                    border-radius: 30px;
                                                "
                                                >Verify Email</a
                                            >
                                        </div> --}}
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
                                    <img src="https://i.postimg.cc/4Nfk7GW5/1.png" alt="BuyTiq" />
                                </a>
                                <a style="
                                            padding: 0 10px;
                                            text-decoration: none;
                                            width: 30px;
                                            height: 30px;
                                        "
                                    href="https://www.linkedin.com/in/buytiq" target="_blank">
                                    <img src="https://i.postimg.cc/c6yvhH6r/3.png" alt="BuyTiq" />
                                </a>
                                <a style="
                                            padding: 0 10px;
                                            text-decoration: none;
                                            width: 30px;
                                            height: 30px;
                                        "
                                    href="https://www.tiktok.com/@buytiq" target="_blank">
                                    <img src="https://i.postimg.cc/jdFgxYmC/2.png" alt="BuyTiq" />
                                </a>

                                <a style="
                                            padding: 0 10px;
                                            text-decoration: none;
                                            width: 30px;
                                            height: 30px;
                                        "
                                    href="https://www.youtube.com/@BuyTiq" target="_blank">
                                    <img src="https://i.postimg.cc/Mp1yCk8C/4.png" alt="BuyTiq" />
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
