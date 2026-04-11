@props(['avatar', 'name', 'is_creator'])
<div class="flex items-center mb-3">
    <div class="w-8 h-8 bg-cover bg-center rounded-full" style="background-image: url('{{ $avatar }}')"></div>
    <p class="ml-2 text-white text-sm">{{ Str::limit($name, 20, '...') }} </p>
    @if ($is_creator)
        <span class="ml-2 border-main-2 bg-main-2/10 text-main-2 border py-1 px-2 rounded-lg text-[10px]">Creator</span>
    @endif
</div>