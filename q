[1mdiff --git a/app/Http/Controllers/ProfileController.php b/app/Http/Controllers/ProfileController.php[m
[1mindex a48eb8d..74c1ad4 100644[m
[1m--- a/app/Http/Controllers/ProfileController.php[m
[1m+++ b/app/Http/Controllers/ProfileController.php[m
[36m@@ -7,15 +7,12 @@[m
 use Illuminate\Http\Request;[m
 use Illuminate\Support\Facades\Auth;[m
 use Illuminate\Support\Facades\Redirect;[m
[31m-use Illuminate\View\View;[m
 [m
[31m-class ProfileController extends Controller[m
[31m-{[m
[32m+[m[32mclass ProfileController extends Controller {[m
     /**[m
      * Display the user's profile form.[m
      */[m
[31m-    public function edit(Request $request): View[m
[31m-    {[m
[32m+[m[32m    public function edit(Request $request) {[m
         return view('profile.edit', [[m
             'user' => $request->user(),[m
         ]);[m
[36m@@ -24,8 +21,7 @@[m [mpublic function edit(Request $request): View[m
     /**[m
      * Update the user's profile information.[m
      */[m
[31m-    public function update(ProfileUpdateRequest $request): RedirectResponse[m
[31m-    {[m
[32m+[m[32m    public function update(ProfileUpdateRequest $request): RedirectResponse {[m
         $request->user()->fill($request->validated());[m
 [m
         if ($request->user()->isDirty('email')) {[m
[36m@@ -40,8 +36,7 @@[m [mpublic function update(ProfileUpdateRequest $request): RedirectResponse[m
     /**[m
      * Delete the user's account.[m
      */[m
[31m-    public function destroy(Request $request): RedirectResponse[m
[31m-    {[m
[32m+[m[32m    public function destroy(Request $request): RedirectResponse {[m
         $request->validateWithBag('userDeletion', [[m
             'password' => ['required', 'current_password'],[m
         ]);[m
[1mdiff --git a/resources/views/layouts/app.blade.php b/resources/views/layouts/app.blade.php[m
[1mindex a1dde41..9df17ee 100644[m
[1m--- a/resources/views/layouts/app.blade.php[m
[1m+++ b/resources/views/layouts/app.blade.php[m
[36m@@ -255,7 +255,7 @@[m [mclass="menu-link"[m
                                         </a>[m
                                         <ul class="dropdown-menu dropdown-menu-end">[m
                                             <li>[m
[31m-                                                <a class="dropdown-item" href="pages-account-settings-account.html">[m
[32m+[m[32m                                                <a class="dropdown-item" href="profile">[m
                                                     <div class="d-flex">[m
                                                         <div class="flex-shrink-0 me-3">[m
                                                             <div class="avatar avatar-online">[m
[1mdiff --git a/resources/views/profile/edit.blade.php b/resources/views/profile/edit.blade.php[m
[1mindex e0e1d38..d33470d 100644[m
[1m--- a/resources/views/profile/edit.blade.php[m
[1m+++ b/resources/views/profile/edit.blade.php[m
[36m@@ -1,10 +1,6 @@[m
[31m-<x-app-layout>[m
[31m-    <x-slot name="header">[m
[31m-        <h2 class="font-semibold text-xl text-gray-800 leading-tight">[m
[31m-            {{ __('Profile') }}[m
[31m-        </h2>[m
[31m-    </x-slot>[m
[32m+[m[32m@extends('layouts.app')[m
 [m
[32m+[m[32m@section('content')[m
     <div class="py-12">[m
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">[m
             <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">[m
[36m@@ -26,4 +22,4 @@[m
             </div>[m
         </div>[m
     </div>[m
[31m-</x-app-layout>[m
[32m+[m[32m@endsection[m
[1mdiff --git a/resources/views/profile/partials/delete-user-form.blade.php b/resources/views/profile/partials/delete-user-form.blade.php[m
[1mindex edeeb4a..62c6a48 100644[m
[1m--- a/resources/views/profile/partials/delete-user-form.blade.php[m
[1m+++ b/resources/views/profile/partials/delete-user-form.blade.php[m
[36m@@ -1,55 +1,63 @@[m
[31m-<section class="space-y-6">[m
[31m-    <header>[m
[31m-        <h2 class="text-lg font-medium text-gray-900">[m
[31m-            {{ __('Delete Account') }}[m
[31m-        </h2>[m
[31m-[m
[31m-        <p class="mt-1 text-sm text-gray-600">[m
[31m-            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}[m
[31m-        </p>[m
[31m-    </header>[m
[31m-[m
[31m-    <x-danger-button[m
[31m-        x-data=""[m
[31m-        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"[m
[31m-    >{{ __('Delete Account') }}</x-danger-button>[m
 [m
[32m+[m[32m<section class="">[m
[32m+[m[32m    <div class="card border-0 shadow-sm">[m
[32m+[m[32m        <div class="card-header py-2 bg-danger text-white">[m
[32m+[m[32m            <h2 class="h6 mb-0 text-white">Eliminar cuenta</h2>[m
[32m+[m[32m        </div>[m
[32m+[m
[32m+[m[32m        <div class="card-body p-3">[m
[32m+[m[32m            <p class="text-muted small mb-3">[m
[32m+[m[32m                Una vez que elimines tu cuenta, todos tus recursos y datos serán eliminados de forma permanente.[m
[32m+[m[32m                Descarga cualquier información que desees conservar antes de continuar.[m
[32m+[m[32m            </p>[m
[32m+[m
[32m+[m[32m            <button[m
[32m+[m[32m                type="button"[m
[32m+[m[32m                class="btn btn-danger btn-sm"[m
[32m+[m[32m                x-data=""[m
[32m+[m[32m                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"[m
[32m+[m[32m            >[m
[32m+[m[32m                Eliminar cuenta[m
[32m+[m[32m            </button>[m
[32m+[m[32m        </div>[m
[32m+[m[32m    </div>[m
[32m+[m
[32m+[m[32m    {{-- Modal de confirmación --}}[m
     <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>[m
[31m-        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">[m
[32m+[m[32m        <form method="post" action="{{ route('profile.destroy') }}" class="p-3">[m
             @csrf[m
             @method('delete')[m
 [m
[31m-            <h2 class="text-lg font-medium text-gray-900">[m
[31m-                {{ __('Are you sure you want to delete your account?') }}[m
[31m-            </h2>[m
[32m+[m[32m            <h2 class="h6 text-danger mb-2">¿Estás seguro de que deseas eliminar tu cuenta?</h2>[m
 [m
[31m-            <p class="mt-1 text-sm text-gray-600">[m
[31m-                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}[m
[32m+[m[32m            <p class="text-muted small mb-3">[m
[32m+[m[32m                Una vez eliminada, todos tus datos serán borrados de forma permanente.[m
[32m+[m[32m                Ingresa tu contraseña para confirmar.[m
             </p>[m
 [m
[31m-            <div class="mt-6">[m
[31m-                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />[m
[31m-[m
[31m-                <x-text-input[m
[32m+[m[32m            <div class="mb-2">[m
[32m+[m[32m                <label for="password" class="form-label small mb-1">Contraseña</label>[m
[32m+[m[32m                <input[m
[32m+[m[32m                    type="password"[m
                     id="password"[m
                     name="password"[m
[31m-                    type="password"[m
[31m-                    class="mt-1 block w-3/4"[m
[31m-                    placeholder="{{ __('Password') }}"[m
[31m-                />[m
[31m-[m
[31m-                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />[m
[32m+[m[32m                    class="form-control form-control-sm @error('password', 'userDeletion') is-invalid @enderror"[m
[32m+[m[32m                    placeholder="Contraseña"[m
[32m+[m[32m                >[m
[32m+[m[32m                @error('password', 'userDeletion')[m
[32m+[m[32m                    <div class="invalid-feedback small">{{ $message }}</div>[m
[32m+[m[32m                @enderror[m
             </div>[m
 [m
[31m-            <div class="mt-6 flex justify-end">[m
[31m-                <x-secondary-button x-on:click="$dispatch('close')">[m
[31m-                    {{ __('Cancel') }}[m
[31m-                </x-secondary-button>[m
[31m-[m
[31m-                <x-danger-button class="ms-3">[m
[31m-                    {{ __('Delete Account') }}[m
[31m-                </x-danger-button>[m
[32m+[m[32m            <div class="d-flex justify-content-end gap-2 mt-3">[m
[32m+[m[32m                <button type="button" class="btn btn-secondary btn-sm" x-on:click="$dispatch('close')">[m
[32m+[m[32m                    Cancelar[m
[32m+[m[32m                </button>[m
[32m+[m[32m                <button type="submit" class="btn btn-danger btn-sm">[m
[32m+[m[32m                    Eliminar cuenta[m
[32m+[m[32m                </button>[m
             </div>[m
         </form>[m
     </x-modal>[m
 </section>[m
[41m+[m
[1mdiff --git a/resources/views/profile/partials/update-password-form.blade.php b/resources/views/profile/partials/update-password-form.blade.php[m
[1mindex eaca1ac..8a5ad9c 100644[m
[1m--- a/resources/views/profile/partials/update-password-form.blade.php[m
[1m+++ b/resources/views/profile/partials/update-password-form.blade.php[m
[36m@@ -1,48 +1,80 @@[m
[31m-<section>[m
[31m-    <header>[m
[31m-        <h2 class="text-lg font-medium text-gray-900">[m
[31m-            {{ __('Update Password') }}[m
[31m-        </h2>[m
[31m-[m
[31m-        <p class="mt-1 text-sm text-gray-600">[m
[31m-            {{ __('Ensure your account is using a long, random password to stay secure.') }}[m
[31m-        </p>[m
[31m-    </header>[m
[31m-[m
[31m-    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">[m
[31m-        @csrf[m
[31m-        @method('put')[m
[31m-[m
[31m-        <div>[m
[31m-            <x-input-label for="update_password_current_password" :value="__('Current Password')" />[m
[31m-            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />[m
[31m-            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />[m
[31m-        </div>[m
 [m
[31m-        <div>[m
[31m-            <x-input-label for="update_password_password" :value="__('New Password')" />[m
[31m-            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />[m
[31m-            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />[m
[32m+[m[32m<section class="">[m
[32m+[m[32m    <div class="card border-0 shadow-sm">[m
[32m+[m[32m        <div class="card-header py-2 bg-primary text-white">[m
[32m+[m[32m            <h2 class="h6 mb-0 text-white">Actualizar Contraseña</h2>[m
         </div>[m
 [m
[31m-        <div>[m
[31m-            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />[m
[31m-            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />[m
[31m-            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />[m
[31m-        </div>[m
[32m+[m[32m        <div class="card-body p-3">[m
[32m+[m[32m            <p class="text-muted small mb-3">[m
[32m+[m[32m                Asegúrate de usar una contraseña larga y aleatoria para mantener tu cuenta segura.[m
[32m+[m[32m            </p>[m
[32m+[m
[32m+[m[32m            <form method="post" action="{{ route('password.update') }}">[m
[32m+[m[32m                @csrf[m
[32m+[m[32m                @method('put')[m
[32m+[m
[32m+[m[32m                <div class="mb-2">[m
[32m+[m[32m                    <label for="update_password_current_password" class="form-label small mb-1">Contraseña actual</label>[m
[32m+[m[32m                    <input[m
[32m+[m[32m                        type="password"[m
[32m+[m[32m                        id="update_password_current_password"[m
[32m+[m[32m                        name="current_password"[m
[32m+[m[32m                        class="form-control form-control-sm @error('current_password', 'updatePassword') is-invalid @enderror"[m
[32m+[m[32m                        autocomplete="current-password"[m
[32m+[m[32m                    >[m
[32m+[m[32m                    @error('current_password', 'updatePassword')[m
[32m+[m[32m                        <div class="invalid-feedback small">{{ $message }}</div>[m
[32m+[m[32m                    @enderror[m
[32m+[m[32m                </div>[m
 [m
[31m-        <div class="flex items-center gap-4">[m
[31m-            <x-primary-button>{{ __('Save') }}</x-primary-button>[m
[31m-[m
[31m-            @if (session('status') === 'password-updated')[m
[31m-                <p[m
[31m-                    x-data="{ show: true }"[m
[31m-                    x-show="show"[m
[31m-                    x-transition[m
[31m-                    x-init="setTimeout(() => show = false, 2000)"[m
[31m-                    class="text-sm text-gray-600"[m
[31m-                >{{ __('Saved.') }}</p>[m
[31m-            @endif[m
[32m+[m[32m                <div class="mb-2">[m
[32m+[m[32m                    <label for="update_password_password" class="form-label small mb-1">Nueva contraseña</label>[m
[32m+[m[32m                    <input[m
[32m+[m[32m                        type="password"[m
[32m+[m[32m                        id="update_password_password"[m
[32m+[m[32m                        name="password"[m
[32m+[m[32m                        class="form-control form-control-sm @error('password', 'updatePassword') is-invalid @enderror"[m
[32m+[m[32m                        autocomplete="new-password"[m
[32m+[m[32m                    >[m
[32m+[m[32m                    @error('password', 'updatePassword')[m
[32m+[m[32m                        <div class="invalid-feedback small">{{ $message }}</div>[m
[32m+[m[32m                    @enderror[m
[32m+[m[32m                </div>[m
[32m+[m
[32m+[m[32m                <div class="mb-2">[m
[32m+[m[32m                    <label for="update_password_password_confirmation" class="form-label small mb-1">Confirmar contraseña</label>[m
[32m+[m[32m                    <input[m
[32m+[m[32m                        type="password"[m
[32m+[m[32m                        id="update_password_password_confirmation"[m
[32m+[m[32m                        name="password_confirmation"[m
[32m+[m[32m                        class="form-control form-control-sm @error('password_confirmation', 'updatePassword') is-invalid @enderror"[m
[32m+[m[32m                        autocomplete="new-password"[m
[32m+[m[32m                    >[m
[32m+[m[32m                    @error('password_confirmation', 'updatePassword')[m
[32m+[m[32m                        <div class="invalid-feedback small">{{ $message }}</div>[m
[32m+[m[32m                    @enderror[m
[32m+[m[32m                </div>[m
[32m+[m
[32m+[m[32m                <div class="d-flex align-items-center gap-2 mt-3">[m
[32m+[m[32m                    <button type="submit" class="btn btn-success btn-sm">[m
[32m+[m[32m                        Actualizar contraseña[m
[32m+[m[32m                    </button>[m
[32m+[m
[32m+[m[32m                    @if (session('status') === 'password-updated')[m
[32m+[m[32m                        <span[m
[32m+[m[32m                            x-data="{ show: true }"[m
[32m+[m[32m                            x-show="show"[m
[32m+[m[32m                            x-transition[m
[32m+[m[32m                            x-init="setTimeout(() => show = false, 2000)"[m
[32m+[m[32m                            class="text-success small fw-semibold"[m
[32m+[m[32m                        >[m
[32m+[m[32m                            Contraseña actualizada[m
[32m+[m[32m                        </span>[m
[32m+[m[32m                    @endif[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </form>[m
         </div>[m
[31m-    </form>[m
[32m+[m[32m    </div>[m
 </section>[m
[41m+[m
[1mdiff --git a/resources/views/profile/partials/update-profile-information-form.blade.php b/resources/views/profile/partials/update-profile-information-form.blade.php[m
[1mindex 5ae3d35..04db22f 100644[m
[1m--- a/resources/views/profile/partials/update-profile-information-form.blade.php[m
[1m+++ b/resources/views/profile/partials/update-profile-information-form.blade.php[m
[36m@@ -1,64 +1,95 @@[m
[31m-<section>[m
[31m-    <header>[m
[31m-        <h2 class="text-lg font-medium text-gray-900">[m
[31m-            {{ __('Profile Information') }}[m
[31m-        </h2>[m
[31m-[m
[31m-        <p class="mt-1 text-sm text-gray-600">[m
[31m-            {{ __("Update your account's profile information and email address.") }}[m
[31m-        </p>[m
[31m-    </header>[m
[32m+[m[32m<section class="">[m
[32m+[m[32m    <div class="card border-0 shadow-sm">[m
[32m+[m[32m        <div class="card-header py-2 bg-primary text-white">[m
[32m+[m[32m            <h2 class="h6 mb-0 text-white">Información de Perfil</h2>[m
[32m+[m[32m        </div>[m
 [m
[31m-    <form id="send-verification" method="post" action="{{ route('verification.send') }}">[m
[31m-        @csrf[m
[31m-    </form>[m
[32m+[m[32m        <div class="card-body p-3">[m
[32m+[m[32m            <p class="text-muted small mb-3">[m
[32m+[m[32m                Actualiza la información de tu cuenta y tu correo electrónico.[m
[32m+[m[32m            </p>[m
 [m
[31m-    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">[m
[31m-        @csrf[m
[31m-        @method('patch')[m
[32m+[m[32m            {{-- Formulario para reenviar verificación --}}[m
[32m+[m[32m            <form id="send-verification" method="post" action="{{ route('verification.send') }}">[m
[32m+[m[32m                @csrf[m
[32m+[m[32m            </form>[m
 [m
[31m-        <div>[m
[31m-            <x-input-label for="name" :value="__('Name')" />[m
[31m-            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />[m
[31m-            <x-input-error class="mt-2" :messages="$errors->get('name')" />[m
[31m-        </div>[m
[32m+[m[32m            {{-- Formulario de actualización --}}[m
[32m+[m[32m            <form method="post" action="{{ route('profile.update') }}">[m
[32m+[m[32m                @csrf[m
[32m+[m[32m                @method('patch')[m
 [m
[31m-        <div>[m
[31m-            <x-input-label for="email" :value="__('Email')" />[m
[31m-            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />[m
[31m-            <x-input-error class="mt-2" :messages="$errors->get('email')" />[m
[32m+[m[32m                <div class="mb-2">[m
[32m+[m[32m                    <label for="name" class="form-label small mb-1">Nombre</label>[m
[32m+[m[32m                    <input[m
[32m+[m[32m                        type="text"[m
[32m+[m[32m                        id="name"[m
[32m+[m[32m                        name="name"[m
[32m+[m[32m                        class="form-control form-control-sm @error('name') is-invalid @enderror"[m
[32m+[m[32m                        value="{{ old('name', $user->name) }}"[m
[32m+[m[32m                        required[m
[32m+[m[32m                        autofocus[m
[32m+[m[32m                        autocomplete="name"[m
[32m+[m[32m                    >[m
[32m+[m[32m                    @error('name')[m
[32m+[m[32m                        <div class="invalid-feedback small">{{ $message }}</div>[m
[32m+[m[32m                    @enderror[m
[32m+[m[32m                </div>[m
 [m
[31m-            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())[m
[31m-                <div>[m
[31m-                    <p class="text-sm mt-2 text-gray-800">[m
[31m-                        {{ __('Your email address is unverified.') }}[m
[32m+[m[32m                <div class="mb-2">[m
[32m+[m[32m                    <label for="email" class="form-label small mb-1">Correo electrónico</label>[m
[32m+[m[32m                    <input[m
[32m+[m[32m                        type="email"[m
[32m+[m[32m                        id="email"[m
[32m+[m[32m                        name="email"[m
[32m+[m[32m                        class="form-control form-control-sm @error('email') is-invalid @enderror"[m
[32m+[m[32m                        value="{{ old('email', $user->email) }}"[m
[32m+[m[32m                        required[m
[32m+[m[32m                        autocomplete="username"[m
[32m+[m[32m                    >[m
[32m+[m[32m                    @error('email')[m
[32m+[m[32m                        <div class="invalid-feedback small">{{ $message }}</div>[m
[32m+[m[32m                    @enderror[m
 [m
[31m-                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">[m
[31m-                            {{ __('Click here to re-send the verification email.') }}[m
[31m-                        </button>[m
[31m-                    </p>[m
[32m+[m[32m                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())[m
[32m+[m[32m                        <div class="alert alert-warning py-1 px-2 mt-2 small mb-1">[m
[32m+[m[32m                            Tu correo electrónico no está verificado.[m
[32m+[m[32m                            <button[m
[32m+[m[32m                                type="submit"[m
[32m+[m[32m                                form="send-verification"[m
[32m+[m[32m                                class="btn btn-link btn-sm p-0 align-baseline"[m
[32m+[m[32m                            >[m
[32m+[m[32m                                Reenviar verificación[m
[32m+[m[32m                            </button>[m
[32m+[m[32m                        </div>[m
 [m
[31m-                    @if (session('status') === 'verification-link-sent')[m
[31m-                        <p class="mt-2 font-medium text-sm text-green-600">[m
[31m-                            {{ __('A new verification link has been sent to your email address.') }}[m
[31m-                        </p>[m
[32m+[m[32m                        @if (session('status') === 'verification-link-sent')[m
[32m+[m[32m                            <div class="alert alert-success py-1 px-2 small mt-1 mb-1">[m
[32m+[m[32m                                Se envió un nuevo enlace de verificación.[m
[32m+[m[32m                            </div>[m
[32m+[m[32m                        @endif[m
                     @endif[m
                 </div>[m
[31m-            @endif[m
[31m-        </div>[m
 [m
[31m-        <div class="flex items-center gap-4">[m
[31m-            <x-primary-button>{{ __('Save') }}</x-primary-button>[m
[32m+[m[32m                <div class="d-flex align-items-center gap-2 mt-3">[m
[32m+[m[32m                    <button type="submit" class="btn btn-success btn-sm">[m
[32m+[m[32m                        Guardar[m
[32m+[m[32m                    </button>[m
 [m
[31m-            @if (session('status') === 'profile-updated')[m
[31m-                <p[m
[31m-                    x-data="{ show: true }"[m
[31m-                    x-show="show"[m
[31m-                    x-transition[m
[31m-                    x-init="setTimeout(() => show = false, 2000)"[m
[31m-                    class="text-sm text-gray-600"[m
[31m-                >{{ __('Saved.') }}</p>[m
[31m-            @endif[m
[32m+[m[32m                    @if (session('status') === 'profile-updated')[m
[32m+[m[32m                        <span[m
[32m+[m[32m                            x-data="{ show: true }"[m
[32m+[m[32m                            x-show="show"[m
[32m+[m[32m                            x-transition[m
[32m+[m[32m                            x-init="setTimeout(() => show = false, 2000)"[m
[32m+[m[32m                            class="text-success small fw-semibold"[m
[32m+[m[32m                        >[m
[32m+[m[32m                            Cambios guardados[m
[32m+[m[32m                        </span>[m
[32m+[m[32m                    @endif[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </form>[m
         </div>[m
[31m-    </form>[m
[32m+[m[32m    </div>[m
 </section>[m
[41m+[m
[1mdiff --git a/routes/web.php b/routes/web.php[m
[1mindex 5ecd75b..e364a6e 100644[m
[1m--- a/routes/web.php[m
[1m+++ b/routes/web.php[m
[36m@@ -1,31 +1,31 @@[m
 <?php[m
 [m
[31m-use App\Http\Controllers\MunicipioController;[m
[31m-use App\Http\Controllers\ProfileController;[m
[31m-use App\Models\Municipio;[m
[31m-use Illuminate\Support\Facades\Route;[m
[31m-use App\Http\Controllers\UserController;[m
[31m-use App\Http\Controllers\RoleController;[m
[31m-use App\Http\Controllers\PermissionController;[m
[31m-use App\Http\Controllers\InstitutionController;[m
[31m-use App\Http\Controllers\EducationalOfferController;[m
[31m-use App\Http\Controllers\PAMController;[m
[31m-use App\Http\Controllers\PAMGeneralController;[m
[31m-use App\Http\Controllers\PMI\PMIController;[m
[31m-use App\Http\Controllers\SedeController;[m
 use App\Http\Controllers\AjustesController;[m
 use App\Http\Controllers\ComponenteController;[m
[32m+[m[32muse App\Http\Controllers\EducationalOfferController;[m
[32m+[m[32muse App\Http\Controllers\InstitutionController;[m
 use App\Http\Controllers\ModeloEducacionalController;[m
 use App\Http\Controllers\ModeloPedagogicoController;[m
[31m-use App\Http\Controllers\UnidadMetaController;[m
[31m-use App\Http\Controllers\PMI\PMIObjetivoController;[m
[31m-use App\Http\Controllers\RedesAprendizajeController;[m
[32m+[m[32muse App\Http\Controllers\MunicipioController;[m
[32m+[m[32muse App\Http\Controllers\PAMController;[m
[32m+[m[32muse App\Http\Controllers\PAMGeneralController;[m
[32m+[m[32muse App\Http\Controllers\PermissionController;[m
 use App\Http\Controllers\PMI\IndicadoresController;[m
[32m+[m[32muse App\Http\Controllers\PMI\PMIController;[m
[32m+[m[32muse App\Http\Controllers\PMI\PMIObjetivoController;[m
[32m+[m[32muse App\Http\Controllers\ProfileController;[m
 use App\Http\Controllers\ProyectoTransversalActividadesController;[m
 use App\Http\Controllers\ProyectoTransversalController;[m
 use App\Http\Controllers\ProyectoTransversalIntegrantesController;[m
 use App\Http\Controllers\RedesActividadesController;[m
[32m+[m[32muse App\Http\Controllers\RedesAprendizajeController;[m
 use App\Http\Controllers\RedesIntegrantesController;[m
[32m+[m[32muse App\Http\Controllers\RoleController;[m
[32m+[m[32muse App\Http\Controllers\SedeController;[m
[32m+[m[32muse App\Http\Controllers\UnidadMetaController;[m
[32m+[m[32muse App\Http\Controllers\UserController;[m
[32m+[m[32muse App\Models\Municipio;[m
[32m+[m[32muse Illuminate\Support\Facades\Route;[m
 [m
 /*[m
 |--------------------------------------------------------------------------[m
[36m@@ -202,7 +202,6 @@[m
     Route::resource('indicadores-pmi',IndicadoresController::class);[m
     // Gestion de proyectos transversales[m
     Route::resource('/{institucionId}/proyectos-transversales', ProyectoTransversalController::class);[m
[31m-[m
 });[m
 [m
 require __DIR__.'/auth.php';[m
