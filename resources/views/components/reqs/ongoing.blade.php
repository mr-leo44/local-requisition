<div class="hidden p-2 rounded-lg" id="styled-ongoing" role="tabpanel" aria-labelledby="ongoing-tab">
    <div class="flex gap-3 justify-between items-center mb-6">
        <div class="flex justify-between items-center">
            <button type="button" id="gridView"
                class="p-2.5 ms-2 ease-in-out transition-all duration-75 text-sm font-medium text-white bg-gray-400 hover:bg-gray-500 rounded-lg [&.active]:bg-gray-900 active">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                </svg>
            </button>
            <button type="button" id="listView"
                class="p-2.5 ms-2 ease-in-out transition-all duration-75 text-sm font-medium text-white bg-gray-400 hover:bg-gray-500 rounded-lg [&.active]:bg-gray-900">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5" />
                </svg>
            </button>
        </div>
        <div class="flex justify-between items-center gap-3">
            <button type="button" @if (Session::get('authUser')->compte->role->value === 'livraison') class="hidden" @endif data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                class="p-2.5 ms-2 ease-in-out transition-all duration-75 text-sm font-medium text-white bg-orange-500 rounded-lg">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
            </button>
            <div>
                <form class="flex items-center max-w-sm mx-auto">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                            </svg>
                        </div>
                        <input type="text" id="simple-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5 dark:focus:text-gray-700"
                            placeholder="Rechercher..." required />
                    </div>
                    <button type="submit" class="p-3.5 ms-2 text-sm font-medium text-white bg-orange-500 rounded-lg">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 grid-cols-1 gap-3" id="cardGridView">
        @if ($ongoings->count() > 0)
            @foreach ($ongoings as $req)
                <div
                    class="block bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="border-b dark:border-gray-600 p-4">
                        <div class="flex items-center justify-between">
                            <h5
                                class="mb-2 text-md md:text-xl xl:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $req->numero }}</h5>
                            <span
                                class="font-medium text-sm text-gray-700 dark:text-gray-400">{{ $req->created_at->locale('fr')->diffForHumans() }}</span>
                        </div>
                        <p class="font-medium text-md text-gray-700 dark:text-white">{{ $req->user->name }}</p>
                        <p class="font-medium text-md text-gray-700 dark:text-white">{{ $req->service }}</p>
                    </div>
                    <div class="flex justify-between items-center p-4">
                        <div>
                            <p class="text-gray-700 dark:text-gray-400 text-sm">{{ $req->to_deliver }}
                                @if ($req->to_deliver > 1)
                                    {{ __('Pièces') }}
                                @else
                                    {{ __('Pièce') }}
                                @endif à livrer
                            </p>
                        </div>
                        <div class="flex justify-end items-center gap-2">
                            <button data-modal-target="show-modal" data-modal-toggle="show-modal" type="button"
                                class="bg-orange-500 px-3 py-2 rounded" onclick="showModal({{ $req }})">
                                <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                            @if (session()->get('authUser')->id == $req->user_id && $req->level === 0)
                                <a onclick="supprimer(event);" data-modal-target="delete-modal"
                                    data-modal-toggle="delete-modal"
                                    class="bg-gray-600 dark:hover:bg-gray-800 px-3 py-2 rounded">
                                    <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="hidden text-gray-900 overflow-x-auto dark:text-white" id="cardListView">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs uppercase bg-slate-100 dark:bg-transparent text-black dark:text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        N°
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Numero Requisition
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Demandeur
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Service
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ville
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Pièces a livrer
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
                @if ($ongoings->count() > 0)
                    @foreach ($ongoings as $key => $req)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $key + 1 }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $req->numero }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $req->user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $req->service }}
                            </td>
                            <td class="px-6 py-4">
                                Kinshasa
                            </td>
                            <td class="px-6 py-4">
                                {{ $req->created_at->locale('fr')->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{ $req->to_deliver }}
                                @if ($req->to_deliver > 1)
                                    {{ __('Pièces') }}
                                @else
                                    {{ __('Pièce') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                <button data-modal-target="show-modal" data-modal-toggle="show-modal" type="button"
                                    class="bg-orange-500 px-3 py-2 rounded" onclick="showModal({{ $req }})">
                                    <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                                @if (session()->get('authUser')->id == $req->user_id && $req->level === 0)
                                    <a onclick="supprimer(event);" data-modal-target="delete-modal"
                                        data-modal-toggle="delete-modal"
                                        class="bg-gray-600 dark:hover:bg-gray-800 px-3 py-2 rounded">
                                        <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<x-deleteDemande />

<script>
    const listView = document.getElementById("listView");
    const gridView = document.getElementById("gridView");
    const cardGridView = document.getElementById("cardGridView");
    const cardListView = document.getElementById("cardListView");
    listView.addEventListener("click", function() {
        localStorage.setItem('viewMode', 'list')
        toggleView()
    });
    gridView.addEventListener("click", function() {
        localStorage.setItem('viewMode', 'grid')
        toggleView()
    });

    function toggleView() {
        const viewMode = localStorage.getItem('viewMode')
        if (viewMode === 'list') {
            gridView.classList.remove("active");
            cardGridView.classList.add("hidden");
            listView.classList.add("active");
            cardListView.classList.remove("hidden");
            cardListView.classList.add("active");
        } else {
            listView.classList.remove("active");
            cardListView.classList.add("hidden");
            gridView.classList.add("active");
            cardGridView.classList.remove("hidden");
            cardGridView.classList.add("active");
        }
    }
    toggleView()
</script>
