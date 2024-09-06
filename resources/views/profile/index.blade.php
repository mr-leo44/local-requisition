<x-app-layout>
    <div class="h-full bg-white dark:bg-gray-800 p-8">
        <div class="bg-white dark:bg-gray-100 rounded-lg shadow-xl pb-8">
            <div class="w-full h-[250px] bg-gray-800 rounded-t-lg dark:rounded-t-none">
            </div>
            <div class="flex flex-col items-center -mt-20 dark:rounded-t-lg">
                <img src="{{ asset('img/orange.png') }}" class="w-40 border-4 border-white rounded-full" alt="profile">
                <div class="flex items-center space-x-2 mt-2">
                    <p class="text-3xl">{{ $user->name }}</p>
                </div>
            </div>
        </div>

        <div class="my-4 flex flex-col 2xl:flex-row space-y-3 2xl:space-y-0 2xl:space-x-4">
            <div class="w-full flex flex-col gap-3 2xl:w-1/3">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8">
                    <h4 class="text-xl text-gray-900 dark:text-white font-bold">Informations</h4>
                    <ul class="mt-2 text-gray-700 dark:text-white">
                        <li class="flex border-y dark:border-gray-600 py-2">
                            <span class="font-bold w-24">Username :</span>
                            <span class="text-gray-700 dark:text-white">{{ session()->get('authUser')->name }}</span>
                        </li>
                        <li class="flex border-b dark:border-gray-600 py-2">
                            <span class="font-bold w-24">Direction :</span>
                            <span class="text-gray-700 dark:text-white">{{ $user->compte->direction->name }}</span>
                        </li>
                        <li class="flex border-b dark:border-gray-600 py-2">
                            <span class="font-bold w-24">Service :</span>
                            <span class="text-gray-700 dark:text-white">{{ $user->compte->service }}</span>
                        </li>
                        <li class="flex border-b dark:border-gray-600 py-2">
                            <span class="font-bold w-24">Manager :</span>
                            <span class="text-gray-700 dark:text-white">
                                @if ($user->manager)
                                    @if ($user->manager === $user->name)
                                        {{ __('Moi') }}
                                    @else
                                        {{ $user->manager }}
                                    @endif
                                @else
                                @endif
                            </span>
                        </li>
                    </ul>
                    <div class="flex justify-end my-4">
                        <button data-modal-target="modal" data-modal-toggle="modal" type="button" id="user-update"
                            class="px-3 py-2 bg-orange-500 opacity-85 hover:bg-orange-500 hover:opacity-95 text-white rounded">
                            Mettre à jour mes informations
                        </button>
                    </div>
                </div>
                @if ($user->isManager)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8">
                        <h4 class="text-xl text-gray-900 dark:text-white font-bold">Collaborateurs</h4>
                        @if ($collaborateurs->count() > 0)
                            <ul>
                                @foreach ($collaborateurs as $key => $collaborateur)
                                    <li class="flex py-2">
                                        <span class="text-gray-700 dark:text-white">{{ $collaborateur->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
            </div>
            <div class="flex flex-col w-full 2xl:w-2/3">
                <div
                    class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-2xl mt-4 md:mt-4 lg:mt-0 p-8">
                    <h4 class="text-xl text-gray-900 dark:text-white font-bold">Mes Statistiques</h4>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
                        <div
                            class="px-6 py-6 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-xl">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-md text-gray-700 dark:text-white">Total des
                                    Requisitions</span>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div>
                                    <svg class="w-12 h-12 p-2.5 bg-opacity-20 rounded-full text-gray-600 dark:text-white border border-gray-600 dark:border-white"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-end">
                                        <span
                                            class="text-2xl 2xl:text-3xl font-bold dark:text-white">{{ $user->demandes->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="px-6 py-6 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-xl">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-md text-gray-700 dark:text-white">Requisitions du
                                    mois</span>
                                <span
                                    class="text-xs bg-gray-200 dark:bg-gray-500 hover:bg-gray-500 dark:hover:bg-gray-200 text-gray-500 dark:text-white hover:text-gray-200 dark:hover:text-gray-700 px-2 py-1 rounded-lg transition duration-200 cursor-default">{{ Carbon\Carbon::now()->locale('fr')->isoFormat('MMMM YYYY') }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div>
                                    <svg class="w-12 h-12 p-2.5 bg-opacity-20 rounded-full text-gray-600 dark:text-white border border-gray-600 dark:border-white"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-end">
                                        <span
                                            class="text-2xl 2xl:text-3xl font-bold dark:text-white">{{ $user->this_month_req }}</span>
                                        <div class="flex items-center ml-2 mb-1">
                                            @if ($user->last_month_req < $user->this_month_req)
                                                <svg class="w-5 h-5 text-green-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M13.0158 4.74683H9.4939C9.2314 4.74683 9.01265 4.96558 9.01265 5.22808C9.01265 5.49058 9.2314 5.70933 9.4939 5.70933H11.6595L8.85953 7.59058C8.75015 7.67808 8.59703 7.67808 8.46578 7.59058L5.57828 5.68745C5.1189 5.3812 4.55015 5.3812 4.09078 5.68745L0.722027 7.94058C0.503277 8.0937 0.437652 8.39995 0.590777 8.6187C0.678277 8.74995 0.831402 8.83745 1.0064 8.83745C1.0939 8.83745 1.20328 8.81558 1.2689 8.74995L4.65953 6.49683C4.7689 6.40933 4.92203 6.40933 5.05328 6.49683L7.94078 8.42183C8.40015 8.72808 8.9689 8.72808 9.42828 8.42183L12.5127 6.3437V8.77183C12.5127 9.03433 12.7314 9.25308 12.9939 9.25308C13.2564 9.25308 13.4752 9.03433 13.4752 8.77183V5.22808C13.5189 4.96558 13.2783 4.74683 13.0158 4.74683Z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="font-bold text-sm text-green-500 ml-1">{{ $user->this_month_req - $user->last_month_req }}</span>
                                            @elseif ($user->last_month_req > $user->this_month_req)
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.0157 4.74683C12.7532 4.74683 12.5344 4.96558 12.5344 5.22808V7.6562L9.4063 5.57808C8.94693 5.27183 8.37818 5.27183 7.9188 5.57808L5.0313 7.50308C4.92193 7.59058 4.7688 7.59058 4.63755 7.50308L1.24693 5.24995C1.02818 5.09683 0.721929 5.16245 0.568804 5.3812C0.415679 5.59995 0.481304 5.9062 0.700054 6.05933L4.09068 8.31245C4.55005 8.6187 5.1188 8.6187 5.57818 8.31245L8.46568 6.38745C8.57505 6.29995 8.72818 6.29995 8.85943 6.38745L11.6594 8.2687H9.49381C9.23131 8.2687 9.01255 8.48745 9.01255 8.74995C9.01255 9.01245 9.23131 9.2312 9.49381 9.2312H13.0157C13.2782 9.2312 13.4969 9.01245 13.4969 8.74995V5.22808C13.5188 4.96558 13.2782 4.74683 13.0157 4.74683Z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="font-bold text-sm text-gray-500 ml-1">{{ $user->this_month_req - $user->last_month_req }}</span>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="px-6 py-6 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-xl">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-md text-green-600 dark:text-green-400">Requisitions
                                    validées</span>
                                <span
                                    class="text-xs bg-gray-200 dark:bg-gray-500 hover:bg-gray-500 dark:hover:bg-gray-200 text-gray-500 dark:text-white hover:text-gray-200 dark:hover:text-gray-700 px-2 py-1 rounded-lg transition duration-200 cursor-default">{{ Carbon\Carbon::now()->locale('fr')->isoFormat('MMMM YYYY') }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div>
                                    <svg class="w-12 h-12 p-2.5 bg-opacity-20 rounded-full text-green-600 dark:text-green-400 border border-green-600 dark:border-green-400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m4 6 2 2 4-4m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-end">
                                        <span
                                            class="text-2xl 2xl:text-3xl {{ $user->validated_reqs > 0 ? 'text-green-600 dark:text-green-400' : 'text-black dark:text-white' }} font-bold">{{ $user->validated_reqs }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <canvas id="verticalBarChart"
                            style="display: block; box-sizing: border-box; height: 414px; width: 828px;"
                            class="w-full dark:text-white"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <x-user-update :user="$user" :users="$users" :directions="$directions" :services="$services" />
    </div>


    <script>
        var months = @json($months);

        var month_names = []
        var month_counts = []

        for (var i = 0; i < months.length; i++) {
            month_names.push(months[i]['name']);
            month_counts.push(months[i]['count']);
        }

        const dataVerticalBarChart = {
            labels: month_names,
            datasets: [{
                label: 'Nombre de demande',
                data: month_counts,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                hoverOffset: 25,
                borderWidth: 3
            }]
        };
        const configVerticalBarChart = {
            type: 'bar',
            data: dataVerticalBarChart,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                }
            },
        };

        var verticalBarChart = new Chart(
            document.getElementById('verticalBarChart'),
            configVerticalBarChart
        );
    </script>
</x-app-layout>
