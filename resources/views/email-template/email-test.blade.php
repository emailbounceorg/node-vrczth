<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>email</title>
    <style type="text/css">
        .main-div {
            padding: 32px 20px 60px;
            min-width: 640px;
            background: #f3f5f7
        }

        .div-table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .logo {
            width: 180px;
            height: auto;
        }

        .table {
            width: 100%;
            margin: 0px 0 0px;
            line-height: 24px;
            color: #14253f;
        }

        .p {
            font-weight: 500;
            margin: 0;
            font-size: 15px;
        }

        .p-right {
            font-size: 13px;
            text-align: right;
        }

        .td {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-2 {
            width: 100%;
            padding: 22px 12px 22px 40px;
            background: #fee8e7;
            color: #14253f;
        }

        .web-title {
            font-size: 15px;
            line-height: 24px;
        }

        .close-td {
            vertical-align: top;
            width: 20px;
            padding: 5px 8px 0 0;
        }

        .h4-title {
            margin: 0;
            padding: 0;
            font-weight: 700;
            font-size: 22px;
            line-height: 32px;
            color: #14253f;
        }

        .div-padding {
            padding: 32px 40px;
        }

        .a-button {
            display: inline-block;
            margin: 24px 0;
            padding: 7px 24px;
            text-decoration: none;
            background: #2672fc;
            border-radius: 4px;
            font-weight: 500;
            font-size: 15px;
            line-height: 24px;
            color: #fff;
        }

        .footer-td {
            font-size: 14px;
            line-height: 16px;
            letter-spacing: -.01em;
            color: #70829a;
        }

        .footer-p {
            margin: 24px 0 12px;
        }
    </style>
</head>

<body>
    <div class="main-div">
        <table cellpadding="0" cellspacing="0" class="div-table">
            <thead>
                <tr>
                    <td>
                        <a href="{{ URL::to('/') }}" target="_blank">
                            <img src="{{ getLogo()['logo'] }}" class="logo" data-bit="iit">
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="p">Notification for
                                            <a
                                                href="{{ $actionUrl ?? env('APP_URL') }}"target="_blank">{{ $actionUrl ?? env('APP_URL') }}</a>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="p-right">
                                            @php
                                                $date = \Carbon\Carbon::create(date('Y-m-d  H:i:s'));
                                                echo $formattedDate = $date->format('F j, Y (H:i:s)');
                                            @endphp
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="td">
                        <table class="table-2">
                            <tbody>
                                <tr>
                                    <td>
                                        <h4 class="h4-title">SMTP configuration successfully</h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="div-padding">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                            <a class="a-button" style="color: white" href="{{ URL::to('/') }}" target="_blank">
                               Done!
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="footer-td">
                        <p class="footer-p">This notification is sent to you as a part of your {{ env('APP_NAME') }} account</p>
                        <p>© {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
