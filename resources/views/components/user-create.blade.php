@props(['users', 'user', 'directions', 'services'])
<div id="modal" tabindex="-1" aria-hidden="true"
    class="hidden mx-auto overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center max-w-7xl md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add User
                </h3>
                <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="max-h-auto mx-auto max-w-lg">
                    @if ($errors->any())
                        <div class="bg-red-500 text-white px-3 py-2 rounded-lg mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="w-full" action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="ui-widget" id="name">
                            <x-input-label for="search_user" :value="__('Nom')" />
                            <x-text-input id="search_user" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mt-4" id="email">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mt-4 ui-widget" id="direction">
                            <x-input-label for="search_direction" :value="__('Direction')" />
                            <x-text-input id="search_direction" class="block mt-1 w-full" type="text"
                                name="direction" :value="old('direction')" required />
                            <x-input-error :messages="$errors->get('direction')" class="mt-2" />
                        </div>
                        <div class="mt-4 ui-widget" id="service">
                            <x-input-label for="search_service" :value="__('Service')" />
                            <x-text-input id="search_service" class="block mt-1 w-full" type="text" name="service"
                                :value="old('service')" required />
                            <x-input-error :messages="$errors->get('service')" class="mt-2" />

                        </div>
                        <div class="mt-4 ui-widget">
                            <x-input-label for="search_manager" :value="__('Manager')" />
                            <x-text-input id="search_manager" class="block mt-1 w-full" type="text" name="manager"
                                :value="old('manager')" required />
                            <x-input-error :messages="$errors->get('manager')" class="mt-2" />
                        </div>
                        <div class="mt-4 w-52">
                            <x-input-label for="role" :value="__('Rôle')" />
                            <select name="role" id="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                required>
                                @foreach (App\Enums\RoleEnum::cases() as $role)
                                    <option value="{{ $role->value }}">{{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <div class="flex justify-end mt-3 mb-4">
                            <button type="submit"
                                class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        var users = @json($users);
        // console.log(users);
        
        var usersData = []
        for (var i = 0; i < users.length; i++) {
            usersData.push(users[i]->name);
        }

        $("#search_user").autocomplete({
            source: usersData,
        });
        $("#search_manager").autocomplete({
            source: usersData,
        });

        var directions = @json($directions);
        var directionsData = []

        for (var i = 0; i < directions.length; i++) {
            directionsData.push(directions[i]->name);
        }

        $("#search_direction").autocomplete({
            source: directionsData
        });

        var services = @json($services);
        var servicesData = []

        for (var i = 0; i < services.length; i++) {
            servicesData.push(services[i]->service);
        }

        $("#search_service").autocomplete({
            source: servicesData
        });
    })
</script>
