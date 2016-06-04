<div id="register-page">
    <h1>Register</h1>
    <form action="{{$root}}/user/register" method="post" id="register_form">
        <fieldset>
            <legend>Register</legend>
            <label for="username_reg">Username</label><br />
            <input placeholder="Username" type="text" name="register[username]" id="username_reg" class="required {{if isset($error_username)}}error{{/if}}" value="{{$reg_username}}" required autofocus />
            {{if isset($error_username)}}<div class="error">{{$error_username}}</div>{{/if}}
            <br />
            <label for="password3">Password</label><br />
            <input placeholder="Password" type="password" name="register[password]" id="password3" class="required {{if isset($error_password)}}error{{/if}}" required pattern=".{literal}{6,}{/literal}" />
            {{if isset($error_password)}}<div class="error">{{$error_password}}</div>{{/if}}
            <br />
            <label for="password2">Password verification</label><br />
            <input placeholder="Password verification" type="password" name="register[password2]" class="required {{if isset($error_password2)}}error{{/if}}"  id="password2" required pattern=".{literal}{6,}{/literal}" />
            {{if isset($error_password2)}}<div class="error">{{$error_password2}}</div>{{/if}}
            <br />
            <label for="email">Email</label><br />
            <input placeholder="Email" type="text" name="register[email]" id="email" class="required {{if isset($error_email)}}error{{/if}}" value="{{$reg_email}}" required />
            {{if isset($error_email)}}<div class="error">{{$error_email}}</div>{{/if}}
            <br />
            <label for="lastfm">Last.FM username</label><br />
            <input placeholder="Last.FM username" type="text" name="register[lastfm]" id="lastfm" value="{{$reg_lastfm}}" required />
            {{if isset($error_lastfm)}}<div class="error">{{$error_lastfm}}</div>{{/if}}
            <br />
            <input type="submit" value="Register" />

        </fieldset>
    </form>
</div>
