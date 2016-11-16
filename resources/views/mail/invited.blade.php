<p>
    You have been invited to the {{ env('APP_NAME') }} forum with a role of {{ $invite->role }}.
</p>
<p>
    Click <a href="{{ env('APP_URL') . '/register?code=' . $invite->code}}">here</a> to sign up, using your unique code.
    Make sure that you use register with this email address.
</p>
<p>
    If the above link didn't work, please copy and paste the following into your Browser's address bar: <em>{{ env('APP_URL') . '/register?code=' . $invite->code}}</em>
</p>
<p>
    Regards,
    <br />
    Admin @ {{ env('APP_NAME') }}.
</p>
