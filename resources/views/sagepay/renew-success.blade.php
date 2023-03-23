@extends('layouts.app')

@section('content')
    
    <script>
       
       alert('Transaction completed!!!');
       window.close();
       window.opener.location = '/clients/{{ $client_id }}/view';

    </script>

@endsection
