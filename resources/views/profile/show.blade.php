@if (config('app.debug') == false && ((Auth::user()->updated_at->addSeconds(1)->second - Auth::user()->created_at->second) <= 25 && (Auth::user()->updated_at->addMinutes(1)->minute  - Auth::user()->created_at->minute) < 2) )
    <x-app-layout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>
            </div>
        </div>
    </x-app-layout>
@elseif (config('app.debug') == false && Auth::user()->two_factor_confirmed_at == null)
    <x-app-layout>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 p-12 mt-8 overflow-hidden shadow-xl sm:rounded-lg">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            </div>
        </div>
    </x-app-layout>
@elseif(!request()->routeIs('two-factor-register') && !request()->routeIs('activate-account'))
    <x-app-layout>
        <x-slot name="header">
            <div class="shrink-0 flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </div>
        </x-slot>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')

                    <x-section-border />
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.update-password-form')
                    </div>

                    <x-section-border />
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.two-factor-authentication-form')
                    </div>

                    <x-section-border />
                @endif

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <x-section-border />

                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>
        </div>
    </x-app-layout>
@endif
