<div id="artist-page">
    <h1>{{$artist->getName()}}</h1>
    <div id="summary">
    {{autop($artist->getSummary())}}
        <a href="{{$root}}/artist/{{$name}}/full">Read more...</a>
    </div>
    <div id="bio">
    {{autop($artist->getBio())}}
    </div>

    <div id="gallery">
        <h2>Gallery</h2>
        <ul>
        {{foreach $images as $image}}
            <li>
                <a href="{{$root}}/artist/image/{{$image.filename}}" class="trigger noload">
                    <img src="{{$root}}/artist/image/{{$image.filename}}" alt="{{$name}}" />
                </a>
            </li>
        {{/foreach}}
        {{if count($images) == 0 }}
            <li class="not_found">
                Images not available.
            </li>
        {{/if}}
        </ul>
    </div>

    <div id="events">
        <h2>Concerts</h2>
        <ul>
        {{if array_key_exists('event', $events.events) }}
        {{foreach $events.events.event as $event}}
            {{if is_array($event) && array_key_exists('id', $event) && array_key_exists('title', $event)}}
            <li>
                <a class="event" href="{{$root}}/concert/{{$event.id}}/{{$event.title}}">
                {{$event.title}} ({{date("d.m.y", strtotime($event.startDate))}})<br />
                {{$event.venue.name}} {{$event.venue.location.city}}, {{$event.venue.location.country}}
                </a>
                {if isset($user) && !$event.added }
                    <a class="add noload" href="{{$root}}/concert/add/{{$event.id}}/{{$event.title}}">Add &raquo;</a>
                {/if}
                {if isset($user) && $event.added }
                    <div class="add">Added</div>
                {/if}
            </li>
            {{/if}}
        {{/foreach}}
        {{else}}
            <li>No events found.</li>
        {{/if}}
        </ul>
    </div>

    <div id="video">
        <h2>Watch live</h2>
        {{if isset($video)}}
        <iframe id="ytplayer" type="text/html" width="444" height="271"
                src="http://www.youtube.com/embed/{{$video}}?autoplay=0&origin=http://student.howest.be/anton.van.eechaute/20122013/RMDI/MASHIT/"
                frameborder="0"/>
        {{else}}
            <div class="not_found">No live videos found.</div>
        {{/if}}
    </div>
</div>
