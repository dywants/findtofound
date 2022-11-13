<template>
    <article>
        <div class="mb-6">
            <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nom
                proprietaire</label>
            <Field type="text" id="fullName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                   placeholder="John DOE" name="fullName" />
            <ErrorMessage name="fullName" class="mt-2 text-sm text-red-600" />
            <div v-if="$page.props.errors.fullName" class="mt-2 text-sm text-red-600" >$page.props.errors.fullName</div>
        </div>
        <div class="mb-6">
            <label for="piece_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nature de l'objet</label>
            <Field @change="onChange($event)" id="piece_id" name="piece_id" as="select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option v-for="piece in pieces" :key="piece.id" :value="piece.id" >{{ piece.name}}</option>
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
            <Field class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer p-4 focus:outline-none focus:border-transparent"
                   ref="photos" name="photos"
                   type="file" enctype="multipart/form-data"
                   multiple
                   accept="image/*"
                   @change="onFileChange"
            />
            <div class="flex items-center gap-4">
                <img v-for="url in imgUrl" class="w-64 mt-4 h-64 rounded" :src="url"/>
            </div>
            <ErrorMessage name="photos" class="mt-2 text-sm text-red-600" />
        </div>
        <div class="mb-6">
            <label for="details" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Details supplementaire</label>
            <Field id="details" as="textarea" rows="4" name="details"
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 "
                      placeholder="Pièce retrouvée dans ...">
            </Field>
        </div>
    </article>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";
export default {
    name: "InforObject",
    components: {Field, ErrorMessage},
    props: ['pieces', 'amount'],
    data() {
        return {
            url: null,
            photos: [],
            imgUrl: []
        }
    },
     methods: {
         onChange(){
             let pieceId = event.target.value;

             const pieceSelect = this.pieces.find(piece => piece.id == pieceId)

             this.$emit("amount", pieceSelect.amount)
         },
         previewImage(e) {
             const file = e.target.files[0];
             this.url = URL.createObjectURL(file);
         },
         onFileChange(e) {
             let vm = this;
             let selectedFiles = e.target.files;

             for (let i = 0; i < selectedFiles.length; i++) {
                 this.photos.push(selectedFiles[i]);
                 this.imgUrl.push(URL.createObjectURL(selectedFiles[i]))
             }

             for (let i = 0; i < this.photos.length; i++) {
                 let reader = new FileReader();
                 reader.onload = (e) => {
                     this.$refs.photo[i].src = reader.result;

                     console.log(this.$refs.photo[i].src);
                 };

                 reader.readAsDataURL(this.photos[i]);
             }
         }
     }
}
</script>

<style scoped>

</style>
