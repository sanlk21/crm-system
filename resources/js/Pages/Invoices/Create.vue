<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customers: {
        type: Array,
        required: true
    }
});

const form = useForm({
    customer_id: '',
    invoice_number: '',
    issue_date: '',
    due_date: '',
    amount: '',
    status: 'draft',
    notes: ''
});

const submit = () => {
    form.post(route('invoices.store'), {
        onSuccess: () => {
            console.log('Invoice created successfully');
        },
        onError: (errors) => {
            console.log('Validation errors:', errors);
        }
    });
};
</script>

<template>
    <Head title="Create Invoice" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create Invoice</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                                    <select v-model="form.customer_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        <option value="">Select a customer</option>
                                        <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.name }}</option>
                                    </select>
                                    <p v-if="form.errors.customer_id" class="mt-1 text-sm text-red-600">{{ form.errors.customer_id }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Invoice Number</label>
                                    <input v-model="form.invoice_number" type="text" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <p v-if="form.errors.invoice_number" class="mt-1 text-sm text-red-600">{{ form.errors.invoice_number }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                                    <input v-model="form.issue_date" type="date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <p v-if="form.errors.issue_date" class="mt-1 text-sm text-red-600">{{ form.errors.issue_date }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                    <input v-model="form.due_date" type="date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <p v-if="form.errors.due_date" class="mt-1 text-sm text-red-600">{{ form.errors.due_date }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Amount</label>
                                    <input v-model="form.amount" type="number" step="0.01" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <p v-if="form.errors.amount" class="mt-1 text-sm text-red-600">{{ form.errors.amount }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select v-model="form.status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        <option value="draft">Draft</option>
                                        <option value="sent">Sent</option>
                                        <option value="paid">Paid</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <p v-if="form.errors.status" class="mt-1 text-sm text-red-600">{{ form.errors.status }}</p>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea v-model="form.notes" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                                    <p v-if="form.errors.notes" class="mt-1 text-sm text-red-600">{{ form.errors.notes }}</p>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6 space-x-4">
                                <Link :href="route('invoices.index')" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</Link>
                                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600" :disabled="form.processing">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
