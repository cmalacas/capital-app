<html>
    <head>
        <style>
            
            html {
                margin: 20px;
                font-family: 'Helvetica';
            }

            body {
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
                        Capital Office Ltd is registered in England and Wales | Registered Address: 124 City Road, London EC1V 2NX                
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
                                {{ $order->company->name }}<br />
                                @if ($order->company->address_1 || $order->company->address_2)
                                    {{ $order->company->address_1 }} {{ $order->company->address_2 }}<br />                                
                                @elseif ($order->company->forwarding_address_1 || $order->company->forwarding_address_2)
                                    {{ $order->company->forwarding_address_1 }} {{ $order->company->forwarding_address_2 }}<br />                                
                                @endif                                
                                @if ($order->company->city || $order->company->state)  
                                    {{ $order->company->city }} {{ $order->company->state }}<br />
                                @endif
                                {{ $order->company->country }} {{ $order->company->post_code }}<br /><br />
                            </td>
                        </tr>
                        <tr>
                            <th align="left">Contact number</th>
                        </tr>
                        <tr>
                            <td>
                                {{ $order->company->phone_number }}<br /><br />
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
                            <td style="padding-bottom:20px;">{{ Carbon\Carbon::parse( $order->contract_startdate )->format("d-m-Y") }}</td>
                        </tr>

                        <tr>
                            <th align="left">Document Number</th>
                        </tr>

                        <tr>
                            <td style="padding-bottom:20px;">CPOO{{ $order->id }}</td>
                        </tr>

                        <tr>
                            <th align="left">Purchase Order Number</th>
                        </tr>

                        <tr>
                            <td style="padding-bottom:20px;">CPOO{{ $order->id }}</td>
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

            </tr>

            <tr>

                <td style="padding: 5px 0; vertical-align:top">
                    {{ strlen($order->product->code) ? $order->product->code : 'CPOP' . $order->product_id }}
                </td>

                <td style="padding: 5px 0 15px; vertical-align:top; line-height: 1.5">
                    {{ strlen($order->product_name) > 0 ? $order->product_name : $order->product->name }}
                    
                    @if( $order->scan_bundle == 40 ) 
                        <br />SCAN BUNDLE 100
                    @elseif ( $order->scan_bundle == 10 )
                        <br />SCAN BUNDLE 10
                    @elseif ( $order->scan_bundle == 14 )
                        <br />SCAN BUNDLE 20
                    @elseif ( $order->scan_bundle == 20 )
                        <br />SCAN BUNDLE 40
                    @endif

                    @if( $order->forwarding_address_fee > 0 ) 
                        <br />Forwarding Address Deposit
                    @endif

                    @if( $order->forwarding_call_fee == 72 )
                        <br
                         />Forwarding Calls Deposit + 207 Extra Charge
                    @elseif ( $order->forwarding_call_fee == 25 )
                        <br />Forwarding Calls Deposit
                    @endif

                    @foreach( $order->extras as $x) 
                    <br />- {{ $x->product->name }}
                    @endforeach
                </td>

                <td style="padding: 5px 0; vertical-align:top">1</td>

                <td align="right" style="padding: 5px 0; vertical-align:top">&pound; {{ number_format($order->amount, 2, '.', ',') }}</td>                

            </tr>

            <tr>

                <th colspan="3" align="right" style="border-top: solid 1px #000; padding: 5px 0;">Sub Total</th>
                
                <th align="right" style="border-top: solid 1px #000; padding: 5px 0;">&pound; {{ number_format($order->amount, 2, '.', ',') }}</th>
                

            </tr>

            @php

                $total = $order->amount;

                $discount_percentage = $order->discount_percentage;

                $total_discount_amount = $order->total_discount_amount;

                $vat = 20;

                $vat_amount = ($total - $total_discount_amount) * $vat / 100;

                $total_amount = $order->total_amount;

            @endphp

            @if ($total_discount_amount > 0)

            <tr>

                <th colspan="3" align="right" style="padding:5px 0">Discount Amount ({{ number_format($discount_percentage) }}%)</th>
                <th align="right" style="color:red">&pound; -{{ number_format($total_discount_amount, 2, '.', ',') }}</th>

            </tr>

            @endif

            <tr>
                

                <th colspan="3" align="right" style="border-bottom: solid 1px #000; padding: 5px 0;">VAT (20%)</th>
                
                <th align="right" style="border-bottom: solid 1px #000; padding: 5px 0;">&pound; {{ number_format($vat_amount, 2, '.', ',') }}</th>

            </tr>

            <tr>

                <th colspan="3" align="right" style="border-bottom: solid 1px #000; padding: 5px 0;">Total</th>

                <th align="right" style="border-bottom: solid 1px #000; padding: 5px 0;">&pound; {{ number_format($order->total_amount, 2, '.', ',') }}</th>

            </tr>

            

            

        </table>
    </body>
</html>