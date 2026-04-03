<nav class="flex flex-col p-3 h-full bg-dark">
    @livewire('components.link', ['route' => 'workspaces', 'id' => '123', 'name' => 'Laravel'])
    <button class="bg-white rounded-lg group relative p-2 w-10 h-10 flex items-center justify-center mb-3">
        <img src="https://api.iconify.design/material-symbols:add-rounded.svg?color=%23000000" width="30px">
        <span class="hidden group-hover:block transition-all absolute left-12 top-0 bg-black/80 backdrop-blur-lg py-2 px-3 rounded-lg text-white text-sm whitespace-nowrap">Create a workspace</span>
    </button>
</nav>
