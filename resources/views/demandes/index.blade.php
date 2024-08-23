<x-app-layout>
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded ">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class=" font-bold text-base dark:text-white">Requests</h3>
                </div>
                <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                    @if (Session::get('authUser')->compte->role->value !== 'livraison')
                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button">
                        <i class="material-icons-outlined text-orange-500 font-bold text-xl">add</i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div id="alert-3"
        class="flex items-center p-4 my-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
        role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div class="ms-3 text-sm font-medium">
            {{ session('success') }}
        </div>
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
            data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
    @endif


    <head>
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
        <!-- DataTables JS -->
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    </head>
    <div class="bg-white dark:bg-gray-900 p-4 shadow-md sm:rounded-lg">
        <div class="overflow-x-auto">
            <table id="example" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            N° Requests
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Service
                        </th>
                        <th scope="col" class="px-6 py-3">
                            User

                        </th>
                        <th scope="col" class="px-6 py-3">
                            ACTIONS
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900">
                    @foreach ($demandes as $demande)

                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $demande->numero }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $demande->service }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $demande->user->name }}
                        </td>
                        <td class="flex space-x-2">
                            <a href="{{ route('demandes.show', $demande->id) }}"
                                class="py-1 px-4">
                                <i class="material-icons-outlined text-black dark:text-white hover:text-orange-500">visibility</i>
                            </a>
                            @if (session()->get('authUser')->id == $demande->user_id && $demande->level === 0)
                            <a onclick="supprimer(event);" data-modal-target="delete-modal"
                                data-modal-toggle="delete-modal"
                                href="{{ route('demandes.destroy', $demande->id) }}">
                                <i class="material-icons-round text-base text-red-500">delete_outline</i>
                            </a>
                            @else
                            <a href="#"></a>
                            @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $demandes->links() }}
        </div>

        <x-createDemande />
        <x-deleteDemande />
    </div>
    <script>
        new DataTable('#example', {
            info: false,
            ordering: true,
            paging: true,
            pageLength: {{$demandes-> perPage()}},
            language: {
                paginate: {
                    previous: "Précédent",
                    next: "Suivant"
                }
            },
            lengthChange: false, // Désactive la sélection du nombre d'éléments par page
        });
    </script>
</x-app-layout>