<script setup>
defineProps({
    building: {
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
        class="building-card"
        :class="{ 'building-card--active': active }"
        @click="emit('select', building)"
    >
        <!-- Pakai foto kalau tersedia -->
        <img
            v-if="building.image"
            :src="building.image"
            :alt="building.name"
            class="building-card__image"
        />

        <!-- Kalau tidak ada foto, tetap pakai emoji -->
        <span
            v-else
            class="building-card__emoji"
        >
            {{ building.emoji }}
        </span>

        <span class="building-card__name">
            {{ building.name }}
        </span>
    </button>
</template>