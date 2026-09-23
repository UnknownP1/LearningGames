<script setup>

import ShapeVisual from './ShapeVisual.vue'

defineProps({
    shape: {
        type: Object,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['select'])

</script>

<template>

    <button
        type="button"
        class="shape-card"
        :class="{ 'shape-card--active': active }"
        :aria-label="shape.name"
        @click="emit('select', shape)"
    >

        <span class="shape-card__visual">
            <ShapeVisual :shape-id="shape.id" />
        </span>

        <span class="shape-card__name">
            {{ shape.name }}
        </span>

    </button>

</template>