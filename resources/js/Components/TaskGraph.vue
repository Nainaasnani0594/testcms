<template>
    <div>
        <canvas id="taskChart"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import Chart from 'chart.js/auto';

const props = defineProps({
    groups: {
        type: Array,
        required: true,
    },
});

const taskChart = ref(null);

const createChart = () => {
    const ctx = document.getElementById('taskChart').getContext('2d');

    const data = {
        labels: props.groups.map(group => group.name),
        datasets: [
            {
                label: 'Units Done',
                data: props.groups.map(group => group.units_done),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            },
            {
                label: 'Units Required',
                data: props.groups.map(group => group.units_required),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            },
        ],
    };

    if (taskChart.value) {
        taskChart.value.destroy();
    }

    taskChart.value = new Chart(ctx, {
        type: 'bar',
        data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};

onMounted(createChart);

watch(() => props.groups, createChart, { deep: true });
</script>

<style scoped>
canvas {
    max-width: 100%;
}
</style>
