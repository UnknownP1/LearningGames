<script setup>

defineProps({
    shape: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['select'])

</script>

<template>

    <button
        type="button"
        class="shape-card"
        @click="emit('select', shape)"
    >

        <div class="shape-card__emoji">
            {{ shape.emoji }}
        </div>

        <div class="shape-card__name">
            {{ shape.name }}
        </div>

    </button>

</template>