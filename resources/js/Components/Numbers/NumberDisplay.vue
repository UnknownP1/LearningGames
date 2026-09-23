<script setup>
defineProps({
    number: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <section class="number-display">
        <div class="number-display__value">
            {{ number.value }}
        </div>

        <h2 class="number-display__name">
            {{ number.word }}
        </h2>
    </section>
</template>