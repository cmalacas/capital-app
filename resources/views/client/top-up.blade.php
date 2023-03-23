<strong>Client Name:</strong>  {{ $client->first_name }} {{ $client->last_name }}<br />
<strong>Credit Amount:</strong> {{ number_format($virtual->credit_amount, 2, '.', ',') }}
