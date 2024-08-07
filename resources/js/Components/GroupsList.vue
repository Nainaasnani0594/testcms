<script setup>
import { ref,onMounted, watch} from 'vue';
import GroupItem from "./GroupItem.vue";
import dayjs from "dayjs";
import axios from 'axios';

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});
const checkboxStates = ref(
    props.project.months.reduce((acc, month) => {
        acc[month] = false; 
        return acc;
    }, {})
);

const handleCheckboxClick = (month) => {
    const confirmed = confirm(`Do you want to freeze the data for ${dayjs(month).format("MMM-YY")}?`);
    if (confirmed) {
        // checkboxStates.value[month] = !checkboxStates.value[month];
        freezeDataForMonth(month);

    }
};
const freezeDataForMonth = (month) => {
    axios.post(`/groups/${props.project.group_id}/toggle-freeze-month`, { month })
    .then(response => {
        checkboxStates.value[month] = response.data.frozen_months.includes(month);
    })
        .catch(error => {
            console.error('Error freezing data:', error.response ? error.response.data : error.message);
        });

    // console.log(`Data for ${dayjs(month).format("MMM-YY")} is now frozen.`);
};

watch(checkboxStates, (newStates) => {
    console.log("Checkbox states changed:", newStates);
}, { deep: true });

onMounted(() => {
    axios.get(`/groups/${props.project.group_id}`)
        .then(response => {
            const frozenMonths = response.data.frozen_months || [];
            props.project.months.forEach(month => {
                checkboxStates.value[month] = frozenMonths.includes(month);
            });
        })
        .catch(error => {
            console.error(error);
        });
});

</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow-lg border-collapse">
            <thead class="bg-blue-500">
                <tr>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Deliverables</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">UNIT</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">#Units</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Price</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Total</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border" v-for="month in project.months" :key="month">
                        {{ dayjs(month).format("MMM-YY") }}
                    </th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Units Done</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Units Forecast</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Amount Done</th>
                    <th scope="col" class="px-6 py-1 text-left text-xs font-bold text-white uppercase tracking-wider border">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr class="bg-gray-50 hover:bg-gray-100 transition duration-150 ease-in-out">
                    <td class="px-6 py-1 whitespace-nowrap border"></td>
                    <td class="px-6 py-1 whitespace-nowrap border"></td>
                    <td class="px-6 py-1 whitespace-nowrap border"></td>
                    <td class="px-6 py-1 whitespace-nowrap border"></td>
                    <td class="px-6 py-1 whitespace-nowrap border"></td>
                    <td class="px-6 py-1 whitespace-nowrap text-center text-xs border" v-for="month in project.months" :key="month">
                        <input type="checkbox" :id="`forecast-${month}`" v-model="checkboxStates[month]" @click="() => handleCheckboxClick(month)">
                        <label :for="`forecast-${month}`">{{ dayjs(month).isAfter(dayjs().startOf('month')) ? "Forecast" : "Actual" }}</label>
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
