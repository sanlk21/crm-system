<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    customer: {
        type: Object,
        required: true
    }
});

const deleteCustomer = () => {
    if (confirm('Are you sure you want to delete this customer?')) {
        router.delete(route('customers.delete', props.customer.id), {
            preserveScroll: true,
            onSuccess: () => {
                router.visit(route('customers.index'));
            }
        });
    }
};
</script>

<template>
    <Head title="Customer Details" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Customer Details
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ customer.name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ customer.email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ customer.phone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <p class="mt-1 text-sm text-gray-900">{{ customer.address }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1 text-sm text-gray-900">{{ customer.status }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-4">
                            <Link :href="route('customers.index')" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Back
                            </Link>
                            <Link :href="route('customers.edit', customer.id)" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Edit
                            </Link>
                            <button
                                @click="deleteCustomer"
                                class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
