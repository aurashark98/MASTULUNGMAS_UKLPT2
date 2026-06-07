<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-700 border border-transparent rounded-full font-bold text-sm text-white uppercase tracking-wider hover:brightness-110 hover:scale-[1.03] hover:shadow-lg hover:shadow-red-500/20 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-black transition-all duration-300 cursor-pointer']) }}>
    {{ $slot }}
</button>
