<script setup>
const props = defineProps({
    label: String,
   errors:{
     type: Object,
   }
});
</script>
<template>
<label for="email" class="form-label">{{props.label}}</label>
    <div :class="{ error: props.errors.length }">
        <slot></slot>
  
  <div class="input-errors" v-for="error of props.errors" :key="error.$uid">
    <div class="text-danger">{{ error.$message }}</div>
  </div>
</div>
</template>