<script setup>
import ActivitiesList from "@/Components/ActivitiesList.vue";
import dayjs from "dayjs";
import _ from "lodash";
import { defineProps, onMounted, computed } from "vue";

const props = defineProps({
    tasks: {
        type: Array,
        required: true,
    },
});

onMounted(() => {
    console.log(props.tasks);
});

const isPastMonth = (date) => {
    return dayjs(date).isBefore(dayjs().startOf("month"));
};

const on_activity_updated = (updated_activity) => {
    const task_index = props.tasks.findIndex(
        (task) => task.id === updated_activity.task_id
    );
    const activity_index = props.tasks[task_index].activities.findIndex(
        (activity) => activity.id === updated_activity.id
    );
    if (!isPastMonth(updated_activity.date)) {
        props.tasks[task_index].activities[activity_index].value =
            Number(updated_activity.value);
    }
};
</script>

<template>
    <tr v-for="task in tasks" :key="task.id">
        <td>
            {{ task.name }}
        </td>
        <td>
            {{ task.unit }}
        </td>
        <td>
            {{ task.quantity }}
        </td>
        <td>
            {{ Intl.NumberFormat("en-US").format(task.price) }}
        </td>
        <td>
            {{ Intl.NumberFormat("en-US").format(task.price * task.quantity) }}
        </td>
        <ActivitiesList @updated="on_activity_updated($event)" :task="task" />
        <td>
            {{
                _.sumBy(task.activities, (activity) =>
                    isPastMonth(activity.date)
                        ? activity.value
                        : 0
                )
            }}
        </td>
        <td>
            {{ _.sumBy(task.activities, (activity) => activity.value) }}
        </td>
        <td>
            {{
                Intl.NumberFormat("en-US").format(
                    _.sumBy(task.activities, (activity) =>
                        isPastMonth(activity.date)
                            ? activity.value
                            : 0
                    ) * task.price
                )
            }}
        </td>
        <td>
            {{
                _.sumBy(task.activities, (activity) =>
                    isPastMonth(activity.date)
                        ? activity.value
                        : 0
                ) >= task.quantity
                    ? "Task Done"
                    : "WIP"
            }}
        </td>
    </tr>
</template>
