<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile · DevDZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#08090e] text-slate-200 min-h-screen">

{{-- NAV --}}
<nav class="bg-[#0d0f17] border-b border-slate-800 h-12 flex items-center px-6 sticky top-0 z-50">
    <div class="flex items-center justify-between w-full max-w-5xl mx-auto">
        <a href="/" class="text-[15px] font-bold tracking-tight text-white">
            Dev<span class="text-blue-500">DZ</span>
        </a>
        <div class="flex items-center gap-2">
            <a href="/users/{{ auth()->id() }}" class="text-[12px] text-slate-400 hover:text-white px-3 py-1.5 rounded-md hover:bg-white/5 transition-colors">
                ← Back to profile
            </a>
        </div>
    </div>
</nav>

<div class="max-w-xl mx-auto py-10 px-4">

    <h1 class="text-[18px] font-bold text-white mb-6">Edit profile</h1>

    <form method="POST" action="/users/{{ $user->id }}" enctype="multipart/form-data"
          class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        {{-- Avatar --}}
        <div class="flex items-center gap-4">
            <div class="relative">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="Avatar"
                         class="w-16 h-16 rounded-full object-cover">
                @else
                    <x-user-avatar :user="$user" size="xl" />
                @endif
            </div>
            <div>
                <label class="text-[11px] text-slate-500 uppercase tracking-widest mb-1.5 block">Profile picture</label>
                <input type="file" name="avatar" accept="image/*"
                    class="text-[12px] text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0
                           file:bg-slate-800 file:text-slate-300 file:text-[12px] file:cursor-pointer
                           hover:file:bg-slate-700 transition-colors">
                @error('avatar')
                    <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="h-px bg-slate-800"></div>

        {{-- Name --}}
        <x-forms.auth-field name="name" label="Name" :value="old('name', $user->name)" />

        {{-- Bio --}}
        <div>
            <label class="text-[11px] text-slate-500 uppercase tracking-widest mb-1.5 block">Bio</label>
            <textarea name="bio" rows="3" placeholder="Tell the community about yourself..."
                class="w-full bg-white/4 border border-white/[0.07] rounded-lg px-3 py-2 text-[13px] text-slate-200
                       placeholder-slate-600 resize-none focus:outline-none focus:border-blue-500/50 transition-colors
                       {{ $errors->has('bio') ? 'border-rose-500/50' : '' }}"
            >{{ old('bio', $user->bio) }}</textarea>
            @error('bio')
                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- City --}}
        <x-forms.auth-field name="city" label="City" :value="old('city', $user->city)" />

        {{-- GitHub --}}
        <x-forms.auth-field name="github_url" label="GitHub URL" :value="old('github_url', $user->github_url)" />

        <div class="h-px bg-slate-800"></div>

        {{-- Password --}}
        <div>
            <p class="text-[13px] text-slate-300 font-medium mb-4">Change password <span class="text-slate-600 font-normal text-[12px]">(leave blank to keep current)</span></p>
            <div class="flex flex-col gap-4">
                <x-forms.auth-field name="current_password" label="Current password" type="password" />
                <x-forms.auth-field name="password" label="New password" type="password" />
                <x-forms.auth-field name="password_confirmation" label="Confirm new password" type="password" />
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 rounded-full bg-blue-600 hover:bg-blue-500 text-white text-[13px] font-medium transition-colors">
                Save changes
            </button>
        </div>

    </form>
</div>

</body>
</html>