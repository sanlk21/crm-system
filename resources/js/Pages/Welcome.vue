<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-900 text-white min-h-screen">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px] opacity-10"
            src="https://via.placeholder.com/877x500?text=CRM+Background"
            alt="CRM Background"
            @error="handleImageError"
        />
        <div class="relative flex min-h-screen flex-col items-center justify-center selection:bg-blue-600">
            <div class="relative w-full max-w-7xl px-6 py-12 lg:px-8">
                <header class="flex justify-between items-center py-6">
                    <div class="flex items-center">
                        <svg class="h-12 w-auto text-blue-400" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M50 10C25 10 10 25 10 50C10 75 25 90 50 90C75 90 90 75 90 50C90 25 75 10 50 10ZM60 40L40 60M40 40L60 60" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h1 class="ml-4 text-2xl font-bold text-white">CRM Pro</h1>
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex items-center space-x-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-4 py-2 text-gray-200 hover:text-white hover:bg-blue-700 transition duration-300"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-4 py-2 text-gray-200 hover:text-white hover:bg-blue-700 transition duration-300"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 transition duration-300"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-12">
                    <div class="grid gap-8 lg:grid-cols-2 lg:gap-12">
                        <!-- Hero Section -->
                        <div class="lg:col-span-2 text-center">
                            <h2 class="text-4xl font-bold text-white mb-4">Welcome to CRM Pro</h2>
                            <p class="text-lg text-gray-300 mb-6">Streamline your business with powerful customer management, invoicing, and analytics tools.</p>
                            <Link :href="$page.props.auth.user ? route('dashboard') : route('login')" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">Get Started</Link>
                        </div>

                        <!-- Feature Cards -->
                        <a
                            href="/dashboard"
                            id="docs-card"
                            class="flex flex-col items-start gap-6 rounded-lg bg-gray-800 p-6 shadow-lg ring-1 ring-gray-700 hover:bg-gray-700 transition duration-300"
                        >
                            <div id="screenshot-container" class="relative w-full h-48 overflow-hidden rounded-lg">
                                <img
                                    src="https://via.placeholder.com/400x200?text=Dashboard"
                                    alt="Dashboard Screenshot"
                                    class="w-full h-full object-cover"
                                    @error="handleImageError"
                                />
                            </div>
                            <div id="docs-card-content" class="flex items-start gap-4">
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-600">
                                    <svg class="size-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2zm8-10v2a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5v6m0 0v6m0-6h6m-6 0H7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-white">Dashboard</h3>
                                    <p class="mt-2 text-gray-400">Monitor key metrics and manage your business with real-time insights.</p>
                                </div>
                            </div>
                        </a>

                        <a
                            href="/customers"
                            class="flex flex-col items-start gap-6 rounded-lg bg-gray-800 p-6 shadow-lg ring-1 ring-gray-700 hover:bg-gray-700 transition duration-300"
                        >
                            <div id="screenshot-container" class="relative w-full h-48 overflow-hidden rounded-lg">
                                <img
                                    src="https://via.placeholder.com/400x200?text=Customers"
                                    alt="Customers Screenshot"
                                    class="w-full h-full object-cover"
                                    @error="handleImageError"
                                />
                            </div>
                            <div id="docs-card-content" class="flex items-start gap-4">
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-600">
                                    <svg class="size-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-1m-4 12v-3.5a3.5 3.5 0 11-7 0V19m-4-1h8a3 3 0 003-3V8m-9 4h18"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-white">Customer Management</h3>
                                    <p class="mt-2 text-gray-400">Track and engage with your customers efficiently.</p>
                                </div>
                            </div>
                        </a>

                        <a
                            href="/invoices"
                            class="flex flex-col items-start gap-6 rounded-lg bg-gray-800 p-6 shadow-lg ring-1 ring-gray-700 hover:bg-gray-700 transition duration-300"
                        >
                            <div id="screenshot-container" class="relative w-full h-48 overflow-hidden rounded-lg">
                                <img
                                    src="https://via.placeholder.com/400x200?text=Invoicing"
                                    alt="Invoicing Screenshot"
                                    class="w-full h-full object-cover"
                                    @error="handleImageError"
                                />
                            </div>
                            <div id="docs-card-content" class="flex items-start gap-4">
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-600">
                                    <svg class="size-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14v6m-3-3h6M5 10a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2V10z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-white">Invoicing</h3>
                                    <p class="mt-2 text-gray-400">Create and manage invoices with ease.</p>
                                </div>
                            </div>
                        </a>

                        <a
                            href="/proposals"
                            class="flex flex-col items-start gap-6 rounded-lg bg-gray-800 p-6 shadow-lg ring-1 ring-gray-700 hover:bg-gray-700 transition duration-300"
                        >
                            <div id="screenshot-container" class="relative w-full h-48 overflow-hidden rounded-lg">
                                <img
                                    src="https://via.placeholder.com/400x200?text=Proposals"
                                    alt="Proposals Screenshot"
                                    class="w-full h-full object-cover"
                                    @error="handleImageError"
                                />
                            </div>
                            <div id="docs-card-content" class="flex items-start gap-4">
                                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-600">
                                    <svg class="size-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-white">Proposals</h3>
                                    <p class="mt-2 text-gray-400">Generate and track proposals to win more business.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </main>

                <footer class="py-8 text-center text-sm text-gray-500">
                    CRM Pro v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
