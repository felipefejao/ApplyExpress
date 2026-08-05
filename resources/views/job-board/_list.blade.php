@php use Illuminate\Support\Facades\Crypt; @endphp
@forelse($vagas as $vaga)
    <div
        class="group relative bg-white dark:bg-zinc-900 border border-black/5 dark:border-white/5 rounded-[28px] p-6 md:p-8 hover:shadow-2xl hover:shadow-orange-500/5 transition-all duration-300 hover:-translate-y-1 flex flex-col md:flex-row gap-6 md:items-center">

        {{-- Logo / Icon --}}
        <div
            class="w-20 h-20 shrink-0 rounded-2xl bg-gray-50 dark:bg-zinc-800 border border-black/5 dark:border-white/5 flex items-center justify-center text-3xl font-bold text-orange-500/20 group-hover:text-orange-500 transition-colors">
            {{ substr($vaga->empresa, 0, 1) }}
        </div>

        <div class="flex-grow">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-1">{{ $vaga->empresa }}</h3>
                    <h2 class="text-xl md:text-2xl font-bold tracking-tight mb-2 group-hover:text-orange-500 transition-colors">
                        {{ $vaga->cargo }}
                    </h2>

                    <div
                        class="flex flex-wrap items-center gap-y-2 gap-x-6 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="flex items-center gap-1.5">
                                        <i data-lucide="globe" class="w-4 h-4 opacity-50"></i>
                                        {{ $vaga->relocation ? 'Remoto / ' . $vaga->relocation_city : 'Remoto' }}
                                    </span>

                        <span class="flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-4 h-4 opacity-50"></i>
                                        {{ $vaga->created_at->diffForHumans() }}
                                    </span>

                        @if(isset($vaga->email))
                            <span class="flex items-center gap-1.5">
                                            <i data-lucide="mail" class="w-4 h-4 opacity-50"></i>
                                            {{ $vaga->email }}
                                        </span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 md:justify-end">
                    @php
                        $tags = explode(',', $vaga->language ?? 'PHP,Laravel');
                    @endphp
                    @foreach($tags as $tag)
                        <span
                            class="px-3 py-1 rounded-full bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 text-xs font-bold uppercase tracking-wider border border-orange-100 dark:border-orange-500/20">
                                        {{ trim($tag) }}
                                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Botão invisível que cobre o card --}}
        <a href="{{ route('job-board.details', Crypt::encrypt($vaga->id)) }}" class="absolute inset-0 z-10"
           aria-label="Ver detalhes da vaga"></a>
    </div>
@empty
    <div
        class="text-center py-20 bg-white dark:bg-zinc-900 rounded-[28px] border border-dashed border-black/10 dark:border-white/10">
        <div
            class="w-20 h-20 rounded-full bg-gray-50 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-6 text-4xl">
            🔍
        </div>
        <h3 class="text-xl font-bold mb-2">Nenhuma vaga encontrada</h3>
        <p class="text-gray-500">Tente ajustar seus filtros ou volte mais tarde.</p>
    </div>
@endforelse
