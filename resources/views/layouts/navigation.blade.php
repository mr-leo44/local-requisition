<nav>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <a @if (Session::get('authUser')->compte->role->value === 'user') href="{{ route('demandes.index') }}"
                    @elseif(Session::get('authUser')->compte->role->value === 'livraison')
                        href="{{ route('dashboard') }}"
                    @else
                        href="{{ route('admin.index') }}" @endif
                    class="flex ms-2 md:me-24 items-center">
                    <img src="{{ asset('img/orange.png') }}" class="h-7 me-3" alt="FlowBite Logo" />
                    <span
                        class="ms-2 self-center text-md font-semibold xl:text-xl whitespace-nowrap dark:text-white">Requisition
                        Orange</span>
                </a>
            </div>
            <div class="flex justify-between items-center gap-3">
                <div class="flex flex-col text-gray-800 dark:text-white">
                    <h3 class="font-semibold text-base">
                        {{ Session::get('authUser')->name }}</h3>
                    <span class="text-xs">{{ $profile }}</span>
                </div>
                <div>
                    <button type="button" data-dropdown-toggle="apps-dropdown"
                        class="text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">Menu</span>
                        <svg class="w-12" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M5 7h14M5 12h14M5 17h14" />
                        </svg>
                    </button>
                    <div class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:bg-gray-700 dark:divide-gray-600"
                        id="apps-dropdown">
                        <div class="p-4">
                            @profile('livraison')
                                <a href="{{ route('dashboard') }}" class="flex items-center p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                    <svg aria-hidden="true"
                                        class="mr-3 w-7 h-7 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                        fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                                    </svg>
                                    <div class="text-sm text-gray-900 dark:text-white">Tableau de bord</div>
                                </a>
                            @endprofile
                            @profile('not-admin')
                                <a href="{{ route('demandes.index') }}" class="flex items-center p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                    <svg aria-hidden="true"
                                        class="mr-3 w-7 h-7 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                        fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                                    </svg>
                                    <div class="text-sm text-gray-900 dark:text-white">Demandes</div>
                                </a>
                            @endprofile
                            <a href="{{ route('profile.index') }}" class="flex items-center p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                <svg aria-hidden="true"
                                    class="mr-3 w-7 h-7 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-gray-900 dark:text-white">Profil</div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 group">
                                    <svg aria-hidden="true"
                                        class="mr-3 w-7 h-7 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <div class="text-sm text-gray-900 dark:text-white">Deconnexion</div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
