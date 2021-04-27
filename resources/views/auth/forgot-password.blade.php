<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="col-8">
                <a href="#" class="text-center justify-content-center m-auto">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
                <h4 class="text-center text-primary">Ecole Nationale d'Informatique</h4>
            </div>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            Saisissez dans le champ votre email
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" value="Email" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    Envoi l'email
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
