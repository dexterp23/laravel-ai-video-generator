<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <!-- Search input -->
                        <form method="GET" action="{{ route('users') }}" class="w-full">
                            <div class="flex items-end justify-between gap-4 w-full">
                                <div class="flex flex-col flex-12">
                                    <x-label for="filter" :value="__('Search users')" />
                                    <x-input id="filter" class="block mt-1 w-full" type="text" value="{{ isset($filters['filter']) ? $filters['filter'] : '' }}" name="filter" placeholder="{{ __('Search users...') }}"/>
                                </div>
                                <div class="flex flex-col flex-12">
                                    <x-label for="filter_role" :value="__('Role')" />
                                    <x-select id="filter_role" name="filter_role" class="block mt-1 w-full">
                                        <x-slot name="options">
                                            <option value=""
                                                {{ (!isset($filters['filter_role'])) ? 'selected' : '' }}
                                            >{{ __('None') }}</option>
                                            @foreach (UserModel::ROLES as $roleId => $role)
                                                <option value="{{ $roleId }}"
                                                    {{ (isset($filters['filter_role']) && $filters['filter_role'] == $roleId) ? 'selected' : '' }}
                                                >{{ $role }}</option>
                                            @endforeach
                                        </x-slot>
                                    </x-select>
                                </div>
                                <div class="flex-12 mb-2 sm:mb-0">
                                    <x-button class="ml-3">
                                        {{ __('Filter') }}
                                    </x-button>
                                    <x-button-nav-link :href="route('users')" class="bg-indigo-500">
                                        {{ __('Reset') }}
                                    </x-button-nav-link>
                                    <x-button-nav-link :href="route('users.add')" class="bg-blue-800">
                                        {{ __('Add User') }}
                                    </x-button-nav-link>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b"> {{ __('Id') }}</th>
                            <th class="py-2 px-4 border-b"> {{ __('Name') }}</th>
                            <th class="py-2 px-4 border-b"> {{ __('Email') }}</th>
                            <th class="py-2 px-4 border-b"> {{ __('Role') }}</th>
                            <th class="py-2 px-4 border-b"> {{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($lists as $list)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b text-center">{{ $list->id }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $list->name }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $list->email }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ UserModel::ROLES[$list->role] }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    <x-button-nav-link :href="route('users.edit', $list->id)" class="bg-blue-800">
                                        {{ __('Edit') }}
                                    </x-button-nav-link>
                                    <x-button-nav-link :href="route('users.editPassword', $list->id)" class="bg-blue-800">
                                        {{ __('Update Password') }}
                                    </x-button-nav-link>
                                    <x-button-delete class="bg-red-500">
                                        {{ __('Delete') }}
                                        <x-slot name="route">
                                            {{ route('users.delete', $list->id) }}
                                        </x-slot>
                                    </x-button-delete>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {!! $lists->appends(request()->input())->links() !!}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
