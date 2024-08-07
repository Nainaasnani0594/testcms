<template>
    <div class="p-6">
        <div class="flex justify-center items-center">
            <h1 class="text-2xl font-bold mb-4">Project Overview</h1>
        </div>
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">Project Name</th>
                    <th class="py-2 px-4 border-b text-left">Contract Value</th>
                    <th class="py-2 px-4 border-b text-left">Work Done</th>
                    <th class="py-2 px-4 border-b text-left">Country</th>
                    <th class="py-2 px-4 border-b text-left">Phase</th>
                    <th class="py-2 px-4 border-b text-left">Therapeutic Area</th>
                    <th class="py-2 px-4 border-b text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="overview in overviews" :key="overview.id">
                    <td class="py-2 px-4 border-b">{{ overview.project_name }}</td>
                    <td class="py-2 px-4 border-b">{{ formatCurrency(overview.contract_value) }}</td>
                    <td class="py-2 px-4 border-b">{{ formatCurrency(overview.work_done) }}</td>
                    <td class="py-2 px-4 border-b">{{ overview.country }}</td>
                    <td class="py-2 px-4 border-b">{{ overview.phase }}</td>
                    <td class="py-2 px-4 border-b">{{ overview.therapeutic_area }}</td>
                    <td class="py-2 px-4 border-b">{{ overview.status }}</td>
                </tr>
                <tr v-if="overviews.length === 0">
                    <td colspan="7" class="py-2 px-4 border-b text-center">No project data available</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    overviews: {
        type: Array,
        required: true
    }
});

function formatCurrency(value) {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);
}
</script>
