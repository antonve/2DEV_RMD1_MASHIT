<div id="my-concerts">
    <h1>My concerts</h1>
    <ul>
    {{foreach $events as $event}}
        <li>
            <a class="event" href="{{$root}}/concert/{{$event->getId()}}/{{$event->getName()}}">
            {{$event->getName()}} ({{date("d.m.y", strtotime($event->getDate()))}}) @
            {{$event->getLocation()}}
            </a>
            <a class="remove noload" href="{{$root}}/concert/remove/{{$event->getId()}}/{{$event->getName()}}">Remove &raquo;</a>
        </li>
    {{/foreach}}
    {{if count($events) == 0}}
        <li>
            You haven't added any concerts yet.
        </li>
    {{/if}}
    </ul>
</div>
