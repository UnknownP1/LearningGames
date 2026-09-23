<script setup>

import { ref, computed, onMounted } from 'vue'


/*
|--------------------------------------------------------------------------
| KONSTANTA
|--------------------------------------------------------------------------
*/

const NUMBERS = [
    { value: 0,  word: 'nol'      },
    { value: 1,  word: 'satu'     },
    { value: 2,  word: 'dua'      },
    { value: 3,  word: 'tiga'     },
    { value: 4,  word: 'empat'    },
    { value: 5,  word: 'lima'     },
    { value: 6,  word: 'enam'     },
    { value: 7,  word: 'tujuh'    },
    { value: 8,  word: 'delapan'  },
    { value: 9,  word: 'sembilan' },
    { value: 10, word: 'sepuluh'  },
]


/*
|--------------------------------------------------------------------------
| UTIL
|--------------------------------------------------------------------------
*/

function shuffle(array) {

    const a = [...array]

    for (let i = a.length - 1; i > 0; i--) {

        const j = Math.floor(
            Math.random() * (i + 1)
        )

        ;[a[i], a[j]] = [a[j], a[i]]

    }

    return a
}


/*
|--------------------------------------------------------------------------
| BUILD QUESTIONS
|--------------------------------------------------------------------------
*/

function buildQuestions() {

    const shuffled = shuffle(NUMBERS)

    return shuffled.map((correct) => {

        const others = NUMBERS.filter(
            (n) => n.value !== correct.value
        )

        const distractors = shuffle(others).slice(0, 3)

        return {
            answer: correct.word,
            value: correct.value,
            options: shuffle([
                correct.word,
                ...distractors.map((d) => d.word),
            ]),
        }

    })
}


/*
|--------------------------------------------------------------------------
| STATE
|--------------------------------------------------------------------------
*/

const questions = ref([])

const currentQuestionIndex = ref(0)

const selectedAnswer = ref('')

const answerStatus = ref('')

const quizFinished = ref(false)

const correctCount = ref(0)

const score = computed(() => {

    if (!questions.value.length) return 0

    return Math.round(
        (correctCount.value / questions.value.length) * 100
    )

})


/*
|--------------------------------------------------------------------------
| CURRENT QUESTION
|--------------------------------------------------------------------------
*/

