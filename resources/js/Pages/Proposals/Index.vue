<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    proposals: {
        type: Object,
        required: true
    }
});

const validProposals = computed(() => {
    if (!props.proposals?.data) return [];
    return props.proposals.data.filter(proposal => proposal && typeof proposal === 'object' && proposal.id);
});

const deleteProposal = (id) => {
    if (confirm('Are you sure you want to delete this proposal?')) {
        router.delete(route('proposals.delete', id), {
            preserveScroll: true,
            onSuccess: () => {}
        });
    }
};
</script>

<template>
    <Head title="Proposals" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Proposal Management</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-end mb-6">
                            <Link :href="route('proposals.create')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Add New Proposal
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proposal Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="proposal in validProposals" :key="proposal.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ proposal.title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ proposal.customer.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">${{ proposal.amount }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="{
                                                'bg-green-100 text-green-800': proposal.status === 'approved',
                                                'bg-yellow-100 text-yellow-800': proposal.status === 'sent',
                                                'bg-red-100 text-red-800': proposal.status === 'rejected',
                                                'bg-gray-100 text-gray-800': proposal.status === 'draft'
                                            }" class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full">
                                                {{ proposal.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ proposal.proposal_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ proposal.end_date }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <Link :href="route('proposals.show', proposal.id)" class="text-green-600 hover:text-green-900 mr-4">Show</Link>
                                            <Link :href="route('proposals.edit', proposal.id)" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</Link>
                                            <button @click="deleteProposal(proposal.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                    <tr v-if="validProposals.length === 0">
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No proposals found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <Pagination v-if="proposals?.links" :links="proposals.links" class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
