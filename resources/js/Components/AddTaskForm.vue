<style scoped>
.small-text {
    font-size: 0.75rem; /* Adjust as needed */
}
</style>


<script setup>
import { useForm } from "@inertiajs/vue3";
import CustomInput from "@/Components/CustomInput.vue";
import CustomSelect from "@/Components/CustomSelect.vue";

const props = defineProps({
    groups: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
    group_id: "",
    unit: "",
    quantity: 0,
    price: 0,
});

const submit = () => {
    form.post(route("tasks.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>


<template>
    <form class="grid grid-cols-3 small-text" @submit.prevent="submit">
        <CustomSelect
            _id="group_id"
            _label="Group"
            v-model="form.group_id"
            :error="form.errors.group_id"
            class="small-text"
        >
            <option v-for="group in groups" :key="group.id" :value="group.id">
                {{ group.name }}
            </option>
        </CustomSelect>

        <CustomInput
            _id="name"
            _label="Task Name"
            v-model="form.name"
            :error="form.errors.name"
            class="small-text"
        />
        <CustomInput
            _id="unit"
            _label="Unit"
            v-model="form.unit"
            :error="form.errors.unit"
            class="small-text"
        />
        <CustomInput
            _id="quantity"
            _label="Quantity"
            v-model="form.quantity"
            :error="form.errors.quantity"
            _type="number"
            class="small-text"
        />
        <CustomInput
            _id="price"
            _label="Price"
            v-model="form.price"
            :error="form.errors.price"
            _type="number"
            class="small-text"
        />
        <input type="submit" class="self-center btn btn-primary max-w-xs small-text" value="Add Task" />
    </form>
</template>
