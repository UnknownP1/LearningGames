<script setup>

import { ref } from 'vue'

import BuildingCard from '@/Components/Buildings/BuildingCard.vue'
import BuildingDisplay from '@/Components/Buildings/BuildingDisplay.vue'


/*
|--------------------------------------------------------------------------
| DATA BANGUNAN
|--------------------------------------------------------------------------
*/

const buildings = [
    {
        name: 'Rumah Sakit',
        emoji: '🏥',
    },

    {
        name: 'Kantor Polisi',
        emoji: '🚓',
    },

    {
        name: 'Kantor Pemadam Kebakaran',
        emoji: '🚒',
    },

    {
        name: 'Sekolah',
        emoji: '🏫',
    },

    {
        name: 'Perpustakaan',
        emoji: '📚',
    },

    {
        name: 'Bank',
        emoji: '🏦',
    },
]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const currentBuilding = ref(buildings[0])

const message = ref('')

let messageTimer = null


/*
|--------------------------------------------------------------------------
| PILIH BANGUNAN
|--------------------------------------------------------------------------
*/

function selectBuilding(building) {

    currentBuilding.value = building

    message.value = `Ini adalah ${building.name.toLowerCase()}.`

    clearTimeout(messageTimer)

    messageTimer = setTimeout(() => {
        message.value = ''
    }, 2500)

    speakBuilding(building)

}


/*
|--------------------------------------------------------------------------
| SPEECH
|--------------------------------------------------------------------------
*/

function speakBuilding(building) {

    if (!('speechSynthesis' in window)) {
        return
    }

    window.speechSynthesis.cancel()

    const speech = new SpeechSynthesisUtterance(
        building.name
    )

    speech.lang = 'id-ID'
    speech.rate = 0.8
    speech.pitch = 1.15

    window.speechSynthesis.speak(speech)

}


/*
|--------------------------------------------------------------------------
| ULANGI NAMA BANGUNAN
|--------------------------------------------------------------------------
*/

function repeatName() {

    speakBuilding(currentBuilding.value)

}


/*
|--------------------------------------------------------------------------
| NAVIGASI
|--------------------------------------------------------------------------
*/

function goHome() {

    window.location.href = '/'

}


function goToQuiz() {

    window.location.href = '/bangunan/quiz'

}

</script>


<template>

    <main class="building-learning">

        <!-- TOP -->

        <div class="building-learning__top">

            <!-- HOME -->

            <button
                type="button"
                class="building-learning__icon-button"
                aria-label="Kembali ke menu utama"
                @click="goHome"
            >
                🏠
            </button>


            <!-- TITLE -->

            <div class="building-learning__title">

                <h1>
                    Yuk Mengenal Bangunan! 🏢
                </h1>

                <p>
                    Pilih bangunan dan dengarkan namanya.
                </p>

            </div>

        </div>


        <!-- DISPLAY -->

        <BuildingDisplay
            :building="currentBuilding"
            :message="message"
        />


        <!-- SPEAKER -->

        <button
            type="button"
            class="building-learning__speaker"
            aria-label="Dengarkan nama bangunan"
            @click="repeatName"
        >
            🔊
        </button>


        <!-- BUILDING CARDS -->

        <div class="building-learning__cards">

            <BuildingCard
                v-for="building in buildings"
                :key="building.name"
                :building="building"
                @select="selectBuilding"
            />

        </div>


        <!-- QUIZ BUTTON -->

        <button
            type="button"
            class="building-learning__quiz-button"
            @click="goToQuiz"
        >
            <span>
                Mulai Quiz
            </span>

            <span>
                →
            </span>

        </button>

    </main>

</template>