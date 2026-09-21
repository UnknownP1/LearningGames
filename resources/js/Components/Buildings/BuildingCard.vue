<script setup>

defineProps({
    building: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['select'])

</script>

<template>

    <button
        type="button"
        class="building-card"
        @click="emit('select', building)"
    >

        <div class="building-card__emoji">
            {{ building.emoji }}
        </div>

        <div class="building-card__name">
            {{ building.name }}
        </div>

    </button>

</template>