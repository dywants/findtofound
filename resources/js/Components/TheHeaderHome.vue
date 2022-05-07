<template>
    <section class="text-blueGray-700 bg-white">
        <div class="container flex flex-col items-center px-5 py-8 mx-auto  md:flex-row lg:px-28">
            <div class="flex flex-col items-start w-full pt-0 mb-16 text-left  lg:flex-grow md:w-1/2 xl:mr-20 md:pr-24 md:mb-0">
                <h1 class="mb-8 text-2xl font-black tracking-tighter text-black  md:text-5xl title-font"> Medium length display headline. </h1>
                <p class="mb-8 text-base leading-relaxed text-left text-blueGray-600"> Deploy your mvp in minutes, not days. WT offers you a a wide selection swapable sections for your landing page. </p>
                <div class="flex flex-wrap gap-4 mt-8 text-center">
                    <a class="block w-full px-12 py-3 text-sm font-medium text-white rounded shadow bg-rose-600 sm:w-auto active:bg-rose-500 hover:bg-rose-700 focus:outline-none focus:ring"
                       href="/get-started">
                        Get Started
                    </a>

                    <a class="block w-full px-12 py-3 text-sm font-medium bg-white rounded shadow text-rose-600 sm:w-auto hover:text-rose-700 active:text-rose-500 focus:outline-none focus:ring"
                       href="/about">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="w-full lg:w-5/6 lg:max-w-lg md:w-1/2">
                <img class="object-cover object-center rounded-lg" alt="hero" src="https://dummyimage.com/720x600/F3F4F7/8693ac">
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: "TheHeaderHome"
}
</script>

<style scoped>

</style>
