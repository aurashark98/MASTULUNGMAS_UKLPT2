<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-[#EF4444] to-[#F59E0B] border border-transparent rounded-full font-bold text-sm text-white uppercase tracking-wider hover:brightness-110 hover:scale-[1.03] hover:shadow-lg hover:shadow-red-500/25 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-mtm-red focus:ring-offset-2 dark:focus:ring-offset-black transition-all duration-300 cursor-pointer']) }}>
    {{ $slot }}
</button>
