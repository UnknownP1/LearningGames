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
        name: 'Kucing',
        emoji: '🐱',
    },

    {
        name: 'Anjing',
        emoji: '🐶',
    },

    {
        name: 'Kelinci',
        emoji: '🐰',
    },

    {
        name: 'Sapi',
        emoji: '🐮',
    },

    {
        name: 'Ayam',
        emoji: '🐔',
    },

    {
        name: 'Gajah',
        emoji: '🐘',
    },

]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const currentAnimal = ref(animals[0])

const message = ref('')

const messageVisible = ref(false)

const displayRef = ref(null)

let messageTimer = null


/*
|--------------------------------------------------------------------------
| PILIH HEWAN
|--------------------------------------------------------------------------
*/

function showAnimal(animal) {

    currentAnimal.value = animal


    /*
    |--------------------------------------------------------------------------
    | ANIMASI
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | PESAN
    |--------------------------------------------------------------------------
    */

    showMessage(
        `Ini ${animal.name}! 🐾`
    )


    /*
    |--------------------------------------------------------------------------
    | SUARA
    |--------------------------------------------------------------------------
    */

    speak(animal.name)

}


/*
|--------------------------------------------------------------------------
| PESAN
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
| TEXT TO SPEECH
|--------------------------------------------------------------------------
*/

function speak(text) {

    if (!('speechSynthesis' in window)) {
        return
    }


    window.speechSynthesis.cancel()


    const voice =
        new SpeechSynthesisUtterance(text)


    voice.lang = 'id-ID'

    voice.rate = 0.8

    voice.pitch = 1.15


    window.speechSynthesis.speak(voice)

}


/*
|--------------------------------------------------------------------------
| TOMBOL SPEAKER
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


    speak(currentAnimal.value.name)

}


/*
|--------------------------------------------------------------------------
| KEMBALI KE HOME
|--------------------------------------------------------------------------
*/

function goHome() {

    window.location.href = '/'

}


/*
|--------------------------------------------------------------------------
| KE QUIZ
|--------------------------------------------------------------------------
*/

function goToQuiz() {

    window.location.href = '/hewan/quiz'

}

</script>


<template>

    <main class="animal-game">


        <!-- TOP -->

        <div class="animal-game__top">


            <!-- HOME -->

            <button
                type="button"
                class="animal-game__icon-button"
                aria-label="Kembali ke halaman utama"
                @click="goHome"
            >
                🏠
            </button>


            <!-- SPEAKER -->

            <button
                type="button"
                class="animal-game__icon-button"
                aria-label="Dengarkan nama hewan"
                @click="toggleSpeaker"
            >
                🔊
            </button>


        </div>


        <!-- TITLE -->

        <h1 class="animal-game__title">
            Yuk Mengenal Hewan! 🐾
        </h1>


        <!-- SUBTITLE -->

        <p class="animal-game__subtitle">
            Pilih hewan dan dengarkan namanya.
        </p>


        <!-- DISPLAY -->

        <div ref="displayRef">

            <AnimalDisplay
                :animal="currentAnimal"
            />

        </div>


        <!-- HINT -->

        <p class="animal-game__hint">
            Sentuh salah satu hewan di bawah
        </p>


        <!-- DAFTAR HEWAN -->

        <div class="animal-game__animals">

            <AnimalCard
                v-for="animal in animals"
                :key="animal.name"
                :animal="animal"
                :active="
                    currentAnimal.name === animal.name
                "
                @select="showAnimal"
            />

        </div>


        <!-- NEXT -->

        <button
            type="button"
            class="animal-game__next-button"
            @click="goToQuiz"
        >

            <span>
                Selanjutnya
            </span>

            <span>
                →
            </span>

        </button>


        <!-- PESAN -->

        <div
            class="animal-game__message"
            :class="{
                'animal-game__message--show':
                    messageVisible
            }"
            aria-live="polite"
        >
            {{ message }}
        </div>


    </main>

</template>