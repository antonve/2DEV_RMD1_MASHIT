<div id="event-page">
    <h1>{{$event->getName()}} ({{date("d.m.y", strtotime($event->getDate()))}})</h1>

    <div id="lineup">
        <h2>Line up</h2>
        <ul>
        {{if count($event->getBands()) > 0}}
        {{foreach $event->getBands() as $band}}
            <li>
                <a href="{{$root}}/artist/{{$band}}">
                    {{$band}}
                </a>
            </li>
        {{/foreach}}
        {{else}}
            <li>
                No line up available yet.
            </li>
        {{/if}}
        </ul>

        {if isset($user) && !$event->getAdded() }
            <a class="add" href="{{$root}}/concert/add/{{$event->getId()}}/{{$event->getName()}}">Add event &raquo;</a>
        {/if}
        {if isset($user) && $event->getAdded() }
            <div class="add">You have added this event before.</div>
        {/if}
    </div>
    <div id="location">
        <h2>Location</h2>
        <p>
            {{$event->getLocation()}}
        </p>

        <div id="maps"></div>
    </div>
</div>

<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfebIiyaOo5-vxDpqgFXB0MIeCz2p_q-0&sensor=false">
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var geocoder = new google.maps.Geocoder();
        var address = $('#location > p').html();

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var mapOptions = {
                    zoom: 17,
                    center: new google.maps.LatLng(-34.397, 150.644),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }

                var map = new google.maps.Map(document.getElementById("maps"),
                        mapOptions);

                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            }
        });
    });
</script>script>
