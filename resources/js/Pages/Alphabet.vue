<script setup>
import { ref, onBeforeUnmount } from 'vue';
import { Head } from '@inertiajs/vue3';
import AlphabetCard from '@/Components/Alphabets/AlphabetCard.vue';

const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
const activeLetter = ref(null);
let resetTimer = null;

/**
 * Ucapkan satu huruf dalam Bahasa Indonesia.
 * Browser akan membaca nama huruf (contoh: "F" → "ef").
 */
function speakLetter(letter) {
    if (typeof window === 'undefined' || !('speechSynthesis' in window)) {
        return; // graceful fallback
    }

    window.speechSynthesis.cancel();

    const utterance = new SpeechSynthesisUtterance(letter);
    utterance.lang  = 'id-ID';
    utterance.rate  = 0.85;
    utterance.pitch = 1.1;

    window.speechSynthesis.speak(utterance);
}

function handleLetterClick(letter) {
    activeLetter.value = letter;
    speakLetter(letter);

    if (resetTimer) clearTimeout(resetTimer);
    resetTimer = setTimeout(() => {
        if (activeLetter.value === letter) activeLetter.value = null;
    }, 700);
}

function goHome() {
    window.location.href = '/';
}

function goQuiz() { window.location.href = '/alphabet/quiz'; }

onBeforeUnmount(() => {
    if (resetTimer) clearTimeout(resetTimer);
    if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
        window.speechSynthesis.cancel();
    }
});
</script>

<template>
    <Head title="Mengenal Alfabet" />

    <!-- HOME BUTTON -->
    <button
        type="button"
        class="alphabet-learning__home-button"
        aria-label="Kembali ke halaman utama"
        @click="goHome"
    >
        🏠
    </button>

    <div class="alphabet-page">
        <header class="alphabet-header">
            <h1>Mengenal Alfabet</h1>
            <p>Tekan huruf untuk mendengar cara membacanya</p>
        </header>

        <div class="alphabet-grid" role="list">
            <AlphabetCard
                v-for="letter in letters"
                :key="letter"
                :letter="letter"
                :is-active="activeLetter === letter"
                role="listitem"
                @click="handleLetterClick"
            />
        </div>

        <div class="alphabet-actions">
            <button type="button" class="alphabet-quiz-start" @click="goQuiz">
                Mulai Kuis 🎯
            </button>
        </div>

    </div>
</template>