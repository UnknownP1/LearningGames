<script setup>

defineProps({
    building: {
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

    <section class="building-display">

        <div class="building-display__emoji">
            {{ building.emoji }}
        </div>

        <h2 class="building-display__name">
            {{ building.name }}
        </h2>

        <p
            v-if="message"
            class="building-display__message"
        >
            {{ message }}
        </p>

    </section>

</template>