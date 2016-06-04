<form action="{{$root}}/search" method="post" id="search">
    <fieldset>
        <label for="search_query">Search</label>
        <input type="text" id="search_query" name="search_query" value="{if isset($query)}{$query}{/if}" placeholder="The Ghost Inside" />
        <input type="submit" value="Search!" />
    </fieldset>
</form>
