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
                <!-- Project Details Section -->
                <div v-if="showProjectDetails" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <ProjectDetails :project="project" />
                    </div>
                </div>

                <!-- Add Group and Task Form Section -->
                <div v-if="showAddGroupForm || showAddTaskForm" class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
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

                <!-- Import File Section -->
                <div v-if="showImportFile" class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <input type="file" @change="handleFileUpload" />
        </div>
    </div>

                <!-- Groups List Section -->
                <div v-if="showGroupsList" class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
import ProjectDetails from "@/Components/ProjectDetails.vue";
import GroupsList from "@/Components/GroupsList.vue";
import { Head } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";
import { Inertia } from "@inertiajs/inertia";


const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const showProjectDetails = ref(false);
const showAddGroupForm = ref(false);
const showAddTaskForm = ref(false);
const showImportFile = ref(false);
const showGroupsList = ref(true); // Default to true to show GroupsList

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('project_id', props.project.id); // Optional: Send the project ID if needed

        Inertia.post('/projects/import', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
            onSuccess: () => {
                // Handle success, e.g., show a success message
                showImportFile.value = false; // Hide import section after success
            },
            onError: () => {
                // Handle error, e.g., show an error message
                console.error(errors);

            },
        });
    }
};
const exportData = () => {
    Inertia.get('/projects/export', { project_id: props.project.id });
};

</script>
