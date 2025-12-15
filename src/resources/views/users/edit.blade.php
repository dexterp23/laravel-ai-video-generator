<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('users') }}">{{ __('Users') }}</a> /
            @if(empty($data))
                {{ __('Add') }}
            @else
                {{ __('Edit') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('users.update') }}">
                        @csrf

                        <x-input type="hidden" name="id"
                                 value="{{ isset($data['id']) ? $data['id'] : '' }}"
                        />

                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required
                                     value="{{ old('name', isset($data['name']) ? $data['name'] : '' ) }}"
                            />
                        </div>
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" required
                                     value="{{ old('email', isset($data['email']) ? $data['email'] : '' ) }}"
                            />
                        </div>
                        <div class="mt-4">
                            <x-label for="role" :value="__('Role')" />
                            <x-select id="role" name="role">
                                <x-slot name="options">
                                    @foreach (UserModel::ROLES as $roleId => $role)
                                        <option value="{{ $roleId }}"
                                            {{ ((isset($data['role']) && $data['role'] == $roleId) || (!isset($data['role']) && $roleId == UserModel::ROLE_USER_ID)) ? 'selected' : '' }}
                                        >{{ $role }}</option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                        </div>

                        @if(empty($data))
                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('Password')" />

                                <x-input id="password" class="block mt-1 w-full"
                                         type="password"
                                         name="password"
                                         required autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-input id="password_confirmation" class="block mt-1 w-full"
                                         type="password"
                                         name="password_confirmation" required />
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <x-button-nav-link href="#" onclick="history.back();" class="mr-4">
                                {{ __('Back') }}
                            </x-button-nav-link>
                            @if(!empty($data))
                                <x-button-nav-link :href="route('users.add')" class="bg-blue-800 mr-4">
                                    {{ __('Add User') }}
                                </x-button-nav-link>
                                <x-button-delete class="bg-red-500">
                                    {{ __('Delete') }}
                                    <x-slot name="route">
                                        {{ route('users.delete', $data->id) }}
                                    </x-slot>
                                </x-button-delete>
                            @endif
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
