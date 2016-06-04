<h1>Reset your password</h1>
<form action="{{$root}}/user/reset" method="post" id="reset-page" >
    <fieldset>
        <input type="text" placeholder="Email" name="email" />{{if isset($error_reset) }}<div class="error">{{$error_reset}}</div>{{/if}}
        <br/>

        <input type="submit" value="Reset password"/>
        <div class="clearfix"></div>
    </fieldset>
</form>
