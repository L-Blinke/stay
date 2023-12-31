<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @if (Auth::user()->privilege->privilege_grade == 2)

                @elseif(Auth::user()->privilege->privilege_grade == 1)
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('attendance') }}" :active="request()->routeIs('attendance')">
                            {{ __('Attendance') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('retirement') }}" :active="request()->routeIs('retirement')">
                            {{ __('Retirement') }}
                        </x-nav-link>
                    </div>
                @elseif(Auth::user()->privilege->privilege_grade == 3)
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('attendance') }}" :active="request()->routeIs('attendance')">
                            {{ __('Attendance') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('retirement') }}" :active="request()->routeIs('retirement')">
                            {{ __('Retirement') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('database') }}" :active="request()->routeIs('database')">
                            {{ __('Database') }}
                        </x-nav-link>
                    </div>
                @elseif(Auth::user()->privilege->privilege_grade == 4)
                    {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    </div> --}}
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('database') }}" :active="request()->routeIs('database')">
                            {{ __('Database') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('actions') . '/import' }}" :active="request()->routeIs('actions')">
                            {{ __('Actions') }}
                        </x-nav-link>
                    </div>
                @endif
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @if (Auth::user()->privilege->privilege_grade == 1)
                    <x-nav-link href="javascript:void(0)">
                        {{ __('Student') }}
                    </x-nav-link>
                @elseif(Auth::user()->privilege->privilege_grade == 3)
                    <x-nav-link href="javascript:void(0)">
                        {{ __('Preceptor') }}
                    </x-nav-link>
                @elseif(Auth::user()->privilege->privilege_grade == 2)
                    <x-nav-link href="javascript:void(0)">
                        {{ __('Scan station') }}
                    </x-nav-link>
                @elseif(Auth::user()->privilege->privilege_grade == 4)
                    <x-nav-link href="javascript:void(0)">
                        {{ __('Accountable') }}
                    </x-nav-link>
                @endif
                <!-- Teams Dropdown -->
                @if (Auth::user()->privilege->privilege_grade > 2)
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        @if (Auth::user()->privilege->privilege_grade != 4)
                                            {{ Auth::user()->currentTeam->name }}
                                        @else
                                            Courses
                                        @endif
                                        {{--
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg> --}}
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Courses') }}
                                    </div>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('actions') . '/import' }}">
                                            {{ __('Create New Course') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->privilege->privilege_grade > 3)
                                        @if (App\Models\Team::all()->count() > 1)
                                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Course Settings') }}
                                            </div>

                                            @foreach (App\Models\Team::all() as $team)
                                                <x-dropdown-link href="{{ route('teams.show', $team->id) }}">
                                                    {{ $team->name }}
                                                </x-dropdown-link>
                                            @endforeach
                                        @endif
                                    @else
                                        @if (Auth::user()->ownedTeams()->count() > 1)
                                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Select course') }}
                                            </div>

                                            @foreach (Auth::user()->ownedTeams()->get() as $team)
                                                <x-dropdown-link href="{{ route('update-team') . '/'. $team->id }}">
                                                    {{ $team->name }}
                                                </x-dropdown-link>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Navigation Links -->
            @if (Auth::user()->privilege->privilege_grade == 2)
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('attendance') }}" :active="request()->routeIs('attendance')">
                        {{ __('General') }}
                    </x-nav-link>
                </div>
            @elseif(Auth::user()->privilege->privilege_grade == 1)
                <x-responsive-nav-link href="{{ route('attendance') }}" :active="request()->routeIs('attendance')">
                    {{ __('Attendance') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('retirement') }}" :active="request()->routeIs('retirement')">
                    {{ __('Retirement') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->privilege->privilege_grade == 3)
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('attendance') }}" :active="request()->routeIs('attendance')">
                    {{ __('Attendance') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('retirement') }}" :active="request()->routeIs('retirement')">
                    {{ __('Retirement') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('database') }}" :active="request()->routeIs('database')">
                    {{ __('Database') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->privilege->privilege_grade == 4)
                {{--
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            --}}
                <x-responsive-nav-link href="{{ route('database') }}" :active="request()->routeIs('database')">
                    {{ __('Database') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('actions') }}" :active="request()->routeIs('actions')">
                    {{ __('Actions') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Courses') }}
                </div>

                <!-- Team Settings -->
                @if (Auth::user()->privilege->privilege_grade == 3)
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>
                @endif

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                    <x-responsive-nav-link href="{{ route('actions') . '/import' }}" :active="request()->routeIs('actions')">
                        {{ __('Create New Team') }}
                    </x-responsive-nav-link>
                @endcan

                <!-- Team Switcher -->
                @if (Auth::user()->allTeams()->count() > 1)
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                    <x-responsive-nav-link href="{{ route('update-team') . '/'. $team->id }}">
                        {{ $team->name }}
                    </x-responsive-nav-link>
                    @endforeach
                @elseif (Auth::user()->privilege->privilege_grade == 4)
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>


                    @foreach (App\Models\Team::all() as $team)
                        <x-dropdown-link href="{{ route('teams.show', $team->id) }}">
                            {{ $team->name }}
                        </x-dropdown-link>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
