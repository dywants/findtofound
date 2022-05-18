<template>
    <div role="alert" class="alert-banner" v-if="errors && Object.keys(errors).length > 0">
        <div class="bg-red-500 rounded-t px-4 py-2">
            <div class="flex items-center justify-between">
                <span class="text-white font-bold">Danger</span>
                <input type="checkbox" class="hidden" id="banneralert">

                <label class="close cursor-pointer flex items-center justify-between w-full p-2 bg-red-500 shadow text-white" title="close" for="banneralert">
                    <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </label>
            </div>
        </div>
        <ul class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
            <li v-for="error in errors">{{error}}</li>
        </ul>
    </div>

<!--    <div v-if="$page.props.flash.success" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">-->
<!--        <span class="font-medium">Success alert!</span>-->
<!--        {{$page.props.flash.success}}-->
<!--    </div>-->

    <div v-if="$page.props.flash.success" class="alert-toast fixed bottom-0 right-0 m-8 w-5/6 md:w-full max-w-sm">
        <input type="checkbox" class="hidden" id="footertoast">

        <label class="close cursor-pointer flex items-start justify-between w-full p-2 bg-green-500 h-20 rounded shadow-lg text-white" title="close" for="footertoast">
            {{$page.props.flash.success}}

            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
        </label>
    </div>


</template>

<script>
export default {
    name: "ErrorsAndMessages",
    props: ["errors"]
}
</script>

<style scoped>

</style>
