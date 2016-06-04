{{if isset($user) }}
Welcome, {{$user->getUsername()|escape}}.
{{else}}
<form action="{{$root}}/user/login" method="post" class="login" >
    <fieldset>
        <input type="text" placeholder="Email" name="email" />
        <input placeholder="Paswoord" type="password" name="password" />
        <div class="remember_me">
            <input type="checkbox" id="remember_me" name="remember_me" />
            <label for="remember_me">Onthouden?</label> <br/>
            <a href="{{$root}}/user/register" id="register">Not a member yet?</a>
        </div>
        <input type="submit" value="Log in"/>
        <div class="clearfix"></div>
    </fieldset>
</form>
{{/if}}
