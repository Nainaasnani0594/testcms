<script setup>
import CustomView from "@/Components/CustomView.vue";
import dayjs from "dayjs";
import { defineProps, defineEmits, ref } from "vue";
const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["updated"]);

const updated_activity = (activity_id) => {
    const options = {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        url: route("activities.update", activity_id),
        data: {
            value: activities.value[activity_id],
        },
    };

    axios
        .request(options)
        .then((response) => {
            console.log(response.data);
            emit("updated", response.data);
        })
        .catch((error) => {
            console.error(error);
        });
};

const activities = ref({});
props.task.activities.forEach((activity) => {
    activities.value[activity.id] = activity.value;
});
</script>
<template>
    <td class="p-0" v-for="activity in task.activities" :key="activity.id">
        <input
        type="text"
        v-model="activities[activity.id]"
        class="custom-input w-10 p-0 text-right pr-1 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        @change="updated_activity(activity.id)"
    />

    </td>
</template>
<style scoped>
.custom-input {
    width: 35px; /* Set the desired width */
    height: 30px; /* Set the desired height */
    margin-left: 25PX;
}
input {
    border: 1px solid #ddd;
    padding: 0.5rem;
    font-size: 0.775rem;
    border-radius: 0.375rem;
}
input:disabled {
    background-color: #f0f0f0;
}
</style>

