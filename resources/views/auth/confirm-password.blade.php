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
            Il s'agit d'une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" value="Mot de passe" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    Confirmer
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
