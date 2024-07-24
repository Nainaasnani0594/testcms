<script setup>
import GroupItem from "./GroupItem.vue";
import dayjs from "dayjs";
import { computed } from "vue";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const isPastMonth = (month) => {
    return dayjs(month).isBefore(dayjs(), 'month');
};

const monthStatuses = computed(() => {
    return props.project.months.map((month) => ({
        month,
        isPast: isPastMonth(month),
    }));
});
</script>

<template>
    <div class="overflow-x-auto">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>Deliverables &amp; Tasks</th>
                    <th>UNIT</th>
                    <th>No. of Units</th>
                    <th>Unit Price</th>
                    <th>Total Task Value</th>
                    <th class="p-0" v-for="monthStatus in monthStatuses" :key="monthStatus.month">
                        {{ dayjs(monthStatus.month).format("MMM-YY") }}
                    </th>
                    <th>Units Done</th>
                    <th>Units incl Forecast</th>
                    <th>Amount Done</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td class="px-0.5 text-xs" v-for="monthStatus in monthStatuses" :key="monthStatus.month">
                        {{ monthStatus.isPast ? "Actual" : "Forecast" }}
                    </td>
                </tr>
                <GroupItem
                    v-for="group in project.groups"
                    :key="group.id"
                    :group="group"
                />
            </tbody>
        </table>
    </div>
</template>
