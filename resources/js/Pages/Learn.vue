<script setup>

import { ref } from 'vue'

import ColorCard from '../Components/Colors/ColorCard.vue'
import ColorDisplay from '../Components/Colors/ColorDisplay.vue'


/*
|--------------------------------------------------------------------------
| DATA WARNA
|--------------------------------------------------------------------------
*/

const colors = [
    {
        name: 'Merah',
        hex: '#ef3b3b',
    },

    {
        name: 'Biru',
        hex: '#3199e8',
    },

    {
        name: 'Kuning',
        hex: '#ffd22e',
    },

    {
        name: 'Hijau',
        hex: '#45b94b',
    },

    {
        name: 'Ungu',
        hex: '#9a55d5',
    },

    {
        name: 'Pink',
        hex: '#f36fa5',
    },
]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

// Warna yang sedang dipilih
const currentColor = ref(colors[0])


// Pesan
const message = ref('')


// Status pesan
const messageVisible = ref(false)


// Referensi display
const displayRef = ref(null)


// Timer pesan
let messageTimer = null


/*
|--------------------------------------------------------------------------
| PILIH WARNA
|--------------------------------------------------------------------------
*/

function showColor(color) {

    // Ganti warna aktif
    currentColor.value = color


    // Animasi display
    if (displayRef.value) {

        displayRef.value.animate(
            [
                {
                    transform: 'scale(.96)',
                },

                {
                    transform: 'scale(1.02)',
                },

                {
                    transform: 'scale(1)',
                },
            ],
            {
                duration: 350,
                easing: 'ease-out',
            }
        )

    }


    // Tampilkan pesan
    showMessage(
        `Ini warna ${color.name}! 🌈`
    )


    // Bacakan nama warna
    speak(color.name)
}


/*
|--------------------------------------------------------------------------
| MESSAGE
|--------------------------------------------------------------------------
*/

function showMessage(text) {

    message.value = text

    messageVisible.value = true


    // Hapus timer sebelumnya
    clearTimeout(messageTimer)


    // Hilangkan setelah 1.8 detik
    messageTimer = setTimeout(() => {

        messageVisible.value = false

    }, 1800)
}


/*
|--------------------------------------------------------------------------
| TEXT TO SPEECH
|--------------------------------------------------------------------------
*/

function speak(text) {

    // Cek dukungan browser
    if (!('speechSynthesis' in window)) {
        return
    }


    // Hentikan suara sebelumnya
    window.speechSynthesis.cancel()


    // Buat suara
    const voice =
        new SpeechSynthesisUtterance(text)


    // Bahasa Indonesia
    voice.lang = 'id-ID'


    // Kecepatan suara
    voice.rate = 0.8


    // Tinggi suara
    voice.pitch = 1.15


    // Jalankan suara
    window.speechSynthesis.speak(voice)
}


/*
|--------------------------------------------------------------------------
| SPEAKER
|--------------------------------------------------------------------------
*/

function toggleSpeaker() {

    // Cek dukungan browser
    if (!('speechSynthesis' in window)) {
        return
    }


    // Kalau sedang berbicara → hentikan
    if (window.speechSynthesis.speaking) {

        window.speechSynthesis.cancel()

        return
    }


    // Bacakan warna aktif
    speak(
        currentColor.value.name
    )
}


/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

function goHome() {

    window.location.href = '/'
}


/*
|--------------------------------------------------------------------------
| QUIZ
|--------------------------------------------------------------------------
*/

function goToQuiz() {

    window.location.href =
        '/warna/quiz'
}

</script>


<template>

    <main class="color-game">


        <!-- =====================================================
             TOP
        ====================================================== -->

        <div class="color-game__top">


            <!-- HOME -->

            <button
                type="button"

                class="color-game__icon-button"

                aria-label="Kembali ke halaman utama"

                @click="goHome"
            >

                🏠

            </button>


            <!-- SPACER -->

            <div
                class="color-game__top-spacer"
                aria-hidden="true"
            >
            </div>


        </div>


        <!-- =====================================================
             TITLE
        ====================================================== -->

        <h1 class="color-game__title">

            Yuk Mengenal Warna! 🌈

        </h1>


        <!-- =====================================================
             SUBTITLE
        ====================================================== -->

        <p class="color-game__subtitle">

            Pilih warna dan dengarkan namanya.

        </p>


        <!-- =====================================================
             DISPLAY
        ====================================================== -->

        <div ref="displayRef">

            <ColorDisplay
                :color="currentColor"
            />

        </div>


        <!-- =====================================================
             SPEAKER
        ====================================================== -->

        <button
            type="button"

            class="color-game__speaker-button"

            aria-label="Klik untuk mendengarkan suara"

            @click="toggleSpeaker"
        >

            <span class="color-game__speaker-icon">

                🔊

            </span>


            <span class="color-game__speaker-text">

                Klik untuk mendengarkan suara

            </span>

        </button>


        <!-- =====================================================
             HINT
        ====================================================== -->

        <p class="color-game__hint">

            Sentuh salah satu warna di bawah

        </p>


        <!-- =====================================================
             COLOR CARDS
        ====================================================== -->

        <div class="color-game__colors">


            <ColorCard
                v-for="color in colors"

                :key="color.name"

                :color="color"

                :active="
                    currentColor.name === color.name
                "

                @select="showColor"
            />


        </div>


        <!-- =====================================================
             NEXT
        ====================================================== -->

        <button
            type="button"

            class="color-game__next-button"

            @click="goToQuiz"
        >

            <span>

                Selanjutnya

            </span>


            <span>

                →

            </span>

        </button>


        <!-- =====================================================
             MESSAGE
        ====================================================== -->

        <div
            class="color-game__message"

            :class="{
                'color-game__message--show':
                    messageVisible
            }"

            aria-live="polite"
        >

            {{ message }}

        </div>


    </main>

</template>