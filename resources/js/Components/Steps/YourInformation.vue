<template>
    <article>
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
import * as yup from "yup";
export default {
    name: 'YourInformation',
    components: {Field, ErrorMessage},
}
</script>
