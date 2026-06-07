@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/80 dark:bg-[#121212]/50 border border-gray-200 dark:border-white/10 text-[#111827] dark:text-white focus:ring-2 focus:ring-mtm-red focus:border-mtm-red rounded-2xl shadow-sm transition-all duration-300 placeholder-gray-400 dark:placeholder-gray-500']) }}>
