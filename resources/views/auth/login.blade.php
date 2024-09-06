<x-guest-layout>
  <div class="flex flex-col lg:flex-row h-screen dark:bg-slate-400">
      <!-- Image desktop -->
      <div class="hidden lg:block lg:w-3/5">
          <img class="object-cover w-full h-full" src="{{asset('img/requisition Req.png')}}" alt="">
      </div>

      <!-- l'image sur mobile -->
      <div class="block order-first lg:hidden w-full h-1/4 mb-8">
          <img class="object-cover w-full h-full" src="{{asset('img/requisition.svg')}}" alt="">
          <div class="flex flex-col items-center -mt-20">
              <img src="{{ asset('img/orange.png') }}" class="w-40 border-1" alt="profile">
          </div>
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
              <p class="mt-4 text-base text-gray-700">Welcome! Please sign in to your account.</p>
              <form method="POST" action="{{ route('login') }}" class="space-y-3">
                  @csrf
                  <div class="mt-10 space-y-3">
                      <div>
                          <x-input-error :messages="session('error')" class="mb-3" />
                          
                          <label for="email" class="font-bold">Email :</label>

                          <input type="email" name="email" id="email" class="border-gray-500 bg-transparent block w-full px-5 py-3 text-base text-black placeholder-gray-300 transition duration-500 ease-in-out transform rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300" placeholder="Enter your email">
                        </div>
                      <div>
                          <label for="password" class="font-bold">Password :</label>
                          <input type="password" name="password" id="password" class="border-gray-500 bg-transparent block w-full px-5 py-3 text-base text-slate-700 placeholder-gray-300 transition duration-500 ease-in-out transform rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300" placeholder="Enter your password">
                      </div>
                      <div class="flex flex-col mt-4 space-y-2">
                          <x-primary-button class="w-full flex justify-center items-center">
                              Se connecter
                          </x-primary-button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</x-guest-layout>
