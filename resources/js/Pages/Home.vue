<script setup>

function goToColors() {
    window.location.href = '/warna'
}

function goToAnimals() {
    window.location.href = '/hewan'
}

function goToBuildings() {
    window.location.href = '/bangunan'
}

function goToShapes() {
    window.location.href = '/bentuk'
}

</script>


<template>

    <main class="home">

        <section class="home__content">

            <div class="home__icon">
                🎮
            </div>

            <h1 class="home__title">
                Belajar & Bermain
            </h1>

            <p class="home__subtitle">
                Yuk belajar sambil bermain! 🌈
            </p>


            <div class="home__menus">

                <!-- WARNA -->

                <button
                    type="button"
                    class="home__menu home__menu--colors"
                    @click="goToColors"
                >

                    <div class="home__menu-icon">
                        🌈
                    </div>

                    <div class="home__menu-title">
                        Mengenal Warna
                    </div>

                    <div class="home__menu-description">
                        Yuk belajar berbagai warna!
                    </div>

                </button>


                <!-- HEWAN -->

                <button
                    type="button"
                    class="home__menu home__menu--animals"
                    @click="goToAnimals"
                >

                    <div class="home__menu-icon">
                        🐶
                    </div>

                    <div class="home__menu-title">
                        Mengenal Hewan
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali berbagai hewan!
                    </div>

                </button>


                <!-- BANGUNAN -->

                <button
                    type="button"
                    class="home__menu home__menu--buildings"
                    @click="goToBuildings"
                >

                    <div class="home__menu-icon">
                        🏢
                    </div>

                    <div class="home__menu-title">
                        Mengenal Bangunan
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali berbagai bangunan!
                    </div>

                </button>


                <!-- BENTUK -->

                <button
                    type="button"
                    class="home__menu home__menu--shapes"
                    @click="goToShapes"
                >

                    <div class="home__menu-icon">
                        🔷
                    </div>

                    <div class="home__menu-title">
                        Mengenal Bentuk
                    </div>

                    <div class="home__menu-description">
                        Yuk kenali berbagai bentuk!
                    </div>

                </button>

            </div>

        </section>

    </main>

</template>