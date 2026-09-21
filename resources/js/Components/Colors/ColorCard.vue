<script setup>

defineProps({
    color: {
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
        class="color-card"

        :class="{
            'color-card--active': active
        }"

        :aria-label="
            `Pilih warna ${color.name}`
        "

        @click="
            emit('select', color)
        "
    >

        <span
            class="color-card__dot"

            :style="{
                backgroundColor: color.hex
            }"
        ></span>


        <span class="color-card__name">
            {{ color.name }}
        </span>

    </button>

</template>