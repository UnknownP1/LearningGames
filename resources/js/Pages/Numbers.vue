<script setup>

import { ref, onMounted, onBeforeUnmount } from 'vue'

import NumberCard from '../Components/Numbers/NumberCard.vue'
import NumberDisplay from '../Components/Numbers/NumberDisplay.vue'


/*
|--------------------------------------------------------------------------
| DATA ANGKA 0 - 10
|--------------------------------------------------------------------------
*/

const numbers = [
    { id: 'zero',    value: 0,  word: 'nol'      },
    { id: 'one',     value: 1,  word: 'satu'     },
    { id: 'two',     value: 2,  word: 'dua'      },
    { id: 'three',   value: 3,  word: 'tiga'     },
    { id: 'four',    value: 4,  word: 'empat'    },
    { id: 'five',    value: 5,  word: 'lima'     },
    { id: 'six',     value: 6,  word: 'enam'     },
    { id: 'seven',   value: 7,  word: 'tujuh'    },
    { id: 'eight',   value: 8,  word: 'delapan'  },
    { id: 'nine',    value: 9,  word: 'sembilan' },
    { id: 'ten',     value: 10, word: 'sepuluh'  },
]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const currentNumber = ref(numbers[0])

const message = ref('')

const messageVisible = ref(false)

const displayRef = ref(null)

let messageTimer = null

let indonesianVoice = null


/*
|--------------------------------------------------------------------------
| LOAD VOICES
|--------------------------------------------------------------------------
*/

function loadVoices() {

    if (
        typeof window === 'undefined' ||
        !('speechSynthesis' in window)
    ) {
        return
    }

    const voices = window.speechSynthesis.getVoices()

    if (!voices.length) {
        return
    }

    // Prioritas: id-ID → id-* (case-insensitive) → null
    indonesianVoice =
        voices.find((v) => v.lang === 'id-ID') ||
        voices.find((v) => v.lang.toLowerCase().startsWith('id')) ||
        null
}


/*
|--------------------------------------------------------------------------
| TEXT TO SPEECH
|--------------------------------------------------------------------------
*/

function speak(text) {

    if (
        typeof window === 'undefined' ||
        !('speechSynthesis' in window)
    ) {
        return
    }

    // Kalau voice belum ke-load, coba load dulu
    if (!indonesianVoice) {
        loadVoices()
    }

    window.speechSynthesis.cancel()

    const voice = new SpeechSynthesisUtterance(text)

    voice.lang = 'id-ID'

    voice.rate = 0.8

    voice.pitch = 1.15

    // Kalau ada voice Indonesia, kunci pakai voice itu
    if (indonesianVoice) {
        voice.voice = indonesianVoice
    }

    window.speechSynthesis.speak(voice)
}


/*
|--------------------------------------------------------------------------
| PILIH ANGKA
|--------------------------------------------------------------------------
*/

function showNumber(number) {

    currentNumber.value = number


    if (displayRef.value) {

        displayRef.value.animate(
            [
                { transform: 'scale(.96)' },
                { transform: 'scale(1.02)' },
                { transform: 'scale(1)' },
            ],
            {
                duration: 350,
                easing: 'ease-out',
            }
        )

    }


    showMessage(
        `Ini adalah angka ${number.word}! 🔢`
    )


    speak(number.word)
}


/*
|--------------------------------------------------------------------------
| MESSAGE
|--------------------------------------------------------------------------
*/

function showMessage(text) {

    message.value = text

    messageVisible.value = true

    clearTimeout(messageTimer)

    messageTimer = setTimeout(() => {

        messageVisible.value = false

    }, 1800)
}


/*
|--------------------------------------------------------------------------
| SPEAKER
|--------------------------------------------------------------------------
*/

function toggleSpeaker() {

    if (!('speechSynthesis' in window)) {
        return
    }

    if (window.speechSynthesis.speaking) {

        window.speechSynthesis.cancel()

        return
    }

    speak(currentNumber.value.word)
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

    window.location.href = '/angka/quiz'

}


/*
|--------------------------------------------------------------------------
| LIFECYCLE
|--------------------------------------------------------------------------
*/

onMounted(() => {

    if (
        typeof window !== 'undefined' &&
        'speechSynthesis' in window
    ) {
        window.speechSynthesis.onvoiceschanged = loadVoices

        loadVoices() // panggil sekali untuk keamanan
    }

})

onBeforeUnmount(() => {

    if (
        typeof window !== 'undefined' &&
        'speechSynthesis' in window
    ) {
        window.speechSynthesis.onvoiceschanged = null

        window.speechSynthesis.cancel()
    }

})

</script>


<template>

    <main class="number-learning">


        <!-- =====================================================
             TOP
        ====================================================== -->

        <div class="number-learning__top">


            <!-- HOME -->

            <button
                type="button"

                class="number-learning__home-button"

                aria-label="Kembali ke halaman utama"

                @click="goHome"
            >

                🏠

            </button>


            <!-- TITLE -->

            <div class="number-learning__title-area">

                <h1 class="number-learning__title">

                    Yuk Mengenal Angka! 🔢

                </h1>

                <p class="number-learning__subtitle">

                    Pilih angka dan dengarkan namanya.

                </p>

            </div>


            <!-- SPACER -->

            <div
                class="number-learning__top-spacer"
                aria-hidden="true"
            ></div>


        </div>


        <!-- =====================================================
             DISPLAY
        ====================================================== -->

        <div ref="displayRef">

            <NumberDisplay
                :number="currentNumber"
            />

        </div>


        <!-- =====================================================
             SPEAKER
        ====================================================== -->

        <button
            type="button"

            class="number-learning__speaker-button"

            aria-label="Klik untuk mendengarkan suara"

            @click="toggleSpeaker"
        >

            <span class="number-learning__speaker-icon">

                🔊

            </span>


            <span class="number-learning__speaker-text">

                Klik untuk mendengarkan suara

            </span>

        </button>


        <!-- =====================================================
             HINT
        ====================================================== -->

        <p class="number-learning__hint">

            Sentuh salah satu angka di bawah

        </p>


        <!-- =====================================================
             NUMBER CARDS
        ====================================================== -->

        <section class="number-learning__list">


            <NumberCard
                v-for="number in numbers"

                :key="number.id"

                :number="number"

                :active="
                    currentNumber.id === number.id
                "

                @select="showNumber"
            />


        </section>


        <!-- =====================================================
             NEXT
        ====================================================== -->

        <button
            type="button"

            class="number-learning__next-button"

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
            class="number-learning__message"

            :class="{
                'number-learning__message--show':
                    messageVisible
            }"

            aria-live="polite"
        >

            {{ message }}

        </div>


    </main>

</template>