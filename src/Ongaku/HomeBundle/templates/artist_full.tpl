<div id="artist-full">
    <h1>{{$artist->getName()}}</h1>
    <div id="bio">
    {{autop($artist->getBio())}}
    </div>
</div>
