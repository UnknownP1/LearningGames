<script setup>
defineProps({
    number: {
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
        class="number-card"
        :class="{ 'number-card--active': active }"
        :aria-label="`Angka ${number.value}, ${number.word}`"
        @click="emit('select', number)"
    >
        <span class="number-card__value">
            {{ number.value }}
        </span>

        <span class="number-card__name">
            {{ number.word }}
        </span>
    </button>
</template>