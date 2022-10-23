@component('mail::message')
    <h4>Name : {{ $data["companyName"] }}</h4>
    <p> From: {{ $data["startDate"] }} to {{ $data["endDate"] }}  </p>
@endcomponent