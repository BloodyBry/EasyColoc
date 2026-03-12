@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-xl border-slate-200 px-4 py-3 text-sm transition duration-200 ease-in-out focus:border-brand-500 focus:ring-brand-500 focus:ring-2 focus:ring-offset-0 disabled:bg-slate-50 disabled:text-slate-500 bg-white placeholder:text-slate-400 font-sans shadow-sm']) }}>
