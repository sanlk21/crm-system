<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    message: String,
    invoice: Object
});
</script>

<template>
    <Head title="Payment Success" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Payment Success</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="text-lg text-green-600">{{ message }}</p>
                        <div class="mt-4">
                            <p><strong>Invoice Number:</strong> {{ invoice.invoice_number }}</p>
                            <p><strong>Amount Paid:</strong> ${{ invoice.amount }}</p>
                            <p><strong>Customer:</strong> {{ invoice.customer?.name ?? 'N/A' }}</p>
                        </div>
                        <div class="mt-6">
                            <Link :href="route('invoices.index')" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Back to Invoices</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
