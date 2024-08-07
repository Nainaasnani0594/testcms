<script setup>
import { ref,onMounted, watch} from 'vue';
import GroupItem from "./GroupItem.vue";
import dayjs from "dayjs";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow-lg border-collapse">
            <thead class="bg-blue-500">
                <tr>
                    <th>Deliverables &amp; Tasks</th>
                    <th>UNIT</th>
                    <th>No. of Units</th>
                    <th>Unit Price</th>
                    <th>Total Task Value</th>
                    <th class="p-0" v-for="month in project.months" :key="month">
                        {{ dayjs(month).format("MMM-YY") }}
                    </th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Units Done</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Units Forecast</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Amount Done</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Status</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td class="px-0.5 text-xs" v-for="month in project.months" :key="month">
                        {{ dayjs(month) > dayjs().startOf('month') ? "Forecast" : "Actual" }}
                    </td>
                </tr>
                <GroupItem
                    v-for="group in project.groups"
                    :key="group.id"
                    :group="group"
                    class="text-xs" 
                />
            </tbody>
        </table>
    </div>
</template>

<style scoped>
table {
    border-collapse: collapse;
}

td, th {
    border: 1px solid #ddd;
}

td.no-border {
    border: none;
}

input[type="checkbox"] {
    margin-right: 0.5rem;
}
.text-xs {
    font-size: 0.75rem; 
}
</style>
