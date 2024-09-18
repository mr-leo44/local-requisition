<div id="deliveries-modal" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="deliveries-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-emerald-400 w-12 h-12" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400" id="text">Etes-vous vraiment
                    sûr d'éffectuer cette livraison?
                </h3>
                <form action="" method="post" id="deliveriesForm">
                    @csrf
                    <button type="submit" id="deliver"
                        class="text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-1.5 text-center">
                        Valider
                    </button>
                    <button data-modal-hide="deliveries-modal" type="button"
                        class="py-1.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-gray-700 rounded-lg border border-gray-200 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-800">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function sendDeliveriesDetails(event) {
        event.preventDefault();
        inputsdetails = document.querySelectorAll(`input[name^="details["][name$="[id]"]`)
        let details = []
        inputsdetails.forEach(input => {
            let inputName = input.getAttribute('name')
            let indexMatch = inputName.match(/details\[(\d+)\]\[id\]/)
            let index = indexMatch ? indexMatch[1] : null
            if (index != null) {
                let qteInput = document.querySelector(`input#quantite_${index}`)
                if (qteInput) {
                    details.push({
                        id: input.value,
                        quantite: qteInput.value
                    })
                }
            }
        })
        return details
    }

    document.querySelector("#deliveriesForm").addEventListener('submit', function(event) {
        event.preventDefault()
        var details = sendDeliveriesDetails(event)
        $.ajax({
            url: `demandes/deliver`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                details: details,
            },
            success: function(response) {
                const smallModal = new Modal(document.getElementById('deliveries-modal'))
                smallModal.hide()
                document.querySelector("body > div[modal-backdrop]")?.remove()
                location.reload()
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX : ' + error);
            }
        })
    })
</script>
