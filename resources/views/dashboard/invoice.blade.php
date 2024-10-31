<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ getLogo()['favicon']  }}" />

    <style>
       body {
            font-family: "Avenir", serif !important;
        }
        .invoice {
            padding: 0 !important;
            font-family: "Avenir", serif !important;
            font-weight: 100;
            box-sizing: border-box;
            padding: 20px;
            border-radius: 5px;
            background: #fff;
        }
        .header {
            display: flex !important;
            width: 100% !important;
            border-bottom: 2px solid #eee;
            align-items: center;
        }
        .header--invoice {
            order: 2 !important;
            text-align: right !important;
            width: 50% !important;
            margin: 0 !important;
            padding: 0 !important;
            position: absolute;
            margin-top: 50%;
            margin-left: 50% !important;
        }
        .invoice--date,
        .invoice--number {
            font-size: 12px;
            color: #494949;
        }
        .invoice--recipient {
            /* margin-top: 25px !important; */
            margin-bottom: 4px !important;
        }
        .invoice--recipient span {
            font-size: 18px !important;
        }
        .header--logo {
            order: 1 !important;
            font-size: 32px !important;
            width: 60% !important;
            font-weight: 900 !important;
        }
        .logo--address {
            font-size: 12px;
            padding: 4px;
        }
        .description {
            margin: auto;
            text-align: justify;
        }
        .items--table {
            width: 100%;
            padding: 10px;
        }
        .items--table thead {
            background: #ddd;
            color: #111;
            text-align: center;
            font-weight: 800;
        }
        .items--table tbody {
            text-align: center;
        }
        .items--table .total-price {
            border: 2px solid #444;
            padding-top: 4px;
            font-weight: 800;
            background: rgb(238, 234, 234);
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .content {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <article class="invoice">
        <header class="header">
            <h1 class="header--invoice">INVOICE
                <div class="invoice--date">
                    {{ $data->created_at->format('M d, Y : H:i:s') }}
                </div>
                <div class="invoice--number">
                    INVOICE #
                    <span>{{ $user->id }}</span>
                </div>
                <div class="invoice--recipient">
                    {{ $user->name }}
                </div>
            </h1>
            <nav class="header--logo">
                <div class="header--logo-text">
                    {{ env('APP_NAME') }}
                </div>
                <div class="logo--address">
                    {{ $settings->address  ?? ''}}
                    <br>
                    <strong>                    {{ $settings->mobile  ?? ''}}
                    </strong>
                    <br>
                    <strong>{{ env('email') }}</strong>
                </div>
            </nav>
        </header>
        <section class="description">
            <h5>Invoice Notes / Details</h5>
            <p>
                Hi {{ $user->name }}, Thank you for the invoice related to the recent purchase.
            </p>
        </section>
        <section class="line-items">
            <table class="items--table">
                <thead>
                    <tr>
                        <td>Item</td>
                        <td>Qty</td>
                        <td>Rate</td>
                        <td>Total USD</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Credit Points <b>{{ $data->credit }}</b>
                        </td>
                        <td>
                            1
                        </td>
                        <td>
                            USD ${{ $data->amt }}
                        </td>
                        <td>
                            ${{ $data->amt }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                        </td>
                        <td class="total-price">
                            ${{ $data->amt }}.00
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section class="description">
            <h5>Payment Details</h5>

            <p class="footer-text">Certainly! If you need to update or provide a new contact address for remittance or
                have any questions regarding payment details, please reach out to us at {{ env('email') }}. We'll be
                happy to assist you further!

            </p>
        </section>
    </article>
</body>

</html>
