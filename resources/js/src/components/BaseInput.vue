<script setup>
import { defineEmits } from "vue";

const props = defineProps({
    modelValue: String,
    inputType: {
        type: String,
        default: "text",
    },
});

const emit = defineEmits(["update:modelValue"]);

function updateModelValue(event) {
    emit("update:modelValue", event.target.value);
}
</script>
<template>
    <input
        class="form-control"
        :type="inputType"
        :value="modelValue"
        @input="updateModelValue"
    />
</template>
