<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ArcElement, Chart as ChartJS, Legend, Title, Tooltip } from 'chart.js';
import { onMounted, ref } from 'vue';
import { Pie } from 'vue-chartjs';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, ArcElement);

// Props from the backend with default values
const props = defineProps({
    customerCount: { type: Number, default: 0 },
    invoiceCount: { type: Number, default: 0 },
    proposalCount: { type: Number, default: 0 },
    proposalStatuses: { type: Object, default: () => ({}) },
    recentProposals: { type: Array, default: () => [] },
});

// Chart data
const chartData = ref({
    labels: [],
    datasets: [
        {
            data: [],
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF',
            ],
        },
    ],
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Proposal Status Distribution',
        },
    },
};

// Populate chart data on mount
onMounted(() => {
    chartData.value.labels = Object.keys(props.proposalStatuses);
    chartData.value.datasets[0].data = Object.values(props.proposalStatuses);
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Metrics Cards -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mb-8">
                    <!-- Customer Count -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center space-x-4">
                        <div class="text-gray-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a2 2 0 00-2-2h-3m-2-2H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v7a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ customerCount }}</h3>
                            <p class="text-sm text-gray-600">Total Customers</p>
                        </div>
                    </div>

                    <!-- Invoice Count -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center space-x-4">
                        <div class="text-gray-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-3-9h.01M12 3a9 9 0 100 18 9 9 0 000-18z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ invoiceCount }}</h3>
                            <p class="text-sm text-gray-600">Total Invoices</p>
                        </div>
                    </div>

                    <!-- Proposal Count -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 flex items-center space-x-4">
                        <div class="text-gray-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ proposalCount }}</h3>
                            <p class="text-sm text-gray-600">Total Proposals</p>
                        </div>
                    </div>
                </div>

                <!-- Proposal Status Chart -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Proposal Status Overview</h3>
                    <div class="h-64">
                        <Pie :data="chartData" :options="chartOptions" />
                    </div>
                </div>

                <!-- Recent Proposals Table -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Proposals</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="proposal in recentProposals" :key="proposal.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ proposal.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ proposal.customer_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ proposal.amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="{
                                            'bg-green-100 text-green-800': proposal.status === 'accepted',
                                            'bg-yellow-100 text-yellow-800': proposal.status === 'sent',
                                            'bg-red-100 text-red-800': proposal.status === 'declined',
                                            'bg-gray-100 text-gray-800': proposal.status === 'draft'
                                        }" class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full">
                                            {{ proposal.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <Link :href="route('proposals.show', proposal.id)" class="text-blue-600 hover:text-blue-900">View</Link>
                                    </td>
                                </tr>
                                <tr v-if="!recentProposals.length">
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No recent proposals found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
