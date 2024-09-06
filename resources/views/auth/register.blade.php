<x-guest-layout>
    <div class="flex flex-col lg:flex-row h-screen">
        <!-- Image desktop -->
        <div class="hidden lg:block lg:w-3/5"> <!-- Ajustement de lg:w-3/5 pour 60% de largeur -->
            <img src="{{asset('img/requisition Req.png')}}" class="object-cover w-full h-full" alt="">
        </div>
  
        <!-- l'image sur mobile -->
        <div class="block order-first lg:hidden w-full h-1/4 mb-8">
            <img class="object-cover w-full h-full" src="{{asset('img/requisition Req.png')}}" alt="">
            <div class="flex flex-col items-center -mt-20">
                <img src="{{ asset('img/orange.png') }}" class="w-40 border-1" alt="profile">
            </div>
            <!-- Nom de l'application pour mobile -->
            <div class="flex justify-center mt-1">
              <svg class="w-[32px] h-[32px] text-orange-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z"/>
              </svg>
                <h1 class="flex space-x-1text-2xl font-bold text-gray-700 mt-1">
                  Réquisition
                </h1>
            </div>
        </div>
  
        <!-- Partie Formulaire -->
        <div class="flex items-center justify-center w-full lg:w-2/5 px-6 py-3 mt-32 md:mt-16 lg:mt-0">
            <div class="w-full max-w-md">
                <div class="hidden lg:flex justify-start mb-4">
                  <svg class="w-[42px] h-[42px] text-orange-500 dark:text-orange-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16.153 19 21 12l-4.847-7H3l4.848 7L3 19h13.153Z"/>
                  </svg>
                  <h1 class=" flex space-x-2 text-2xl font-bold text-gray-700 mt-1">
                      Réquisition</h1>
                </div>
                <div class="flex justify-center">
                    <div class="hidden lg:block">
                        <img src="{{ asset('img/orange.png') }}" class="w-20 border-1" alt="profile">
                    </div>
                </div>
                <p class="mt-4 text-base text-gray-700">Please complete your profile</p>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mt-4" id="name">
                        <label for="name" class="font-bold">Votre nom :</label>
                        <input type="text" name="name" id="name" class="border-gray-500 bg-transparent block w-full px-5 py-3 text-base text-black placeholder-gray-300 transition duration-500 ease-in-out transform rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                        
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
            
                    </div>
                    <div class="mt-4 ui-widget" id="direction">
                        
                        <label for="search_direction" class="font-bold">Direction :</label>
                        <input type="text" name="direction" id="search_direction" class="border-gray-500 bg-transparent block w-full px-5 py-3 text-base text-black placeholder-gray-300 transition duration-500 ease-in-out transform rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                        
                        @if (session('error'))
                            <x-input-error :messages="session('error')" class="mt-2" />
                        @endif
                        <x-input-error :messages="$errors->get('direction')" class="mt-2" />
                    </div>
                    <div class="mt-4 ui-widget" id="service">
                        <label for="search_service" class="font-bold">Service :</label>
                        <input type="text" name="service" id="search_service" class="border-gray-500 bg-transparent block w-full px-5 py-3 text-base text-black placeholder-gray-300 transition duration-500 ease-in-out transform rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                        
                        <x-input-error :messages="$errors->get('service')" class="mt-2" />
            
                    </div>
                    <div class="mt-4 ui-widget">
                        <label for="search_manager" class="font-bold">Manager :</label>
                        <input type="text" name="manager" id="search_manager" class="border-gray-500 bg-transparent block w-full px-5 py-3 text-base text-black placeholder-gray-300 transition duration-500 ease-in-out transform rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300">
                        
                        <x-input-error :messages="$errors->get('manager')" class="mt-2" />
                    </div>
                    <div class="text-center mt-3">
                        <x-primary-button class="w-full flex justify-center items-center">
                            Valider
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var users = @json($users);
            var usersData = []
            for (var i = 0; i < users.length; i++) {
                usersData.push(users[i]['first_name'] + ' ' + users[i]['last_name']);
            }

            $("#search_manager").autocomplete({
                source: usersData,
            });

            var directions = @json($directions);
            var directionsData = []

            for (var i = 0; i < directions.length; i++) {
                directionsData.push(directions[i]['name']);
            }

            $("#search_direction").autocomplete({
                source: directionsData
            });

            var services = @json($services);
            var servicesData = []

            for (var i = 0; i < services.length; i++) {
                servicesData.push(services[i]['service']);
            }

            $("#search_service").autocomplete({
                source: servicesData
            });

            // Logique pour afficher les erreurs sous les champs respectifs
            @if ($errors->has('direction'))
                $('html, body').animate({
                    scrollTop: $("#search_direction").offset().top
                }, 1000);
            @elseif ($errors->has('manager'))
                $('html, body').animate({
                    scrollTop: $("#search_manager").offset().top
                }, 1000);
            @endif
        })
    </script>
</x-guest-layout>
