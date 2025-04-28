<div class="flex items-center justify-start gap-2">
    
    <div>
        <a href="/" class="p-0 m-0">
            {{-- <img src="{{ asset('pernalonga.jpg') }}" width="50" height="40" /> --}}
            <img src="{{ $company ? asset('storage/' . $company->logo) : '' }}" width="50" />
        </a>
    </div>
    {{--<div class="pt-1 text-2xl font-bold dark:text-white">
        <a href="/" class="p-0 m-0">
            {{ $settings->title }}
        </a>
    </div>--}}
</div>
