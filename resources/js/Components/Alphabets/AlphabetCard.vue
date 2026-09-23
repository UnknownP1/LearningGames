<script setup>
defineProps({
    letter:   { type: String,  required: true },
    isActive: { type: Boolean, default: false },
});

defineEmits(['click']);
</script>

<template>
    <button
        type="button"
        class="alphabet-card"
        :class="{ 'is-active': isActive }"
        :aria-label="`Huruf ${letter} besar dan ${letter.toLowerCase()} kecil`"
        @click="$emit('click', letter)"
    >
        <span class="letter-upper">{{ letter }}</span>
        <span class="letter-lower">{{ letter.toLowerCase() }}</span>
    </button>
</template>