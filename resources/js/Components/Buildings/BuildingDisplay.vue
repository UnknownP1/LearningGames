<script setup>
defineProps({
    building: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <section class="building-display">
        <img
            v-if="building.image"
            :src="building.image"
            :alt="building.name"
            class="building-display__image"
        />

        <div
            v-else
            class="building-display__emoji"
        >
            {{ building.emoji }}
        </div>

        <h2 class="building-display__name">
            {{ building.name }}
        </h2>
    </section>
</template>