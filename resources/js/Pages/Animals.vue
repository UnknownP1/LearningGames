<script setup>

import { ref } from 'vue'

import AnimalCard from '../Components/Animals/AnimalCard.vue'
import AnimalDisplay from '../Components/Animals/AnimalDisplay.vue'


/*
|--------------------------------------------------------------------------
| DATA HEWAN
|--------------------------------------------------------------------------
*/

const animals = [
    {
        id: 'cat',
        name: 'Kucing',
        emoji: '🐱',
    },

    {
        id: 'dog',
        name: 'Anjing',
        emoji: '🐶',
    },

    {
        id: 'rabbit',
        name: 'Kelinci',
        emoji: '🐰',
    },

    {
        id: 'cow',
        name: 'Sapi',
        emoji: '🐮',
    },

    {
        id: 'chicken',
        name: 'Ayam',
        emoji: '🐔',
    },

    {
        id: 'elephant',
        name: 'Gajah',
        emoji: '🐘',
    },
]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

// Hewan yang sedang dipilih
const currentAnimal = ref(animals[0])


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
| PILIH HEWAN
|--------------------------------------------------------------------------
*/

function showAnimal(animal) {

    // Ganti hewan aktif
    currentAnimal.value = animal


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
        `Ini adalah ${animal.name}! 🐾`
    )


    // Bacakan nama hewan
    speak(animal.name)
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


    // Bacakan hewan aktif
    speak(
        currentAnimal.value.name
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
        '/hewan/quiz'
}

</script>


<template>

    <main class="animal-learning">


        <!-- =====================================================
             TOP
        ====================================================== -->

        <div class="animal-learning__top">


            <!-- HOME -->

            <button
                type="button"

                class="animal-learning__home-button"

                aria-label="Kembali ke halaman utama"

                @click="goHome"
            >

                🏠

            </button>


            <!-- TITLE -->

            <div class="animal-learning__title-area">

                <h1 class="animal-learning__title">

                    Yuk Mengenal Hewan! 🐶

                </h1>


                <p class="animal-learning__subtitle">

                    Pilih hewan dan dengarkan namanya.

                </p>

            </div>


            <!-- SPACER -->

            <div
                class="animal-learning__top-spacer"
                aria-hidden="true"
            >
            </div>


        </div>


        <!-- =====================================================
             DISPLAY
        ====================================================== -->

        <div ref="displayRef">

            <AnimalDisplay
                :animal="currentAnimal"
            />

        </div>


        <!-- =====================================================
             SPEAKER
        ====================================================== -->

        <button
            type="button"

            class="animal-learning__speaker-button"

            aria-label="Klik untuk mendengarkan suara"

            @click="toggleSpeaker"
        >

            <span class="animal-learning__speaker-icon">

                🔊

            </span>


            <span class="animal-learning__speaker-text">

                Klik untuk mendengarkan suara

            </span>

        </button>


        <!-- =====================================================
             HINT
        ====================================================== -->

        <p class="animal-learning__hint">

            Sentuh salah satu hewan di bawah

        </p>


        <!-- =====================================================
             ANIMAL CARDS
        ====================================================== -->

        <section class="animal-learning__list">


            <AnimalCard
                v-for="animal in animals"

                :key="animal.id"

                :animal="animal"

                :active="
                    currentAnimal.id === animal.id
                "

                @select="showAnimal"
            />


        </section>


        <!-- =====================================================
             NEXT
        ====================================================== -->

        <button
            type="button"

            class="animal-learning__next-button"

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
            class="animal-learning__message"

            :class="{
                'animal-learning__message--show':
                    messageVisible
            }"

            aria-live="polite"
        >

            {{ message }}

        </div>


    </main>

</template>