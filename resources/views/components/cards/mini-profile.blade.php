@props(['avatar', 'name', 'is_creator' => false, 'you' => false, 'limit' => 14])
<div class="flex items-center mb-3">
    <div class="w-8 h-8 bg-cover bg-center rounded-full" style="background-image: url('{{ $avatar }}')"></div>
    <p class="ml-2 text-white text-sm">{{ Str::limit($name, $limit, '...') }} </p>
    @if ($is_creator)
        <span class="ml-2 border-main-2 bg-main-2/10 text-main-2 border px-2 rounded-lg text-[10px]">Creator</span>
    @endif
    @if ($you)
        <span class="ml-2 border-main bg-main-2/10 text-main border px-2 rounded-lg text-[10px]">You</span>
    @endif
</div>