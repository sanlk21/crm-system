<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    invoice: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Invoice Details" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Invoice Details</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Invoice Number</label>
                                <p class="mt-1 text-sm text-gray-900">{{ invoice.invoice_number }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer</label>
                                <p class="mt-1 text-sm text-gray-900">{{ invoice.customer ? invoice.customer.name : 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ invoice.issue_date }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ invoice.due_date }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <p class="mt-1 text-sm text-gray-900">${{ invoice.amount }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span :class="{
                                    'bg-green-100 text-green-800': invoice.status === 'paid',
                                    'bg-yellow-100 text-yellow-800': invoice.status === 'sent',
                                    'bg-red-100 text-red-800': invoice.status === 'cancelled',
                                    'bg-gray-100 text-gray-800': invoice.status === 'draft'
                                }" class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full">
                                    {{ invoice.status }}
                                </span>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <p class="mt-1 text-sm text-gray-900">{{ invoice.notes || 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-4">
                            <Link :href="route('invoices.index')" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Back</Link>
                            <Link :href="route('invoices.edit', invoice.id)" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</Link>
                            <Link v-if="invoice.status === 'sent' && invoice.customer?.email" :href="route('invoices.resend', invoice.id)" class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">Resend Invoice</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
