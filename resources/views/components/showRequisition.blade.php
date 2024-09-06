<div id="show-modal" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative max-w-5xl mx-auto p-6 w-full max-h-full">
        <div class="max-w-4xl mx-auto relative bg-white rounded-lg shadow dark:bg-gray-800">
            <button type="button" id="closeBtn"
                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="show-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5">
                <div class="my-4">
                    <h3 id="title" class="text-xl font-bold text-gray-900 dark:text-white mb-2"></h3>
                    <p id="user" class="font-medium"></p>
                    <p id="service" class="font-medium"></p>
                </div>
                <div class="my-8 rounded dark:bg-gray-700 dark:border-gray-600 p-4">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                        id="details_table">
                        <thead class="text-xs  uppercase bg-slate-100 dark:bg-transparent text-black dark:text-white">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Designation
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantité demandee
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantite livree
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900">
                        </tbody>
                    </table>
                    <div class="mt-8" id="reject-form"></div>
                    <div class="mt-8 flex justify-end items-center">
                        <div id="validation" class="flex justify-between items-center gap-2"></div>
                        <a data-modal-target="default-modal" id="deliver" data-modal-toggle="default-modal"
                            data-modal-hide="show-modal"
                            class="bg-red-600 px-3 py-2 rounded ease-in-out transition-all duration-75 dark:text-white">
                            Livrer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $role = Session::get('authUser')->compte->role->value;
@endphp

