<script setup>

defineProps({
    modelValue: String,
    keyIndex: String,
    valueIndex: String,
    labelIndex: String,
    data: Array
});

defineEmits(['update:modelValue']);
</script>

<template>
    <select
		ref="input"
		:value="modelValue"
		@change="$emit('update:modelValue', $event.target.value)"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
	>
        <option value="">Please select one</option>
        <option :key="item[keyIndex]" :value="item[valueIndex]" v-for="item in data">{{ item[labelIndex] }}</option>
    </select>
</template>
