<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="min-h-screen flex justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-md w-full space-y-8">

                        {{-- Alert Messages --}}
                        @if(Session::has("success"))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Success!</strong>
                                <span class="block sm:inline">{{ Session::get('success') }}</span>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <title>Close</title>
                                        <path d="M14.348 14.849a1 1 0 0 1-1.697 0L10 11.818l-2.651 3.03a1 1 0 0 1-1.697-1.151l2.758-3.152-2.759-3.152a1 1 0 1 1 1.697-1.151L10 8.182l2.651-3.03a1 1 0 0 1 1.697 1.151l-2.758 3.152 2.758 3.151a1 1 0 0 1 0 1.698z"/>
                                    </svg>
                                </span>
                            </div>
                        @elseif(Session::has("failed"))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Failed!</strong>
                                <span class="block sm:inline">{{ Session::get('failed') }}</span>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <title>Close</title>
                                        <path d="M14.348 14.849a1 1 0 0 1-1.697 0L10 11.818l-2.651 3.03a1 1 0 0 1-1.697-1.151l2.758-3.152-2.759-3.152a1 1 0 1 1 1.697-1.151L10 8.182l2.651-3.03a1 1 0 0 1 1.697 1.151l-2.758 3.152 2.758 3.151a1 1 0 0 1 0 1.698z"/>
                                    </svg>
                                </span>
                            </div>
                        @endif

                        {{-- Create Email Configuration Form --}}
                        <div>
                            <h2 class="text-center text-3xl font-extrabold text-gray-900">Create Email Configuration</h2>
                        </div>

                        <form class="mt-8 space-y-6" action="{{ route('configuration.store') }}" method="POST">
                            @csrf

                            <div class="shadow-sm -space-y-px mb-4">
                                <div>
                                    <label for="driver" class="sr-only">SMTP</label>
                                    <input id="driver" name="driver" type="text" required
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Driver">
                                </div>
                            </div>

                            <div class="shadow-sm -space-y-px mb-4">
                                <div>
                                    <label for="host-name" class="sr-only">Host</label>
                                    <input id="host-name" name="hostName" type="text" required
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Host">
                                </div>
                            </div>

                            <div class="shadow-sm -space-y-px mb-4">
                                <div>
                                    <label for="port" class="sr-only">Port</label>
                                    <input id="port" name="port" type="text" required
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Port">
                                </div>
                            </div>

                            <div class="shadow-sm -space-y-px mb-4">
                                <div>
                                    <label for="userName" class="sr-only">User Name</label>
                                    <input id="userName" name="userName" type="text" required
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="User Name">
                                </div>
                            </div>

                            <div class="shadow-sm -space-y-px mb-4">
                                <div>
                                    <label for="password" class="sr-only">Password</label>
                                    <input id="password" name="password" type="password" required autocomplete="current-password"
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Password">
                                </div>
                            </div>

                            <div class="shadow-sm -space-y-px mb-4">
                                <div>
                                    <label for="senderName" class="sr-only">Sender Name</label>
                                    <input id="senderName" name="senderName" type="text" required
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Sender Name">
                                </div>
                            </div>

                            <div class="shadow-sm -space-y-px mb-4">
                                <div>
                                    <label for="senderEmail" class="sr-only">Sender Email</label>
                                    <input id="senderEmail" name="senderEmail" type="text" required
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                        placeholder="Sender Email">
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
