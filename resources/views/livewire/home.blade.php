<div class="bg-main h-screen w-full">
    <h1>Welcome to Home</h1>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
