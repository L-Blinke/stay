<div class="justify-center">
    @if (!$alreadylogedin)
        @if ($qrlink)
        <div class="mt-8 mb-8">
            {!! QrCode::size(168)->generate($qrlink) !!}
        </div>
        @endif
        <div>
            <x-nav-link wire:click="generate" href="javascript:void(0)">
                {{ __('Generate Retirement QR') }}
            </x-nav-link>
        </div>
    @else
        <x-nav-link href="javascript:void(0)">
            {{ __('You are not in the institution') }}
        </x-nav-link>
    @endif
</div>
