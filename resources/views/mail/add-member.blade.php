@component('mail::message')
# Welcome to {{ config('app.name') }}

Hello {{ $user->name }},

Your account has been successfully created! Below are your login credentials and important information to get you started.

## Account Details

**Email Address:** {{ $user->email }}

**Password:** `{{ $password }}`

## Important Security Steps

1. **First Login:** Use your email address and the password above to log in
2. **Change Your Password:** We strongly recommend changing your password after your first login
3. **Keep it Secure:** Never share your password with anyone

## Reset Your Password

@component('mail::button', ['url' => route('password.reset', $resetToken) ?? route('password.request')])
Reset Your Password
@endcomponent

If you didn't create this account or have any questions, please contact our support team.

@endcomponent