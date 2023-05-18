
<p>Dear Sir / Madam,</p>

<p>We have received an order for "Cash Plus Business Banking Referral"</p>

<p>This purchase relates to the company, if applicable:</br>
<strong>{{ $order->company->name }}</strong></p>

<p>Our reference for this purchase is <strong>{{ $order->id }}</strong></p>

<p>The customer details are below:</p>

<table>
  <tr>
    <th style="text-align:left">Client Company name:</th><td>{{ $order->company->name }}</td>
  </tr>
  <tr>
    <th style="text-align:left">Client full name:</th><td>{{ $order->client->first_name }} {{ $order->client->last_name}}</td>
  </tr>
  <tr>
    <th style="text-align:left">Client contact email:</th><td>{{ $order->client->email }}</td>
  </tr>
  <tr>
    <th style="text-align:left">Client contact phone number:</th><td>{{ $order->client->phone_number }}</td>
  </tr>
</table>