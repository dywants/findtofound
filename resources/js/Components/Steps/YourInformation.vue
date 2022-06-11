<template>
    <div class="flex items-center mb-2">
        <Field type="checkbox" id="A3-yes" name="checkAnnonymary" v-model="checkAnnonymary"
               class="opacity-0 absolute h-8 w-8" />
        <div
            class="bg-white border-2 rounded-md border-blue-400 w-8 h-8 flex flex-shrink-0 justify-center items-center mr-2 focus-within:border-blue-500">
            <svg class="fill-current hidden w-3 h-3 text-blue-600 pointer-events-none" version="1.1"
                 viewBox="0 0 17 12" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(-9 -11)" fill="#1F73F1" fill-rule="nonzero">
                        <path
                            d="m25.576 11.414c0.56558 0.55188 0.56558 1.4439 0 1.9961l-9.404 9.176c-0.28213 0.27529-0.65247 0.41385-1.0228 0.41385-0.37034 0-0.74068-0.13855-1.0228-0.41385l-4.7019-4.588c-0.56584-0.55188-0.56584-1.4442 0-1.9961 0.56558-0.55214 1.4798-0.55214 2.0456 0l3.679 3.5899 8.3812-8.1779c0.56558-0.55214 1.4798-0.55214 2.0456 0z"/>
                    </g>
                </g>
            </svg>
        </div>
        <label for="A3-yes" class="select-none">Je veux etre Annonyme!</label>
    </div>
    <article v-if="!checkAnnonymary">
        <p class="text-['17px'] leading-loose text-gray-800 pt-4 ">Pas de soucis, bien vouloir avec precision indiquer
            le lieu où vous avez laissez la pièce retrouvée afin que le propriètaire puisse facilement la retrouver</p>
        <div class="mt-4">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Entrez le lieu où vous laissez la pièce</label>
            <Field id="message" name="localisation" as="textarea" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your message..."></Field>
        </div>
<!--        <div class="mt-4">-->
<!--            <AddressFields />-->
<!--        </div>-->
    </article>
    <article v-else>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="name">Votre Nom</label>
            <Field
                type="text"
                name="name"
                id="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 "
                placeholder="Votre nom"
            />
            <ErrorMessage name="name" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="email">Votre email</label>
            <Field type="email"
                   name="email"
                   id="email"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                      focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700"
                   placeholder="name@flowbite.com"
            />
            <ErrorMessage name="email" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="email">Votre ville de residence</label>
            <Field type="text"
                   name="city"
                   id="city"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 "
                   placeholder="Douala"
            />
            <ErrorMessage name="city" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="email">Votre numero de telephone</label>
            <Field type="number"
                   name="phone_number"
                   id="phone_number"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                      focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700"
                   placeholder="Votre numero de telephone"
            />
            <ErrorMessage name="phone_number" class="mt-2 text-sm text-red-600" />
        </div>
    </article>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";
import AddressFields from "@/Components/Elements/AddressFields"
export default {
    name: 'YourInformation',
    components: {Field, ErrorMessage},
    data(){
        return {
            checkAnnonymary: true
        }
    },
}
</script>
