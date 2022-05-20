<template>
    <form method="post" @submit.prevent="submit">
            <div class="bg-white">
                <div class="container mx-auto bg-white dark:bg-gray-800 rounded">
                    <div class="xl:w-full border-b border-gray-300 dark:border-gray-700 py-5 bg-white dark:bg-gray-800">
                        <div class="flex w-11/12 mx-auto xl:w-full xl:mx-0 items-center">
                            <p class="text-lg text-gray-800 dark:text-gray-100 font-bold">Profile</p>
                            <div class="ml-2 cursor-pointer text-gray-600 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                                    <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0v-4a1 1 0 0 1 1-1zm0-4a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" fill="currentColor" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mx-auto">
                            <div class="rounded relative mt-8 h-48">
                                <img src="https://cdn.tuk.dev/assets/webapp/forms/form_layouts/form1.jpg" alt="" class="w-full h-full object-cover rounded absolute shadow" />
                                <div class="absolute bg-black opacity-50 top-0 right-0 bottom-0 left-0 rounded"></div>
                                <div class="flex items-center px-3 py-2 rounded absolute right-0 mr-4 mt-4 cursor-pointer">
                                    <p class="text-xs text-gray-100">Change Cover Photo</p>
                                    <div class="ml-2 text-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                            <line x1="16" y1="5" x2="19" y2="8" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-20 h-20 rounded-full bg-cover bg-center bg-no-repeat absolute bottom-0 -mb-10 ml-12 shadow flex items-center justify-center">
                                    <img src="https://cdn.tuk.dev/assets/webapp/forms/form_layouts/form2.jpg" alt="" class="absolute z-0 h-full w-full object-cover rounded-full shadow top-0 left-0 bottom-0 right-0" />
                                    <div class="absolute bg-black opacity-50 top-0 right-0 bottom-0 left-0 rounded-full z-0"></div>
                                    <div class="cursor-pointer flex flex-col justify-center items-center z-10 text-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" />
                                            <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                            <line x1="16" y1="5" x2="19" y2="8" />
                                        </svg>
                                        <p class="text-xs text-gray-100">Edit Picture</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <ErrorsAndMessages :errors="errors" />
                <div class="container mx-auto bg-white dark:bg-gray-800 mt-10 rounded px-4">
                    <div class="xl:w-full border-b border-gray-300 dark:border-gray-700 py-5">
                        <div class="flex w-11/12 mx-auto xl:w-full xl:mx-0 items-center">
                            <p class="text-lg text-gray-800 dark:text-gray-100 font-bold">Personal Information</p>
                            <div class="ml-2 cursor-pointer text-gray-600 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                                    <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0v-4a1 1 0 0 1 1-1zm0-4a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" fill="currentColor" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mx-auto pt-4">
                        <div class="container mx-auto">
                            <div class="flex flex-wrap">
                                <div class="w-full lg:w-6/12 px-4 flex flex-col mb-6">
                                    <label for="name" class="pb-2 text-sm font-bold text-gray-800">Nom</label>
                                    <input tabindex="0" type="text" id="name" name="name" :value="user.name" required class="border border-gray-300 pl-3 py-3 shadow-sm bg-transparent rounded text-sm focus:outline-none focus:border-indigo-700 placeholder-gray-500 text-gray-600" placeholder="" />
                                </div>
                                <div class="w-full lg:w-6/12 px-4 flex flex-col mb-6">
                                    <label for="Email" class="pb-2 text-sm font-bold text-gray-800">Email</label>
                                    <div class="border border-gray-300 shadow-sm rounded flex">
                                        <div tabindex="0" class="focus:outline-none px-4 py-3 flex items-center border-r border-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                                <polyline points="3 7 12 13 21 7" />
                                            </svg>
                                        </div>
                                        <input tabindex="0" type="text" id="Email" name="email" :value="user.email" disabled class="pl-3 py-3 w-full border-gray-100 text-sm focus:outline-none placeholder-gray-500 rounded bg-transparent text-gray-600" />
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4 flex flex-col mb-6">
                                    <label for="phone_number" class="pb-2 text-sm font-bold text-gray-800 dark:text-gray-100">Numero de telephone</label>
                                    <input tabindex="0" type="number" id="phone_number" name="phone_number" v-model="form.phone_number" required class="border border-gray-300 pl-3 py-3 shadow-sm rounded bg-transparent text-sm focus:outline-none focus:border-indigo-700 placeholder-gray-500 text-gray-600"  />
                                </div>
                                <div class="w-full lg:w-6/12 px-4 flex flex-col mb-6">
                                    <label for="City" class="pb-2 text-sm font-bold text-gray-800 dark:text-gray-100">City</label>
                                    <input tabindex="0" type="text" id="City" name="city" v-model="form.city" required class="pl-3 py-3 w-full text-sm focus:outline-none border border-gray-300 focus:border-indigo-700 bg-transparent rounded placeholder-gray-500 text-gray-600" placeholder="Los Angeles" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mx-auto w-11/12 xl:w-full">
                    <div class="w-full py-4 sm:px-0 bg-white dark:bg-gray-800 flex justify-end">
                        <button class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 bg-blue-700 focus:outline-none transition duration-150 ease-in-out hover:bg-bleu-600 rounded text-white px-8 py-2 text-sm" type="submit">Enregistrer</button>
                    </div>
                </div>
            </div>
        </form>
</template>

<script setup>
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages";
import {reactive} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

let props = defineProps({
    user: Object,
    errors: Object
})

const form = reactive({
    name: null,
    phone_number: null,
    city: null,
    _token: usePage().props.value.csrf_token,
    _method: "PUT"
});

// retrieve post prop
const {name, profile, id } = usePage().props.value.user;
form.name = name;
form.phone_number = profile.phone_number;
form.city = profile.city;

const submit = () => {
    console.log(form)

    Inertia.post(route('user.update', {'user': id}), form, {
        forceFormData: true
    });
}

</script>

<style scoped>
.checkbox:checked {
    /* Apply class right-0*/
    right: 0;
}
.checkbox:checked + .toggle-label {
    /* Apply class bg-indigo-700 */
    background-color: #4c51bf;
}
</style>
