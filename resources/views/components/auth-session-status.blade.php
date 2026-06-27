@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-r-lg border-l-4 border-emerald-500 bg-emerald-50 p-4 text-sm font-medium text-emerald-700']) }}>
        {{ $status }}
    </div>
@endif
