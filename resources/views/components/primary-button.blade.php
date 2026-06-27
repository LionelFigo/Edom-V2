<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-xl border border-transparent bg-[#004684] px-4 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition duration-200 hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004684] focus:ring-offset-2 active:scale-[0.98]']) }}>
    {{ $slot }}
</button>
