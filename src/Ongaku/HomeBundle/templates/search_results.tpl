<h1>Concert dates for...</h1>

{{include file="search.tpl"}}

<div id="search_results">
    <h1>Results for '{$query}'</h1>
    <div id="search-results-container">
        {{if {$results|@count} == 0}}
        <p class="error">Nothing was found.</p>
        {{else}}
        <ul>
        {{foreach $results as $result}}
            <li>
                <a href="{{$root}}/artist/{{$result.name}}">{{$result.name}}</a>
            </li>
        {{/foreach}}
        {{/if}}
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
