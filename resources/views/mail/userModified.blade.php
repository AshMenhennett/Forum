<p>
    Your {{ env('APP_NAME') }} role has been changed from {{ $old_role }} to {{ $user->role }}.
</p>
<p>
    You may login as your new account role when you are ready: <a href="{{ env('APP_URL') . '/login' }}">{{ env('APP_NAME') }}</a>.
</p>
<p>
    If the above links didn't work, please copy and paste the following URLs into your Browser's address bar: <em>{{ env('APP_URL') . '/login' }}</em>
</p>
<p>
    Regards,
    <br />
    Admin @ {{ env('APP_NAME') }}.
</p>
