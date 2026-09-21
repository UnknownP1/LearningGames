<script setup>

defineProps({
    animal: {
        type: Object,
        required: true,
    },
})

</script>


<template>

    <section class="animal-display">

        <div class="animal-display__emoji">
            {{ animal.emoji }}
        </div>

        <div class="animal-display__name">
            {{ animal.name }}
        </div>

    </section>

</template>