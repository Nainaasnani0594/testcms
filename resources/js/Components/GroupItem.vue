<script setup>
import TasksList from "./TasksList.vue";
import _ from "lodash";

const props = defineProps({
    group: {
        type: Object,
        required: true,
    },
});
</script>


<template>
    <tr>
        <th class="text-xs">
            {{ group.name }}
        </th>
    </tr>
    <TasksList :tasks="group.tasks" />
    <tr>
        <th  class="text-xs">{{ group.name }}Total</th>
        <th colspan="4" class="text-xs total-value half-column">
            {{ Intl.NumberFormat("en-US").format(
                _.sumBy(group.tasks, (task) => task.price * task.quantity)
            ) }}
        </th>
    </tr>
</template>
<style scoped>
.text-xs {
    font-size: 0.75rem;
}
.total-header {
    padding: 0.5rem;
    text-align: left;
}

.total-value {
    padding: 1.5rem; 
    text-align: right;
}
</style>
