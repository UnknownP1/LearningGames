<script setup>

defineProps({
    shapeId: {
        type: String,
        required: true,
    },
})

/*
|--------------------------------------------------------------------------
| WARNA UNIK PER BENTUK
|--------------------------------------------------------------------------
*/

const COLORS = {
    circle:    '#ef4444',
    square:    '#3b82f6',
    rectangle: '#eab308',
    triangle:  '#f97316',
    star:      '#fbbf24',
    heart:     '#ec4899',
}

function colorFor(id) {
    return COLORS[id] || '#08777b'
}

</script>

<template>

    <svg
        class="shape-visual"
        viewBox="0 0 100 100"
        xmlns="http://www.w3.org/2000/svg"
        preserveAspectRatio="xMidYMid meet"
        aria-hidden="true"
    >

        <!-- LINGKARAN -->
        <circle
            v-if="shapeId === 'circle'"
            cx="50"
            cy="50"
            r="42"
            :fill="colorFor('circle')"
        />

        <!-- PERSEGI (1 : 1) -->
        <rect
            v-else-if="shapeId === 'square'"
            x="12"
            y="12"
            width="76"
            height="76"
            rx="5"
            :fill="colorFor('square')"
        />

        <!-- PERSEGI PANJANG (2 : 1, jelas lonjong) -->
        <rect
            v-else-if="shapeId === 'rectangle'"
            x="4"
            y="30"
            width="92"
            height="40"
            rx="5"
            :fill="colorFor('rectangle')"
        />

        <!-- SEGITIGA (besar, penuh viewBox) -->
        <polygon
            v-else-if="shapeId === 'triangle'"
            points="50,6 94,90 6,90"
            :fill="colorFor('triangle')"
        />

        <!-- BINTANG -->
        <polygon
            v-else-if="shapeId === 'star'"
            points="50,4 61,37 96,37 68,58 79,92 50,71 21,92 32,58 4,37 39,37"
            :fill="colorFor('star')"
        />

        <!-- HATI -->
        <path
            v-else-if="shapeId === 'heart'"
            d="M50,88
            C20,68 4,48 4,32
            C4,18 14,8 28,8
            C38,8 46,14 50,22
            C54,14 62,8 72,8
            C86,8 96,18 96,32
            C96,48 80,68 50,88 Z"
            :fill="colorFor('heart')"
        />

    </svg>

</template>