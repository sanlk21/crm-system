<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    invoices: {
        type: Object,
        required: true
    }
});

const validInvoices = computed(() => {
    if (!props.invoices?.data) return [];
    return props.invoices.data.filter(invoice => invoice && typeof invoice === 'object' && invoice.id);
});

const deleteInvoice = (id) => {
    if (confirm('Are you sure you want to delete this invoice?')) {
        router.delete(route('invoices.delete', id), {
            preserveScroll: true,
            onSuccess: () => {}
        });
    }
};
</script>

<template>
    <Head title="Invoices" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Invoice Management</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-end mb-6">
                            <Link :href="route('invoices.create')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Add New Invoice
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="invoice in validInvoices" :key="invoice.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ invoice.invoice_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ invoice.customer ? invoice.customer.name : 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">${{ invoice.amount }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="{
                                                'bg-green-100 text-green-800': invoice.status === 'paid',
                                                'bg-yellow-100 text-yellow-800': invoice.status === 'sent',
                                                'bg-red-100 text-red-800': invoice.status === 'cancelled',
                                                'bg-gray-100 text-gray-800': invoice.status === 'draft'
                                            }" class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full">
                                                {{ invoice.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ invoice.issue_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ invoice.due_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <Link :href="route('invoices.show', invoice.id)" class="text-green-600 hover:text-green-900 mr-4">Show</Link>
                                            <Link :href="route('invoices.edit', invoice.id)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</Link>
                                            <button @click="deleteInvoice(invoice.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                    <tr v-if="validInvoices.length === 0">
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No invoices found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <Pagination v-if="invoices?.links" :links="invoices.links" class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
