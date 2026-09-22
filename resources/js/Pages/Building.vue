<script setup>

import { ref } from 'vue'

import BuildingCard from '../Components/Buildings/BuildingCard.vue'
import BuildingDisplay from '../Components/Buildings/BuildingDisplay.vue'


/*
|--------------------------------------------------------------------------
| DATA BANGUNAN
|--------------------------------------------------------------------------
*/

const buildings = [
    {
        id: 'hospital',
        name: 'Rumah Sakit',
        emoji: '🏥',
        image: '',
    },

    {
        id: 'police',
        name: 'Kantor Polisi',
        emoji: '🚓',
        image: '/images/PoliceStation.png',
    },

    {
        id: 'fireStation',
        name: 'Kantor Pemadam Kebakaran',
        emoji: '🚒',
        image: '/images/FireStation.png',
    },

    {
        id: 'school',
        name: 'Sekolah',
        emoji: '🏫',
        image: '',
    },

    {
        id: 'library',
        name: 'Perpustakaan',
        emoji: '📚',
        image: '/images/Library.png',
    },

    {
        id: 'bank',
        name: 'Bank',
        emoji: '🏦',
        image: '',
    },
]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const currentBuilding = ref(buildings[0])

const message = ref('')

const messageVisible = ref(false)

const displayRef = ref(null)

let messageTimer = null


/*
|--------------------------------------------------------------------------
| PILIH BANGUNAN
|--------------------------------------------------------------------------
*/

function showBuilding(building) {

    currentBuilding.value = building


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


    showMessage(
        `Ini adalah ${building.name}! 🏢`
    )


    speak(building.name)
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


    speak(
        currentBuilding.value.name
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
        '/bangunan/quiz'

}

</script>


<template>

    <main class="building-learning">


        <!-- =====================================================
             TOP
        ====================================================== -->

        <div class="building-learning__top">


            <!-- HOME -->

            <button
                type="button"

                class="building-learning__home-button"

                aria-label="Kembali ke halaman utama"

                @click="goHome"
            >

                🏠

            </button>


            <!-- TITLE -->

            <div class="building-learning__title-area">

                <h1 class="building-learning__title">

                    Yuk Mengenal Bangunan! 🏢

                </h1>


                <p class="building-learning__subtitle">

                    Pilih bangunan dan dengarkan namanya.

                </p>

            </div>


            <!-- SPACER -->

            <div
                class="building-learning__top-spacer"
                aria-hidden="true"
            >
            </div>


        </div>


        <!-- =====================================================
             DISPLAY
        ====================================================== -->

        <div ref="displayRef">

            <BuildingDisplay
                :building="currentBuilding"
            />

        </div>


        <!-- =====================================================
             SPEAKER
        ====================================================== -->

        <button
            type="button"

            class="building-learning__speaker-button"

            aria-label="Klik untuk mendengarkan suara"

            @click="toggleSpeaker"
        >

            <span class="building-learning__speaker-icon">

                🔊

            </span>


            <span class="building-learning__speaker-text">

                Klik untuk mendengarkan suara

            </span>

        </button>


        <!-- =====================================================
             HINT
        ====================================================== -->

        <p class="building-learning__hint">

            Sentuh salah satu bangunan di bawah

        </p>


        <!-- =====================================================
             BUILDING CARDS
        ====================================================== -->

        <section class="building-learning__list">


            <BuildingCard
                v-for="building in buildings"

                :key="building.id"

                :building="building"

                :active="
                    currentBuilding.id === building.id
                "

                @select="showBuilding"
            />


        </section>


        <!-- =====================================================
             NEXT
        ====================================================== -->

        <button
            type="button"

            class="building-learning__next-button"

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
            class="building-learning__message"

            :class="{
                'building-learning__message--show':
                    messageVisible
            }"

            aria-live="polite"
        >

            {{ message }}

        </div>


    </main>

</template>