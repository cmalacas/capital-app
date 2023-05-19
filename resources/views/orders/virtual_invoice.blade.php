<html>
    <head>
        <style>
            
            html {
                margin: 20px;
            }

            body {
                font-family: 'Helvetica';
                font-size: 14px;
                margin: 20px;
            }

            header {
                position: fixed;
            }

            footer {
                position: fixed;
                bottom:50px;
            }

        </style>
    </head>
    <body>
        <header>
            <table width="100%" cellspacing=0 border=0>
                <tr>
                    <td><img style="width:250px" src={{ asset('/images/2021-logo.png') }} /></td>
                    <td align="right"><h2 style="color: #0876c3">Invoice</h2></td>
                </tr>
            </table>
            <p style="color: #0876c3; line-height: 1.3; margin-top: 15px;">124 City Road, London EC1V 2NX<br />Tel 44 (0) 207 566 3939 | https://yourvirtualofficelondon.co.uk</p>
        </header>

        <footer>
            <table width="100%" cellspacing=0 border=0>
                <tr>
                    <td style="color: #0876c3; font-size: 9px;" align="right">
                        Company Number: 06294297 | VAT No: 976201416 | Anti-money laundering registration number: XZML00000125126 | ICO No: ZA084808
                    </td>
                </tr>
                <tr>
                    <td style="color: #0876c3; font-size: 9px;" align="right">
                        Capital Office Ltd is registered in England and Wales | Registered Address:  124 City Road, London EC1V 2NX
                    </td>
                </tr>
            </table>
        </footer>

        <table style="margin-top: 130px;" width="100%" cellspacing=0 border=0>

            <tr>

                <td style="width:70%; vertical-align: top">
                    <table width="100" cellspacing=0 border=0>""
                        <tr>
                            <th align="left">Address</th>
                        </tr>
                        <tr>
                            <td>
                                {{ $virtual->client->first_name }} {{ $virtual->client->last_name }}<br />
                                @if ($virtual->client->address)
                                    {{ $virtual->client->address }}<br />
                                @endif
                                @if ($virtual->client->city)  
                                    {{ $virtual->client->city }}<br />
                                @endif
                                {{ $virtual->client->country }} {{ $virtual->client->post_code }}<br /><br />
                            </td>
                        </tr>
                        <tr>
                            <th align="left">Contact number</th>
                        </tr>
                        <tr>
                            <td>
                                {{ $virtual->client->phone_number }}<br /><br />
                            </td>
                        </tr>
                    </table>
                </td>

                <td>

                    <table width="100%" cellspacing=0 border=0>

                        <tr>

                            <th align="left">Document Type</th>

                        </tr>

                        <tr>
                            <td style="padding-bottom:20px;">Invoice</td>
                        </tr>

                        <tr>

                            <th align="left">Date (tax point)</th>

                        </tr>

                        <tr>
                            <td style="padding-bottom:20px;">{{ Carbon\Carbon::parse( $virtual->created )->format("d-m-Y") }}</td>
                        </tr>

                        <tr>
                            <th align="left">Document Number</th>
                        </tr>

                        <tr>
                            <td style="padding-bottom:20px;">CPOV{{ $virtual->id }}</td>
                        </tr>

                        <tr>
                            <th align="left">Purchase Order Number</th>
                        </tr>

                        <tr>
                            <td style="padding-bottom:20px;">CPOV{{ $virtual->id }}</td>
                        </tr>

                    </table>

                    

                </td>

            </tr>

        </table>

        <table style="margin-top:40px;" width="100%" cellspacing=0 border=0>

            <tr>

                <th style="border-bottom:solid 1px #000; border-top: solid 2px #000; padding: 5px 0;" align="left">Code</th>
                <th style="border-bottom:solid 1px #000; border-top: solid 2px #000; padding: 5px 0;" align="left">Product description</th>
                <th style="border-bottom:solid 1px #000; border-top: solid 2px #000; padding: 5px 0;" align="left">Qty</th>
                <th style="border-bottom:solid 1px #000; border-top: solid 2px #000; padding: 5px 0;" align="right">Price</th>
                <th style="border-bottom:solid 1px #000; border-top: solid 2px #000; padding: 5px 0;" align="right">VAT Rate</th>
                <th style="border-bottom:solid 1px #000; border-top: solid 2px #000; padding: 5px 0;" align="right">VAT</th>

            </tr>

            <tr>

                <td style="padding: 5px 0; vertical-align:top">
                    PAYMENT TOP UP
                </td>

                <td style="padding: 5px 0 15px; vertical-align:top; line-height: 1.5">
                    PAYMENT TOP UP ( {{ $virtual->credit_amount }} )
                </td>

                @php

                    $amount = $virtual->credit_amount;
                    $vat = 20;

                @endphp

                <td style="padding: 5px 0; vertical-align:top">1</td>

                <td align="right" style="padding: 5px 0; vertical-align:top">&pound; {{ number_format($amount, 2, '.', ',') }}</td>

                <td align="right" style="padding: 5px 0; vertical-align:top">{{ number_format($vat, 0, '.', '') }}%</td>

                <td align="right" style="padding: 5px 0; vertical-align:top">&pound; {{ number_format($amount * $vat / 100, 2, '.', ',' ) }}</td>

            </tr>

            <tr>

                <th colspan="3" align="right" style="border-bottom:solid 1px #000; border-top: solid 1px #000; padding: 5px 0;">Total</th>
                
                <th align="right" style="border-bottom:solid 1px #000; border-top: solid 1px #000; padding: 5px 0;">&pound; {{ number_format($amount, 2, '.', ',') }}</th>

                <th style="border-bottom:solid 1px #000; border-top: solid 1px #000; padding: 5px 0;">&nbsp;</th>

                <th align="right" style="border-bottom:solid 1px #000; border-top: solid 1px #000; padding: 5px 0;">&pound; {{ number_format( $amount * $vat / 100, 2, '.', ',' ) }}</th>

            </tr>

            
            @php

                $total = $amount;

                $vat_amount = $amount * $vat / 100;

                $discount_amount = 0;

                $total_amount = $total + $vat_amount - $discount_amount;

            @endphp

            <tr>
                <th colspan="3" align="right" style="padding:5px 0">Invoice Total inc. VAT</th>
                <th colspan="3" align="right">&pound; {{ number_format($total_amount, 2, '.', ',') }}</th>
            </tr>

        </table>
    </body>
</html>