@extends('layout.Admin-Side')
<title>@yield('title', 'DCP Dashboard')</title>

@section('content')
    <div class="p-2">
        <div class="flex justify-start gap-2 items-center mb-4">
            <div class="h-10 w-10 bg-white p-3 border border-gray-300 shadow-lg rounded-md flex items-center justify-center">
                <div class="text-white bg-blue-600 p-1 rounded-md">
                    <svg viewBox="0 0 24 24" class="h-8 w-8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M20 21C20 17.134 16.4183 14 12 14C7.58172 14 4 17.134 4 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <div style="letter-spacing: 0.05rem">
                <h2 class="text-2xl font-bold text-gray-700" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    Admin Account
                </h2>
                <div class="text-md text-gray-600">Manage your admin credentials and account security.</div>
            </div>
        </div>

        <div class="mx-5 mb-5 grid grid-cols-1 xl:grid-cols-2 gap-5">
            <div class="bg-white border border-gray-300 rounded-md p-6 shadow-sm hover:shadow-md transition duration-300">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-xl font-bold text-gray-700">Change Username</h3>
                        <p class="text-sm text-gray-600 mt-1">Update the admin login username used for this account.</p>
                    </div>
                    <x-badge color="blue">
                        <div class="whitespace-nowrap">Admin Access</div>
                    </x-badge>
                </div>

                <div class="mb-4 p-4 rounded-md bg-gray-50 border border-gray-200">
                    <div class="page-subtitle text-base">Current Username</div>
                    <div class="text-lg font-semibold text-gray-800 break-all">{{ $adminUser->username ?? 'admin' }}</div>
                </div>

                <form action="{{ route('admin.change.username') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">New Username</label>
                        <input type="text" name="username" id="username" required value="{{ old('username', $adminUser->username ?? '') }}"
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn-submit px-4 py-1 rounded">
                            Update Username
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-gray-300 rounded-md p-6 shadow-sm hover:shadow-md transition duration-300">
                <div class="mb-5">
                    <h3 class="text-xl font-bold text-gray-700">Change Password</h3>
                    <p class="text-sm text-gray-600 mt-1">Keep the admin account secure by updating the password regularly.</p>
                </div>

                <div class="mb-4 p-4 rounded-md bg-gray-50 border border-gray-200 space-y-1">
                    <div class="text-sm text-gray-700">
                        <span class="font-semibold">Password Changed:</span>
                        {{ $adminUser?->password_changed_at ? \Carbon\Carbon::parse($adminUser->password_changed_at)->format('F j, Y, g:i a') : 'Never' }}
                    </div>
                    <div class="text-sm text-gray-700">
                        <span class="font-semibold">Last Login:</span>
                        {{ $adminUser?->last_login ? \Carbon\Carbon::parse($adminUser->last_login)->format('F j, Y, g:i a') : 'Never' }}
                    </div>
                </div>

                <form action="{{ route('admin.change.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                        <button type="button" onclick="togglePassword('current_password', this)"
                            class="absolute right-3 top-9 text-gray-600 p-1 hover:text-blue-600 focus:outline-none  shadow-none"
                            aria-label="Show password">
                            <svg data-eye-icon="show" viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12C3.73 7.61 7.52 5 12 5C16.48 5 20.27 7.61 22 12C20.27 16.39 16.48 19 12 19C7.52 19 3.73 16.39 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password" id="new_password" required
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                        <button type="button" onclick="togglePassword('new_password', this)"
                            class="absolute right-3 top-9 text-gray-600 p-1 hover:text-blue-600 focus:outline-none shadow-none"
                            aria-label="Show password">
                            <svg data-eye-icon="show" viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12C3.73 7.61 7.52 5 12 5C16.48 5 20.27 7.61 22 12C20.27 16.39 16.48 19 12 19C7.52 19 3.73 16.39 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                            class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                        <button type="button" onclick="togglePassword('new_password_confirmation', this)"
                            class="absolute right-3 top-9 text-gray-600 p-1 hover:text-blue-600 focus:outline-none  shadow-none"
                            aria-label="Show password">
                            <svg data-eye-icon="show" viewBox="0 0 24 24" class="h-5 w-5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 12C3.73 7.61 7.52 5 12 5C16.48 5 20.27 7.61 22 12C20.27 16.39 16.48 19 12 19C7.52 19 3.73 16.39 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <div>
                        <button type="submit" class="btn-submit px-4 py-1 rounded">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('[data-eye-icon]');
            if (input.type === 'password') {
                input.type = 'text';
                btn.setAttribute('aria-label', 'Hide password');
                if (icon) {
                    icon.innerHTML = `
                        <path d="M3 3L21 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10.58 10.58C10.21 10.95 10 11.46 10 12C10 13.1 10.9 14 12 14C12.54 14 13.05 13.79 13.42 13.42" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9.88 5.09C10.56 5.03 11.27 5 12 5C16.48 5 20.27 7.61 22 12C21.18 14.08 19.84 15.9 18.13 17.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6.61 6.62C4.62 7.88 3.07 9.77 2 12C3.73 16.39 7.52 19 12 19C13.85 19 15.59 18.55 17.12 17.76" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    `;
                }
            } else {
                input.type = 'password';
                btn.setAttribute('aria-label', 'Show password');
                if (icon) {
                    icon.innerHTML = `
                        <path d="M2 12C3.73 7.61 7.52 5 12 5C16.48 5 20.27 7.61 22 12C20.27 16.39 16.48 19 12 19C7.52 19 3.73 16.39 2 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    `;
                }
            }
        }
    </script>
@endsection
