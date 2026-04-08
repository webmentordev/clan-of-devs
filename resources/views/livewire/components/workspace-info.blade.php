<nav class="flex flex-col p-6 h-full border-x border-dark-light-100 bg-dark w-120">
    <div class="" x-data="{ open: false }">
        <div class="flex flex-col">
            <h1 class="text-xl text-txt-2 font-semibold mb-3">About workspace</h1>
            <h2 class="text-2xl text-main font-semibold mb-3 border-t border-light pt-3">{{ $data->title }}</h2>
            <img src="{{ config('app.url').'/storage/'. $data->logo }}" class="w-[56%] m-auto">
            <p class="text-txt-2 text-sm mb-3">{{ $data->description }}</p>
            <div class="flex items-center gap-1.5 py-2.5 border-y border-white/6 w-full">
                <img src="https://api.iconify.design/material-symbols:lists-rounded.svg?color=%23bdbdbd" class="w-3.5 h-3.5">
                <div class="text-txt-2 text-xs flex items-center justify-between w-full"><span>Category:</span><strong>{{ $data->category->title }}</strong></div>
            </div>
            <div class="flex items-center gap-1.5 py-2.5 border-y border-white/6 w-full">
                <img src="https://api.iconify.design/lucide:users.svg?color=%23bdbdbd" class="w-3.5 h-3.5">
                @php $members = $data->members_count; @endphp
                <div class="text-txt-2 text-xs flex items-center justify-between w-full"><span>Members:</span><strong>{{ $members }}</strong></div>
            </div>
            <div class="flex items-center gap-1.5 py-2.5 border-y border-white/6 w-full">
                <img src="https://api.iconify.design/fluent:channel-24-regular.svg?color=%23bdbdbd" class="w-3.5 h-3.5">
                <div class="text-txt-2 text-xs flex items-center justify-between w-full"><span>Channels:</span><strong>{{ $data->public_channels_count }}</strong></div>
            </div>
            <h1 class="text-xl text-txt-2 font-semibold my-3">Members</h1>
            @foreach ($data->first_members as $member)
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-cover bg-center rounded-full" style="background-image: url('{{ $member->user->get_avatar() }}')"></div>
                    <p class="ml-2 text-white text-sm">{{ $member->user->name }}</p>
                </div>
            @endforeach
        </div>
    </div>
</nav>