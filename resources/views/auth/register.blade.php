<x-layout>
<x-forms.auth-card action="/register" title="Register" submit="Create Account">
    <x-forms.auth-field name="name" label="Name" />
    <x-forms.auth-field name="email" label="Email" type="email" />
    <x-forms.auth-field name="password" label="Password" type="password" />
    <x-forms.auth-field name="password_confirmation" label="Password Confirmation" type="password" />
</x-forms.auth-card>
</x-layout>