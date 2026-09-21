<script setup>

defineProps({
    animal: {
        type: Object,
        required: true,
    },

    active: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits([
    'select'
])

</script>


<template>

    <button
        type="button"
        class="animal-card"
        :class="{
            'animal-card--active': active
        }"
        :aria-label="`Pilih hewan ${animal.name}`"
        @click="emit('select', animal)"
    >

        <span class="animal-card__emoji">
            {{ animal.emoji }}
        </span>

        <span class="animal-card__name">
            {{ animal.name }}
        </span>

    </button>

</template>