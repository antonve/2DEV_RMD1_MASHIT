<div id="error500">
    {{if $dev }}
    <h1>Internal Server Error</h1>
    <p>{{$error}}</p>
    <h1>Stack trace</h1>
    <ul>
        {{foreach $trace as $message}}
        <li>{{$message.file}} on line {{$message.line}}</li>
        {{/foreach}}
    </ul>
    {{else}}
    <h1>We're sorry, but something went wrong.</h1>
    <p>The page you're trying to access is not available or doesn't exist (yet).</p>
    {{/if}}
</div>
