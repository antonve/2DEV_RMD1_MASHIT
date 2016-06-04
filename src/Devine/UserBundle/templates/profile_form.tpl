<div id="profile-page">
    <h1>Profile</h1>
    <form action="{{$root}}/user/profile" method="post" id="profile_form">
        <fieldset>
            <legend>Required</legend>
            <label for="username_profile">Username</label><br />
            <input type="text" name="profile[username]" id="username_profile" class="required {{if isset($error_username)}}error{{/if}}" value="{{$profile_username}}" /><br />
            {{if isset($error_username)}}<div class="error">{{$error_username}}</div>{{/if}}

            <label for="password3_profile">New password</label><br />
            <input type="password" name="profile[password]" id="password3_profile" class="{{if isset($error_password)}}error{{/if}}" /><br />
            {{if isset($error_password)}}<div class="error">{{$error_password}}</div>{{/if}}

            <label for="password2_profile">Password verification</label><br />
            <input type="password" name="profile[password2]" class="required {{if isset($error_password2)}}error{{/if}}"  id="password2_profile" /><br />
            {{if isset($error_password2)}}<div class="error">{{$error_password2}}</div>{{/if}}

            <label for="email_profile">Email</label><br />
            <input type="text" name="profile[email]" id="email_profile" class="required {{if isset($error_email)}}error{{/if}}" value="{{$profile_email}}" /><br />
            {{if isset($error_email)}}<div class="error">{{$error_email}}</div>{{/if}}

            <label for="firstname_profile">First name</label><br />
            <input type="text" name="profile[firstname]" id="firstname_profile" value="{{$profile_firstname}}" /><br />

            <label for="lastname_profile">Last name</label><br />
            <input type="text" name="profile[lastname]" id="lastname_profile" value="{{$profile_lastname}}" /><br />

            <label for="old_password_profile">Old password</label><br />
            <input type="password" name="profile[old_password]" class="required {{if isset($error_old_password)}}error{{/if}}"  id="old_password_profile" /><br />
            {{if isset($error_old_password)}}<div class="error">{{$error_old_password}}</div>{{/if}}
            <br />
            <input type="submit" value="Update profile" />

        </fieldset>
    </form>
</div>
