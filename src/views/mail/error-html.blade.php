<h1>Error while using API</h1>

<p>
    An error occured during using API: <b>{{ $url }}</b>
</p>

<p>
    <b>Method:</b> {{ $method }}<br />
    <b>Endpoint:</b> {{ $endpoint }}<br />
    @if(!empty($options))
        <b>Options:</b> {{ $options }}<br />
    @endif
    <b>Message:</b> {{ $exceptionMessage }}
</p>

<p>
    <b>Trace:</b><br />
    <pre>
{{ $trace }}
    </pre>
</p>