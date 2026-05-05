@props(['user'])
<div class="ml-3 text-txt-1 flex items-center">
    <div class="w-[20px] h-[20px] mb-2 mr-2 rounded-full bg-cover bg-center" style="background-image: url({{ $user->get_avatar() }})"></div>
    <span class="text-[12px]">{{ $user->name }}</span>
</div>