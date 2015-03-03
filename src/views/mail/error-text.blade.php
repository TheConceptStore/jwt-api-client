Error while using API

An error occured during using API: {{ $url }}

Method: {{ $method }}
Endpoint: {{ $endpoint }}
@if(!empty($options))
Options: {{ $options }}
@endif
Message: {{ $exceptionMessage }}

Trace:
{{ $trace }}