<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-transparent border border-gray-300 dark:border-white/10 rounded-full font-bold text-sm text-[#374151] dark:text-gray-300 uppercase tracking-wider hover:bg-gray-50 dark:hover:bg-white/5 hover:scale-[1.03] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-mtm-red focus:ring-offset-2 dark:focus:ring-offset-black transition-all duration-300 disabled:opacity-25 cursor-pointer']) }}>
    {{ $slot }}
</button>
