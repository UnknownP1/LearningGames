<script setup>

import ShapeVisual from './ShapeVisual.vue'

defineProps({
    shape: {
        type: Object,
        required: true,
    },
    message: {
        type: String,
        default: '',
    },
})

</script>

<template>

    <section class="shape-display">

        <div class="shape-display__visual">
            <ShapeVisual :shape-id="shape.id" />
        </div>

        <h2 class="shape-display__name">
            {{ shape.name }}
        </h2>

        <p
            v-if="message"
            class="shape-display__message"
        >
            {{ message }}
        </p>

    </section>

</template>