<div id="default-modal" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    @if ($errors->any())
        <div class="bg-red-500 text-white px-3 py-2 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="relative p-4 max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="default-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Effectuer une livraison</h3>

                <form action="{{ route('demandes.updateLivraison') }}" method="post" id="updateForm">
                    @csrf
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        id="deliver-form">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope ="col" class="px-6 py-3">
                                    Désignation
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantité demandée
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantité livrée
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantité à livrer
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        </tbody>
                    </table>
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button id="submitBtn" type="submit"
                            class="text-white bg-blue-700 ml-auto hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validateInput(key, max, delivered) {
        const input = document.getElementById(`quantite_${key}`);
        const error = document.getElementById(`error_${key}`);
        const submitBtn = document.getElementById('submitBtn');
        const maxAllowed = max - delivered;

        submitBtn.disabled = false
        if (parseInt(input.value) > maxAllowed) {
            error.textContent = `La valeur ne doit pas dépasser ${maxAllowed}`.toLowerCase();
            submitBtn.disabled = true
        } else {
            error.textContent = '';
        }


        const allInputs = document.querySelectorAll('input[name^="details["][name$="[quantite]"]');
        allInputs.forEach(input => {
            if (!input.value || parseInt(input.value) > maxAllowed) {
                submitBtn.disabled = true;
            }
        });
    }
</script>
