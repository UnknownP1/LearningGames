<script setup>

defineProps({
    color: {
        type: Object,
        required: true,
    },
})

</script>


<template>

    <section class="color-display">

        <!-- KOTAK WARNA -->

        <div
            class="color-display__swatch"

            :style="{
                backgroundColor: color.hex
            }"

            :aria-label="
                `Warna ${color.name}`
            "
        ></div>


        <!-- NAMA WARNA -->

        <div class="color-display__name">
            {{ color.name }}
        </div>

    </section>

</template>