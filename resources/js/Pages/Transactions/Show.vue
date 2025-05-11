<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Transaction Details" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Transaction Details</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transaction ID</label>
                                <p class="mt-1 text-sm text-gray-900">{{ transaction.transaction_id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Invoice</label>
                                <p class="mt-1 text-sm text-gray-900">{{ transaction.invoice ? transaction.invoice.invoice_number : 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer</label>
                                <p class="mt-1 text-sm text-gray-900">{{ transaction.customer ? transaction.customer.name : 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <p class="mt-1 text-sm text-gray-900">${{ transaction.amount }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <p class="mt-1 text-sm text-gray-900">{{ transaction.payment_method }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span :class="{
                                    'bg-green-100 text-green-800': transaction.status === 'completed',
                                    'bg-yellow-100 text-yellow-800': transaction.status === 'pending',
                                    'bg-red-100 text-red-800': transaction.status === 'failed'
                                }" class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full">
                                    {{ transaction.status }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-4">
                            <Link :href="route('transactions.index')" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Back</Link>
                            <Link :href="route('transactions.edit', transaction.id)" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
