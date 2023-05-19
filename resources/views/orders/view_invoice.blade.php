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

        <br /><br /><br /><br />
    
<table style="margin-top: 130px" cellpadding=5 border=0 width="100%"> 
        <tr>
            <td style="width:45%">
                {{ $company_name }}<br />
                {!! $address !!}
                {{ $city }}<br />
                {{ $post_code }}<br>
                <br>
                Email : {{ $email }}<br />
            </td>
            
            <td>
                Invoice #: {{ $invoice_id }}<br />
                Created: {{ $created_date }}<br />
                Paid: {{ $paid_date }}
            </td>
        </tr>
    </table>
<br />
        <table cellspacing="0" cellpadding=5 border=0 width="100%">
            <tr style="background-color: #ecf6fd">
                <th cellpadding="3"><b>SL </b></th>
                <th cellpadding="3"><b>Service Name</b></th>
                <th cellpadding="3"><b>Plan</b></th>
                <th cellpadding="3"><b>Order Date</b></th>
                <th cellpadding="3"><b>Unit Price</b></th>
                <th cellpadding="3"><b>VAT (%)</b></th>
                <th cellpadding="3"><b>Net Amt.</b></th>
                <th cellpadding="3"><b>Gross Amt.</b></th>
                
            </tr>
            @php $index = 1; @endphp
            @foreach($orders as $order)

            
            <tr>
                <td cellpadding="3">{{ $index++ }}</td>
                <td cellpadding="3">{{ $order->pname }}</td>
                <td cellpadding="3">{{ $order->plan }}</td>
                <td cellpadding="3">{{ $order->orderdate }}</td>
                <td cellpadding="3">{{ $order->quantity }} x {{ $order->unit_price }}</td>
                <td cellpadding="3">{{ $order->vat }}</td>
                <td cellpadding="3">&pound;{{ number_format($order->net, 2) }}</td>
                <td cellpadding="3">&pound;{{ number_format($order->gross, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td  cellpadding="10" colspan="6">&nbsp;</td>
                <td  cellpadding="10" colspan="2" >&nbsp;</td>
            </tr>
            <tr style="background-color: #ccc">
                <td colspan="6"><h5>Gross Amount </h5></td>
                <td align="right" colspan="2" ><h5>&pound;{{ $gross_amount }} </h5></td>
            </tr>
           
        </table>

        </body>
</html>
