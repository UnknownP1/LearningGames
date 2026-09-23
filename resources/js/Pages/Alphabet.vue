<script setup>

import { ref, onBeforeUnmount } from 'vue'
import { Head } from '@inertiajs/vue3'

import AlphabetCard from '@/Components/Alphabets/AlphabetCard.vue'


/*
|--------------------------------------------------------------------------
| DATA HURUF
|--------------------------------------------------------------------------
*/

const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('')

const LETTER_SPEECH = {
    A: 'a',                C: 'ce',   D: 'de',
    E: 'e',    F: 'ef',   G: 'ge',   H: 'ha',
    I: 'iii',  J: 'je',   K: 'ka',   L: 'el',
    M: 'em',   N: 'en',   O: 'o',
    Q: 'kiu',  R: 'er',   S: 'es',   T: 'te',
    U: 'u',    V: 've',              X: 'eks',
    Y: 'ye',   Z: 'zet',
}


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const activeLetter = ref(null)

let resetTimer = null

let indonesianVoice = null


/*
|--------------------------------------------------------------------------
| VOICE
|--------------------------------------------------------------------------
*/

function loadVoices() {
    if (typeof window === 'undefined') return
    if (!('speechSynthesis' in window)) return

    const voices = window.speechSynthesis.getVoices()
    if (!voices.length) return

    indonesianVoice =
        voices.find((v) => v.lang === 'id-ID') ||
        voices.find((v) => v.lang.toLowerCase().startsWith('id')) ||
        null
}

function speak(letter) {
    if (typeof window === 'undefined') return
    if (!('speechSynthesis' in window)) return

    if (!indonesianVoice) loadVoices()

    window.speechSynthesis.cancel()

    const spoken = LETTER_SPEECH[letter] || letter

    const utterance = new SpeechSynthesisUtterance(spoken)

    utterance.lang = 'id-ID'
    utterance.rate = 0.85
    utterance.pitch = 1.1
    utterance.volume = 1.0

    if (indonesianVoice) utterance.voice = indonesianVoice

    window.speechSynthesis.speak(utterance)
}


/*
|--------------------------------------------------------------------------
| HANDLER
|--------------------------------------------------------------------------
*/

function handleLetterClick(letter) {
    activeLetter.value = letter

    speak(letter)

    if (resetTimer) clearTimeout(resetTimer)

    resetTimer = setTimeout(() => {
        if (activeLetter.value === letter) activeLetter.value = null
    }, 700)
}

function goHome() {
    window.location.href = '/'
}

function goQuiz() {
    window.location.href = '/alphabet/quiz'
}


/*
|--------------------------------------------------------------------------
| LIFECYCLE
|--------------------------------------------------------------------------
*/

if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
    window.speechSynthesis.onvoiceschanged = loadVoices
    loadVoices()
}

onBeforeUnmount(() => {
    if (resetTimer) clearTimeout(resetTimer)

    if (typeof window !== 'undefined' && 'speechSynthesis' in window) {
        window.speechSynthesis.onvoiceschanged = null
        window.speechSynthesis.cancel()
    }
})

</script>


<template>

    <Head title="Mengenal Alfabet" />

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

            <button
                type="button"
                class="alphabet-quiz-start"
                @click="goQuiz"
            >
                Mulai Kuis 🎯
            </button>

        </div>

    </div>

</template>