@if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-300">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-300">
        {{ session('error') }}
    </div>
@endif
