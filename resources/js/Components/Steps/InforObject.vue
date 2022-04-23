<template>
    <article>
        <div class="mb-6">
            <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nom
                proprietaire</label>
            <Field type="text" id="fullName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                   placeholder="John DOE" name="fullName" />
            <ErrorMessage name="fullName" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label for="piece_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nature de l'objet</label>
            <Field id="piece_id" name="piece_id" as="select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="1">CNI</option>
                <option value="1">Password</option>
                <option value="1">Permis de conduire</option>
                <option value="1">Acte de naissance</option>
                <option value="1">Diplôme</option>
            </Field>
            <ErrorMessage name="piece_id" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label for="findCity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ville où la pièce est trouvée</label>
            <Field type="text" id="findCity" name="findCity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                   placeholder="Douala" />
            <ErrorMessage name="findCity" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label for="ward"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Quartier</label>
            <Field type="text" id="ward" name="ward"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "/>
            <ErrorMessage name="ward" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="photos">Upload image pièce perdué</label>
            <Field
                class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent"
                aria-describedby="user_avatar_help" name="photos" id="photos" type="file" />
            <ErrorMessage name="photos" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Details supplementaire</label>
            <textarea id="message" rows="4"
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 "
                      placeholder="Pièce retrouvée dans ..."></textarea>
        </div>
    </article>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
export default {
    name: "InforObject",
    components: {Field, ErrorMessage},
}
</script>

<style scoped>

</style>
