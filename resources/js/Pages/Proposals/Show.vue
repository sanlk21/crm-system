<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    proposal: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Proposal Details" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Proposal Details</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <p class="mt-1 text-sm text-gray-900">{{ proposal.title }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer</label>
                                <p class="mt-1 text-sm text-gray-900">{{ proposal.customer.name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <p class="mt-1 text-sm text-gray-900">{{ proposal.description }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <p class="mt-1 text-sm text-gray-900">${{ proposal.amount }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span :class="{
                                    'bg-green-100 text-green-800': proposal.status === 'approved',
                                    'bg-yellow-100 text-yellow-800': proposal.status === 'sent',
                                    'bg-red-100 text-red-800': proposal.status === 'rejected',
                                    'bg-gray-100 text-gray-800': proposal.status === 'draft'
                                }" class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full">
                                    {{ proposal.status }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proposal Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ proposal.proposal_date }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ proposal.end_date }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-4">
                            <Link :href="route('proposals.index')" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Back</Link>
                            <Link :href="route('proposals.edit', proposal.id)" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