function currentQuestion() {

    return questions.value[currentQuestionIndex.value]

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
| KEMBALI KE PEMBELAJARAN
|--------------------------------------------------------------------------
*/

function goToLearning() {

    window.location.href = '/angka'

}


/*
|--------------------------------------------------------------------------
| PILIH JAWABAN
|--------------------------------------------------------------------------
*/

function selectAnswer(answer) {

    if (selectedAnswer.value) {
        return
    }

    selectedAnswer.value = answer

    if (answer === currentQuestion().answer) {

        answerStatus.value = 'correct'

        correctCount.value++

    } else {

        answerStatus.value = 'wrong'

    }

}


/*
|--------------------------------------------------------------------------
| SOAL BERIKUTNYA
|--------------------------------------------------------------------------
*/

function nextQuestion() {

    if (
        currentQuestionIndex.value <
        questions.value.length - 1
    ) {

        currentQuestionIndex.value++

        selectedAnswer.value = ''

        answerStatus.value = ''

    } else {

        quizFinished.value = true

    }

}


/*
|--------------------------------------------------------------------------
| RESTART
|--------------------------------------------------------------------------
*/

function restartQuiz() {

    questions.value = buildQuestions()

    currentQuestionIndex.value = 0

    selectedAnswer.value = ''

    answerStatus.value = ''

    quizFinished.value = false

    correctCount.value = 0

}


/*
|--------------------------------------------------------------------------
| LIFECYCLE
|--------------------------------------------------------------------------
*/

onMounted(() => {

    questions.value = buildQuestions()

})

</script>


<template>

    <main class="number-quiz">


        <!-- =====================================================
             QUIZ
        ====================================================== -->

        <template v-if="!quizFinished && currentQuestion()">


            <!-- =================================================
                 TOP
            ================================================== -->

            <div class="number-quiz__top">


                <!-- HOME -->

                <button
                    type="button"

                    class="number-quiz__icon-button"

                    aria-label="Kembali ke menu utama"

                    @click="goHome"
                >

                    🏠

                </button>


                <!-- QUESTION NUMBER -->

                <div class="number-quiz__number">

                    Soal
                    {{ currentQuestionIndex + 1 }}
                    /
                    {{ questions.length }}

                </div>


            </div>


            <!-- =================================================
                 MAIN CARD
            ================================================== -->

            <section class="number-quiz__card">


                <!-- TITLE -->

                <h1 class="number-quiz__title">

                    Angka Apakah Ini? 🔢

                </h1>


                <!-- =================================================
                     NUMBER DISPLAY
                ================================================== -->

                <div class="number-quiz__display">

                    <div class="number-quiz__display-value">

                        {{ currentQuestion().value }}

                    </div>

                </div>


                <!-- =================================================
                     ANSWERS
                ================================================== -->

                <div class="number-quiz__answers">


                    <button
                        v-for="(
                            option,
                            index
                        ) in currentQuestion().options"

                        :key="option"

                        type="button"

                        class="number-quiz__answer"

                        :class="{

                            'number-quiz__answer--correct':
                                selectedAnswer &&
                                option ===
                                currentQuestion().answer,

                            'number-quiz__answer--wrong':
                                selectedAnswer === option &&
                                option !==
                                currentQuestion().answer

                        }"

                        :disabled="
                            !!selectedAnswer
                        "

                        @click="
                            selectAnswer(option)
                        "
                    >


                        <!-- LETTER A / B / C / D -->

                        <span
                            class="
                                number-quiz__answer-letter
                            "
                        >

                            {{
                                String.fromCharCode(
                                    65 + index
                                )
                            }}

                        </span>


                        <!-- ANSWER NAME -->

                        <span
                            class="
                                number-quiz__answer-name
                            "
                        >

                            {{ option }}

                        </span>


                    </button>


                </div>


                <!-- =================================================
                     FEEDBACK
                ================================================== -->

                <div
                    v-if="selectedAnswer"

                    class="number-quiz__feedback"

                    :class="{

                        'number-quiz__feedback--correct':
                            answerStatus === 'correct',

                        'number-quiz__feedback--wrong':
                            answerStatus === 'wrong'

                    }"
                >

                    <span
                        v-if="
                            answerStatus === 'correct'
                        "
                    >

                        🎉 Benar!

                    </span>


                    <span v-else>

                        😊 Belum tepat!

                    </span>

                </div>


                <!-- =================================================
                     NEXT
                ================================================== -->

                <button
                    v-if="selectedAnswer"

                    type="button"

                    class="number-quiz__next-button"

                    @click="nextQuestion"
                >

                    <span>

                        {{
                            currentQuestionIndex ===
                            questions.length - 1

                                ? 'Lihat Hasil'

                                : 'Soal Berikutnya'
                        }}

                    </span>


                    <span>

                        →

                    </span>

                </button>


            </section>


        </template>


        <!-- =====================================================
             FINISHED
        ====================================================== -->

        <section
            v-else

            class="number-quiz__finished"
        >


            <!-- ICON -->

            <div class="number-quiz__finished-icon">

                🎉

            </div>


            <!-- TITLE -->

            <h1>

                Quiz Selesai!

            </h1>


            <!-- SCORE -->

            <div class="number-quiz__score">

                ⭐ {{ score }} / 100

            </div>


            <!-- DESCRIPTION -->

            <p>

                Kamu berhasil menjawab
                {{ correctCount }}
                dari
                {{ questions.length }}
                soal dengan benar!

            </p>


            <!-- =================================================
                 FINISHED ACTIONS
            ================================================== -->

            <div class="number-quiz__finished-actions">


                <!-- RESTART -->

                <button
                    type="button"

                    class="number-quiz__finished-button"

                    @click="restartQuiz"
                >

                    <span>

                        🔁

                    </span>


                    <span>

                        Main Lagi

                    </span>

                </button>


                <!-- KEMBALI KE PEMBELAJARAN -->

                <button
                    type="button"

                    class="number-quiz__finished-button"

                    @click="goToLearning"
                >

                    <span>

                        Kembali ke Pembelajaran

                    </span>

                </button>


            </div>


        </section>


    </main>

</template>