<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Overview from '@/Pages/Overview.vue';

const projects = ref([]); // Fetch your projects data here
const overviews = ref([]); // Overview data

const computeContractValue = (tasks) => {
  return tasks.reduce((total, task) => total + (task.price * task.quantity), 0);
};


onMounted(async () => {
  // Fetch projects data from the server (example using axios)
  try {
    const response = await axios.get('/api/projects');
    projects.value = response.data;

    overviews.value = projects.value.map(project => ({
      ...project,
      contract_value: computeContractValue(project.tasks),
      work_done: project.work_done || 0,
      status: project.status || 'In Progress', // Default status if not provided
    }));
  } catch (error) {
    console.error(error);
  }
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <p>You're logged in!</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
