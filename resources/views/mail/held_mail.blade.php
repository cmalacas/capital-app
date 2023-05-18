<table border=0 style="width:100%">
    <thead>
        <tr>
            <th style="border-right: solid 1px #ccc; border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; text-align:left; padding:5px;">Letter</th>
            <th style="border-right: solid 1px #ccc; border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; text-align:left; padding:5px;">Date</th>
            <th style="border-right: solid 1px #ccc; border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; text-align:left; padding:5px;">Action</th>
            <th style="border-bottom: solid 1px #ccc; border-top: solid 1px #ccc; text-align:left; padding:5px;">Reason For Holding</th>            
        </tr>
    </thead>
    <tbody>
        @foreach($helds as $h)
        
        @php

            $actions = [];
            $reasons = [];

            if ($h->scan_no_funds === 1) {

                $actions[] = 'Scan';
                $reasons[] = 'No Scan Funds';

            }

            if ($h->postage_no_funds === 1) {

                $actions[] = 'Posted';
                $reasons[] = 'No Postage Funds';

            }

            if ($h->collect === 1) {

                $actions[] = 'Mailbox';
                $reasons[] = 'Letter to collect';

            }            

            if ($h->pickup === 1) {

                $actions[] = 'Posted';
                $reasons[] = 'Office pickup';

            }

            if ($h->not_included === 1) {

                $actions[] = 'Posted';
                $reasons[] = 'Not Included';

            }

            if ($h->mlr_status === 1) {

                $actions[] = 'Posted';
                $reasons[] = 'Awaiting ID';

            }

        @endphp

        <tr>
            <td style="border-bottom: solid 1px #ccc; border-right: solid 1px #ccc; padding:5px;">{{ $h->product->name }}</td>
            <td style="border-bottom: solid 1px #ccc; border-right: solid 1px #ccc; padding:5px;">{{ \Carbon\Carbon::parse($h->date)->format("m/d/Y") }}</td>
            <td style="border-bottom: solid 1px #ccc; border-right: solid 1px #ccc; padding:5px;">{!! implode('<br />', $actions ) !!}</td>
            <td style="border-bottom: solid 1px #ccc; padding:5px;">{!! implode('<br />', $reasons) !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>