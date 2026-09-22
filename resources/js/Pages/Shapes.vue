<script setup>

import { ref } from 'vue'

import ShapeCard from '@/Components/Shapes/ShapeCard.vue'
import ShapeDisplay from '@/Components/Shapes/ShapeDisplay.vue'


/*
|--------------------------------------------------------------------------
| DATA BENTUK
|--------------------------------------------------------------------------
*/

const shapes = [
    {
        id: 'circle',
        name: 'Lingkaran',
        emoji: '🔴',
    },

    {
        id: 'square',
        name: 'Persegi',
        emoji: '🟦',
    },

    {
        id: 'triangle',
        name: 'Segitiga',
        emoji: '🔺',
    },

    {
        id: 'rectangle',
        name: 'Persegi Panjang',
        emoji: '🟨',
    },

    {
        id: 'star',
        name: 'Bintang',
        emoji: '⭐',
    },

    {
        id: 'heart',
        name: 'Hati',
        emoji: '❤️',
    },
]


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

// Bentuk yang sedang dipilih
const currentShape = ref(shapes[0])


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
| PILIH BENTUK
|--------------------------------------------------------------------------
*/

function showShape(shape) {

    // Ganti bentuk aktif
    currentShape.value = shape


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
        `Ini adalah ${shape.name.toLowerCase()}! 🔷`
    )


    // Bacakan nama bentuk
    speak(shape.name)
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

    if (!('speechSynthesis' in window)) {
        return
    }


    // Hentikan suara sebelumnya
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


    // Kalau sedang berbicara → hentikan
    if (window.speechSynthesis.speaking) {

        window.speechSynthesis.cancel()

        return
    }


    // Bacakan bentuk yang sedang aktif
    speak(
        currentShape.value.name
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
        '/bentuk/quiz'
}

</script>


<template>

    <main class="shape-learning">


        <!-- =====================================================
             TOP
        ====================================================== -->

        <div class="shape-learning__top">


            <!-- HOME -->

            <button
                type="button"

                class="shape-learning__home-button"

                aria-label="Kembali ke halaman utama"

                @click="goHome"
            >

                🏠

            </button>


            <!-- TITLE -->

            <div class="shape-learning__title-area">

                <h1 class="shape-learning__title">

                    Yuk Mengenal Bentuk! 🔷

                </h1>


                <p class="shape-learning__subtitle">

                    Pilih bentuk dan dengarkan namanya.

                </p>

            </div>


            <!-- SPACER -->

            <div
                class="shape-learning__top-spacer"
                aria-hidden="true"
            >
            </div>


        </div>


        <!-- =====================================================
             DISPLAY
        ====================================================== -->

        <div ref="displayRef">

            <ShapeDisplay
                :shape="currentShape"
            />

        </div>


        <!-- =====================================================
             SPEAKER
        ====================================================== -->

        <button
            type="button"

            class="shape-learning__speaker-button"

            aria-label="Klik untuk mendengarkan suara"

            @click="toggleSpeaker"
        >

            <span class="shape-learning__speaker-icon">

                🔊

            </span>


            <span class="shape-learning__speaker-text">

                Klik untuk mendengarkan suara

            </span>

        </button>


        <!-- =====================================================
             HINT
        ====================================================== -->

        <p class="shape-learning__hint">

            Sentuh salah satu bentuk di bawah

        </p>


        <!-- =====================================================
             SHAPE CARDS
        ====================================================== -->

        <section class="shape-learning__list">


            <ShapeCard
                v-for="shape in shapes"

                :key="shape.id"

                :shape="shape"

                :active="
                    currentShape.id === shape.id
                "

                @select="showShape"
            />


        </section>


        <!-- =====================================================
             NEXT
        ====================================================== -->

        <button
            type="button"

            class="shape-learning__next-button"

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
            class="shape-learning__message"

            :class="{
                'shape-learning__message--show':
                    messageVisible
            }"

            aria-live="polite"
        >

            {{ message }}

        </div>


    </main>

</template> 