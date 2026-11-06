@if (session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        <span class="font-bold">✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <span class="font-bold">!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif