<h1>Login</h1>
<form action="{{$root}}/user/login" method="post" id="login-page" >
    <fieldset>
        <input type="text" placeholder="Email" name="email" />{{if isset($error_login) }}<div class="error">{{$error_login}}</div>{{/if}}
        <br />
        <input placeholder="Paswoord" type="password" name="password" /><br />
        <div class="remember_me">
            <input type="checkbox" id="remember_me_page" name="remember_me" />
            <label for="remember_me_page">Onthouden?</label> <br/>
        </div>
        <input type="submit" value="Log in"/>
        <div class="clearfix"></div>
    </fieldset>
</form>

<a href="{{$root}}/user/register">Nog geen lid?</a><br />
<a href="{{$root}}/user/reset">Paswoord vergeten?</a>