<x-show-livraison />
<script>
    function showModal(req) {
        const userRole = `{{ $role }}`
        if(userRole === 'user') {
            document.querySelector('#deliver').classList.add("hidden")
        } 

        const title = document.getElementById('title')
        title.classList.add("dark:text-white")
        title.textContent = `Demande de requisition N° ${req.numero}`
        const user = document.getElementById('user')
        user.textContent = `Demandeur : ${req.user.name}`
        user.classList.add("dark:text-white")
        const service = document.getElementById('service')
        service.textContent = `Service : ${req.service}`
        service.classList.add("dark:text-white")

        const details = req.demande_details
        document.querySelector('#details_table tbody').textContent = ""
        document.querySelector('#deliver').addEventListener('click', updateDetails(req.demande_details))

        // Générer tableau des details
        details.forEach(detail => {
            var tr = document.createElement('tr')
            tr.classList.add("border-b", "hover:bg-gray-50", "dark:hover:bg-gray-800", "dark:border-gray-700")

            var designationTh = document.createElement('th')
            designationTh.classList.add("px-6", "py-4", "font-medium", "text-gray-900", "dark:text-white")
            designationTh.textContent = detail.designation
            tr.appendChild(designationTh)

            var qte_demandeeTd = document.createElement('td')
            qte_demandeeTd.classList.add("px-6", "py-4", "text-right")
            qte_demandeeTd.textContent = detail.qte_demandee
            tr.appendChild(qte_demandeeTd)

            var qte_livreeTd = document.createElement('td')
            qte_livreeTd.classList.add("px-6", "py-4", "text-right")
            qte_livreeTd.textContent = detail.qte_livree
            tr.appendChild(qte_livreeTd)

            document.querySelector('#details_table tbody').appendChild(tr)
        });

        // Bouttons de validation
        document.getElementById('validation').textContent = ""

        if (req.status === 'en cours' && req.validator === true) {

            var acceptBtn = document.createElement('button')
            acceptBtn.setAttribute('id', 'accept')
            acceptBtn.setAttribute('data-modal-target', 'valider')
            acceptBtn.setAttribute('data-modal-toggle', 'valider')
            acceptBtn.setAttribute('type', 'button')
            acceptBtn.textContent = 'Valider'
            acceptBtn.classList.add("text-white", "bg-emerald-700", "hover:bg-emerald-800", "focus:outline-none",
                "focus:ring-4", "focus:ring-black-300", "font-medium", "rounded-md", "text-sm", "px-5", "py-2.5",
                "text-center", "me-2", "mb-2", "dark:bg-black-600", "dark:hover:bg-black-700",
                "dark:focus:ring-black-800")
            document.getElementById('validation').appendChild(acceptBtn)


            var rejecteBtn = document.createElement('button')
            rejecteBtn.setAttribute('id', 'reject')
            rejecteBtn.setAttribute('data-modal-target', 'popup-modal')
            rejecteBtn.setAttribute('data-modal-toggle', 'popup-modal')
            rejecteBtn.setAttribute('type', 'button')
            rejecteBtn.textContent = 'Rejeter'
            rejecteBtn.classList.add("text-white", "bg-red-700", "hover:bg-red-800", "focus:outline-none",
                "focus:ring-4", "focus:ring-red-300", "font-medium", "rounded-md", "text-sm", "px-5", "py-2.5",
                "text-center", "me-2", "mb-2", "dark:bg-red-600", "dark:hover:bg-red-700", "dark:focus:ring-red-800"
            )
            document.getElementById('validation').appendChild(rejecteBtn)

            //valider
            document.querySelector("#validation #accept").addEventListener('click', function() {
                $.ajax({
                    url: `/${req.id}/validate`,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        demande: req,
                        status: 'validé'
                    },
                    success: function(response) {
                        const smallModal = new Modal(document.getElementById('show-modal'))
                        smallModal.hide()
                        document.querySelector("body > div[modal-backdrop]")?.remove()
                        location.reload()
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur AJAX : ' + error);
                    }
                })
            })

            //rejeter
            document.querySelector("#validation #reject").addEventListener('click', function() {
                document.querySelector("#validation #accept").classList.add('hidden')
                document.querySelector("#validation #reject").classList.add('hidden')

                const rejectForm = document.createElement('form')
                var rejectlabel = document.createElement('label')
                rejectlabel.setAttribute('for', 'observation')
                rejectlabel.classList.add("block", "mb-2", "text-sm", "font-medium", "text-gray-900",
                    "dark:text-white")
                rejectlabel.innerHTML = `Motifs <span class="lg: text-xs italic">(facultatif)</span>`
                rejectForm.appendChild(rejectlabel)

                var rejectTextArrea = document.createElement('textarea')
                rejectTextArrea.setAttribute('id', 'observation')
                rejectTextArrea.setAttribute('name', 'observation')
                rejectTextArrea.setAttribute('rows', '5')
                rejectTextArrea.setAttribute('placeholder', 'Veuillez écrire vos motifs ici...')
                rejectTextArrea.classList.add("block", "p-2.5", "w-full", "text-sm", "resize-none",
                    "overflow-auto", "text-gray-900", "bg-gray-50", "rounded-lg", "border",
                    "border-gray-300", "focus:ring-blue-500", "focus:border-blue-500", "dark:bg-gray-700",
                    "dark:border-gray-600", "dark:placeholder-gray-400", "dark:text-white",
                    "dark:focus:ring-blue-500", "dark:focus:border-blue-500")
                rejectForm.appendChild(rejectTextArrea)

                var validateReject = document.createElement('button')
                validateReject.setAttribute('id', 'validate-reject')
                validateReject.setAttribute('type', 'submit')
                validateReject.textContent = 'Envoyer'
                validateReject.classList.add("text-white", "bg-red-700", "hover:bg-red-800",
                    "focus:outline-none", "my-4",
                    "focus:ring-4", "focus:ring-red-300", "font-medium", "rounded-md", "text-sm", "px-5",
                    "py-2.5",
                    "text-center", "me-2", "mb-2", "dark:bg-red-600", "dark:hover:bg-red-700",
                    "dark:focus:ring-red-800"
                )
                rejectForm.appendChild(validateReject)

                document.getElementById('reject-form').appendChild(rejectForm)

                $("#reject-form").show()

                document.getElementById('validate-reject').addEventListener("click", function() {
                    $.ajax({
                        url: `/${req.id}/validate`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            demande: req,
                            status: 'rejeté'
                        },
                        success: function(response) {
                            const smallModal = new Modal(document.getElementById(
                                'show-modal'))
                            smallModal.hide()
                            document.querySelector("body > div[modal-backdrop]")?.remove()
                            location.reload()
                        },
                        error: function(xhr, status, error) {
                            console.error('Erreur AJAX : ' + error);
                        }
                    })
                })

            })
        }
    }

    function updateDetails(details) {
        document.querySelector('#deliver-form tbody').textContent = ""

        var deliverDetails = []
        for (const key in details) {
            if (details[key].qte_demandee != details[key].qte_livree) {
                
                var deliverTr = document.createElement('tr')
                deliverTr.classList.add("border-b", "hover:bg-gray-50", "dark:hover:bg-gray-800",
                    "dark:border-gray-700")

                var deliverDesignationTh = document.createElement('th')
                deliverDesignationTh.classList.add("px-6", "py-4", "font-medium", "text-gray-900", "dark:text-white")
                deliverDesignationTh.textContent = details[key].designation
                deliverTr.appendChild(deliverDesignationTh)

                var deliverQte_demandeeTd = document.createElement('td')
                deliverQte_demandeeTd.classList.add("px-6", "py-4", "text-right")
                deliverQte_demandeeTd.textContent = details[key].qte_demandee
                deliverTr.appendChild(deliverQte_demandeeTd)

                var qte_livreeTd = document.createElement('td')
                qte_livreeTd.classList.add("px-6", "py-4", "text-right")
                qte_livreeTd.textContent = details[key].qte_livree
                deliverTr.appendChild(qte_livreeTd)

                var deliverInputTd = document.createElement('td')
                deliverInputTd.classList.add("px-6", "py-4")
                var deliverDiv = document.createElement('div')
                deliverDiv.classList.add("flex", "flex-col", "gap-1")
                deliverDiv.innerHTML = ` 
                     <div>
                        <input type="hidden" name="details[${key}][id]"
                            value="${details[key].id}" id="details[${key}][id]"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Ex.10" required />
                    </div>
                    <x-text-input id="quantite_${key}"
                        class="bg-gray-50 w-full border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                        type="number" name="details[${key}][quantite]"
                        max="${details[key].qte_demandee}"
                        placeholder="Ex. 12" autocomplete="quantite"
                        oninput="validateInput(${key}, ${details[key].qte_demandee}, ${details[key].qte_livree})" />


                    <div id="error_${key}" class="text-red-500 lowercase text-sm">
                        <x-input-error :messages="$errors->get('quantite')" class="mt-2" />
                    </div>
                `
                deliverInputTd.appendChild(deliverDiv)
                deliverTr.appendChild(deliverInputTd)
                document.querySelector('#deliver-form tbody').appendChild(deliverTr)
            }
        }
    }
</script>
