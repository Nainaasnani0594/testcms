 <!-- resources>js>pages>projects>show.vue -->
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-3 text-gray-900"> Task Details
                    <button @click="showProjectDetails = !showProjectDetails" class="btn btn-primary mr-2">
                        {{ showProjectDetails ? 'Hide' : 'Show' }} Project Details
                    </button>
                    <button @click="showAddGroupForm = !showAddGroupForm" class="btn btn-primary mr-2">
                        {{ showAddGroupForm ? 'Hide' : 'Add' }} Group
                    </button>
                    <button @click="showAddTaskForm = !showAddTaskForm" class="btn btn-primary mr-2">
                        {{ showAddTaskForm ? 'Hide' : 'Add' }} Task
                    </button>
                    <button @click="showImportFile = !showImportFile" class="btn btn-primary mr-2">Import</button>
                    <button @click="exportData" class="btn btn-primary mr-2">Export</button>
                </div>
            </div>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-3 lg:px-4">
                <div v-if="showProjectDetails" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ProjectDetails :project="project" />
                    </div>
                </div>
                <div v-if="showAddGroupForm || showAddTaskForm" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="showAddGroupForm">
                        <AddGroupForm :project-id="project.id" />
                        <hr />
                        </div>
                        <div v-if="showAddTaskForm">
                        <AddTaskForm :groups="project.groups" />
                    </div>
                </div>
                </div>

                <!-- Task Chart Section -->
                <div v-if="showChart" class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <TaskGraph />
                    </div>
                </div>

                <!-- Groups List Section -->
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <GroupsList :project="project" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddGroupForm from "@/Components/AddGroupForm.vue";
import AddTaskForm from "@/Components/AddTaskForm.vue";
import TaskGraph from '@/Components/TaskGraph.vue';
import { Head } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const group_dropdowns = {};

props.project.groups.forEach((group) => {
    group_dropdowns[group.id] = ref(false);
});

const showProjectDetails = ref(false);
const showAddGroupForm = ref(false);
const showAddTaskForm = ref(false);
const showChart = ref(false);

import ProjectDetails from "@/Components/ProjectDetails.vue";
import GroupsList from "@/Components/GroupsList.vue";
import TaskGraph from "@/Components/TaskGraph.vue"; // Import the TaskChart component
</script>


