<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />

    <style>
        *,
        ::before,
        ::after {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb;
        }

        ::before,
        ::after {
            --tw-content: '';
        }

        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: 'Arial', sans-serif;

            /* font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; */
            font-feature-settings: normal;
            font-variation-settings: normal;
        }

        body {
            margin: 0;
            line-height: inherit;
            position: relative;
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px;
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit;
        }

        a {
            color: inherit;
            text-decoration: inherit;
        }

        b,
        strong {
            font-weight: bolder;
        }

        code,
        kbd,
        samp,
        pre {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 1em;
        }

        small {
            font-size: 80%;
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sub {
            bottom: -0.25em;
        }

        sup {
            top: -0.5em;
        }

        table {
            text-indent: 0;
            /* 1 */
            border-color: inherit;
            /* 2 */
            border-collapse: collapse;
            /* 3 */
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0;
        }

        button,
        select {
            text-transform: none;
        }

        button,
        [type='button'],
        [type='reset'],
        [type='submit'] {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none;
        }

        :-moz-focusring {
            outline: auto;
        }

        :-moz-ui-invalid {
            box-shadow: none;
        }

        progress {
            vertical-align: baseline;
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto;
        }

        [type='search'] {
            -webkit-appearance: textfield;
            outline-offset: -2px;
        }


        ::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit;
        }


        summary {
            display: list-item;
        }

        blockquote,
        dl,
        dd,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        figure,
        p,
        pre {
            margin: 0;
        }

        fieldset {
            margin: 0;
            padding: 0;
        }

        legend {
            padding: 0;
        }

        ol,
        ul,
        menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        /*
Reset default styling for dialogs.
*/

        dialog {
            padding: 0;
        }

        textarea {
            resize: vertical;
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af;
        }

        button,
        [role="button"] {
            cursor: pointer;
        }

        :disabled {
            cursor: default;
        }

        img,
        svg,
        video,
        canvas,
        audio,
        iframe,
        embed,
        object {
            display: block;
            /* 1 */
            vertical-align: middle;
            /* 2 */
        }

        img,
        video {
            max-width: 100%;
            height: auto;
        }

        [hidden] {
            display: none;
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
        }

        .fixed {
            position: fixed;
        }

        .bottom-0 {
            bottom: 0px;
        }

        .left-0 {
            left: 0px;
        }

        .table {
            display: table;
        }

        .h-12 {
            height: 3rem;
        }

        .w-1\/2 {
            width: 50%;
        }

        .w-full {
            width: 100%;
        }

        .border-collapse {
            border-collapse: collapse;
        }

        .border-spacing-0 {
            --tw-border-spacing-x: 0px;
            --tw-border-spacing-y: 0px;
            border-spacing: var(--tw-border-spacing-x) var(--tw-border-spacing-y);
        }

        .whitespace-nowrap {
            white-space: nowrap;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-b-2 {
            border-bottom-width: 2px;
        }

        .border-r {
            border-right-width: 1px;
        }

        .border-main {
            border-color: #5c6ac4;
        }

        .bg-main {
            background-color: #5c6ac4;
        }

        .bg-slate-100 {
            background-color: #f1f5f9;
        }

        .p-3 {
            padding: 0.75rem;
        }

        .px-14 {
            padding-left: 3.5rem;
            padding-right: 3.5rem;
        }

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .pb-3 {
            padding-bottom: 0.75rem;
        }

        .pl-2 {
            padding-left: 0.5rem;
        }

        .pl-3 {
            padding-left: 0.75rem;
        }

        .pl-4 {
            padding-left: 1rem;
        }

        .pr-3 {
            padding-right: 0.75rem;
        }

        .pr-4 {
            padding-right: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .align-top {
            vertical-align: top;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .italic {
            font-style: italic;
        }

        .text-main {
            color: #5c6ac4;
        }

        .text-neutral-600 {
            color: #525252;
        }

        .text-neutral-700 {
            color: #404040;
        }

        .text-slate-300 {
            color: #cbd5e1;
        }

        .text-slate-400 {
            color: #94a3b8;
        }

        .text-white {
            color: #fff;
        }

        @page {
            margin: 0;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }

        .watermark {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            pointer-events: none;
            z-index: 0;
        }

        .watermark img {
            width: 1200px;
            height: auto;
            transform: rotate(-30deg);
        }
    </style>
</head>

<body>

    {{-- {{ dd($order) }} --}}
    {{-- {{ dd($shop) }} --}}
    <div class="py-4">
        <div class="px-14 py-6">
            <table class="w-full border-collapse border-spacing-0">
                <tbody>
                    <tr>
                        <td class="w-full align-top">
                            <div>
                                @if ($shop->logo)
                                    <img src="{{ $shop->logo }}"
                                        style="max-width: 200px; cursor: pointer; width: auto;" alt="Shop Logo">
                                @else
                                    <p><strong>Shop Logo Not Available</strong></p>
                                @endif
                                {{-- <img src="{{ asset('storage/' . $shop->logo) }}" class="h-12" alt="Shop Logo" /> --}}
                            </div>
                        </td>

                        <td class="align-top">
                            <div class="text-sm">
                                <table class="border-collapse border-spacing-0">
                                    <tbody>
                                        <tr>
                                            <td class="border-r pr-4">
                                                <div>
                                                    <p class="whitespace-nowrap text-slate-400 text-right">Date</p>
                                                    <p style="color: {{ $shop->color }}"
                                                        class="whitespace-nowrap font-bold text-main text-right">
                                                        {{ $order->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </td>
                                            <td class="pl-4">
                                                <div>
                                                    <p class="whitespace-nowrap text-slate-400 text-right">Invoice #
                                                    </p>
                                                    <p style="color: {{ $shop->color }}"
                                                        class="whitespace-nowrap font-bold text-main text-right">
                                                        {{ $order->order_id }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-slate-100 px-14 py-6 text-sm">
            <table class="w-full border-collapse border-spacing-0">
                <tbody>
                    <tr>
                        <td class="w-1/2 align-top">
                            <div class="text-sm text-neutral-600">
                                <p class="font-bold">Bill To</p>
                                <p>Name: {{ $order->name }}</p>
                                <p>Email: {{ $order->email }}</p>
                                <p>Phone: {{ $order->phone }}</p>
                                <p>Address: {{ $order->address }} , {{ $order->upazila }},</p>
                                <p> {{ $order->district }},
                                    {{ $order->division }}</p>

                            </div>
                        </td>
                        <td class="w-1/2 align-top text-right">
                            <div class="text-sm text-neutral-600">
                                <p class="font-bold">Shop Info</p>
                                <p>Name: {{ $shop->name }}</p>
                                <p>Email: {{ $shop->email }}</p>
                                <p>Phone: {{ $shop->number }}</p>
                                <p>Address: {{ $shop->address }}, Bangladesh</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-14 py-10 text-sm text-neutral-700">
            <table class="w-full border-collapse border-spacing-0">
                <thead>
                    <tr>
                        <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main"
                            style="color: {{ $shop->color }}; border-color:  {{ $shop->color }}">#</td>
                        <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main"
                            style="color: {{ $shop->color }}; border-color:  {{ $shop->color }}">Name</td>
                        <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main"
                            style="color: {{ $shop->color }}; border-color:  {{ $shop->color }}">Color</td>
                        <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main"
                            style="color: {{ $shop->color }}; border-color:  {{ $shop->color }}">Size</td>
                        <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main"
                            style="color: {{ $shop->color }}; border-color:  {{ $shop->color }}">Qty</td>
                        <td class="border-b-2 border-main pb-3 pl-2 text-center font-bold text-main"
                            style="color: {{ $shop->color }}; border-color:  {{ $shop->color }}">Price</td>
                        <td class="border-b-2 border-main pb-3 pl-2 text-right font-bold text-main"
                            style="color: {{ $shop->color }}; border-color:  {{ $shop->color }}">Total</td>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_items as $item)
                        <tr>
                            <td class="border-b py-3 pl-3">{{ $item->id }}</td>
                            <td class="border-b py-3 pl-2"> {{ $item->product_details->name }}</td>
                            <td class="border-b py-3 pl-2 text-right">{{ $item->color }}</td>
                            <td class="border-b py-3 pl-2 text-center">{{ $item->size }}</td>
                            <td class="border-b py-3 pl-2 text-center"> {{ $item->quantity }}</td>
                            <td style="font-family: 'Arial', sans-serif; font-size: 14px;"
                                class="border-b py-3 pl-2 text-right">
                                BDT- {{ number_format($item->price, 2) }}
                            </td>
                            <td class="border-b py-3 pl-2 pr-3 text-right">
                                BDT- {{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="7">
                            <table class="w-full border-collapse border-spacing-0">
                                <tbody>
                                    <tr>
                                        <td class="w-full"></td>
                                        <td>
                                            <table class="w-full border-collapse border-spacing-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="border-b p-3">
                                                            <div class="whitespace-nowrap font-bold text-slate-400">
                                                                Sub Total:
                                                            </div>
                                                        </td>
                                                        <td class="border-b p-3 text-right">
                                                            <div class="whitespace-nowrap font-bold text-main"
                                                                style="color: {{ $shop->color }}">
                                                                BDT- {{ number_format($order->total_price, 2) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-3">
                                                            <div class="whitespace-nowrap font-bold text-slate-400">
                                                                Delivery
                                                                Charge:
                                                            </div>
                                                        </td>
                                                        <td class="p-3 text-right">
                                                            <div class="whitespace-nowrap font-bold text-main"
                                                                style="color: {{ $shop->color }}">
                                                                BDT-
                                                                {{ number_format($order->delivery_charge, 2) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-3">
                                                            <div class="whitespace-nowrap font-bold text-slate-400">
                                                                VAT/TAX:
                                                            </div>
                                                        </td>
                                                        <td class="p-3 text-right">
                                                            <div class="whitespace-nowrap font-bold text-main"
                                                                style="color: {{ $shop->color }}">
                                                                BDT-
                                                                {{ number_format(($order->total_price / 100) * $shop->vat_tax) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: {{ $shop->color }}"
                                                            class="bg-main p-3">
                                                            <div class="whitespace-nowrap font-bold text-white">
                                                                Total:</div>
                                                        </td>
                                                        <td style="background-color: {{ $shop->color }}"
                                                            class="bg-main p-3 text-right">
                                                            <div class="whitespace-nowrap font-bold text-white">
                                                                @if ($shop->country == 1)
                                                                    BDT-
                                                                @else
                                                                    $
                                                                @endif
                                                                {{ number_format($order->total_price + ($order->total_price / 100) * $shop->vat_tax + $order->delivery_charge) }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-14 text-sm text-neutral-700">
            <p class="text-main font-bold" style="color: {{ $shop->color }};">PAYMENT DETAILS</p>
            <p> Payment Method: {{ str_replace('_', ' ', $order->payment_method) }}</p>
            {{-- <p>Bank/Sort Code: 1234567</p>
            <p>Account Number: 123456678</p>
            <p>Payment Reference: BRA-00335</p> --}}
        </div>

        <div class="px-14 py-10 text-sm text-neutral-700">
            <p class="text-main font-bold" style="color: {{ $shop->color }};">Terms and Conditions</p>
            <p class="italic">All orders are processed based on availability, payment confirmation, and delivery terms.
            </p>
        </div>

        <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3">
            <a href="https://buytiq.com" target="_blank" rel="noopener noreferrer">BuyTiq</a>
            <span class="text-slate-300 px-2">|</span>
            buytiq1@gmail.com
            <span class="text-slate-300 px-2">|</span>
            +880 1744-220807
        </footer>
    </div>
    </div>
    <div class="watermark">
        <img src="/public/assets/images/logo2.png" alt="Website Logo">
    </div>
</body>

</html>
