<script setup>
const props = defineProps({
    _label: {
        type: String,
        required: true,
    },
    _value: {
        type: [String, Number],
        required: true,
    },
    _type: {
        type: String,
        required: false,
        default: "text",
    },
    options: {
        type: Array,
        default: () => []
    },
    modelValue: {
        type: [String, Number],
        required: false
    }
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <label class="form-control w-full max-w-xs">
        <div class="label">
            <span class="label-text">{{ _label }}</span>
        </div>
        <template v-if="_type === 'dropdown'">
            <select
                class="select select-primary select-bordered"
                :value="modelValue"
                @change="event => emit('update:modelValue', event.target.value)"
            >
                <option
                    v-for="option in options"
                    :key="option"
                    :value="option"
                >
                    {{ option }}
                </option>
            </select>
        </template>
        <template v-else>
            <input
                :value="_value"
                readonly
                :type="_type"
                class="input input-bordered input-primary w-full max-w-xs"
            />
        </template>
    </label>
</template>
