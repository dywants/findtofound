<script>
import HeaderPage from "@/Layouts/HeaderPage";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
// import StepProgressBar from 'vue-steps-progress-bar'
import StepProgress from "vue-step-progress";
import 'vue-step-progress/dist/main.css';
import InforObject from "@/Components/Steps/InforObject";
import YourInformation from "@/Components/Steps/YourInformation";
import Validation from "@/Components/Steps/Validation";
import FormWizard from "@/Components/Elements/FormWizard";
import FormStep from "@/Components/Elements/FormStep";
import * as yup from "yup";

export default {
    name: "TheRegister",
    components: {
        FormStep,
        FormWizard,
        Validation,
        YourInformation,
        InforObject,
        HeaderPage,
        "v-loading": Loading,
        "v-step-progress": StepProgress,
    },
    computed: {
        isLoading() {
            return this.isLoadingRegisterPiece;
        },
        stepperProgress() {
            return ( 100 / 3 ) * ( this.currentStepIdx - 1 ) + '%'
        }
    },
    data() {
        return {
            isLoadingRegisterPiece: false,
            currentStepIdx: 1,
            piece: { type: "" },
            informationsPiece: [],
            fullPage: true,
            steps: [
                {
                    number:'1',
                    name:'Informations pièce retrouvée'
                },
                {
                    number:'2',
                    name:'Vos informations'
                },
                {
                    number:'3',
                    name:'Validations'
                },
            ],
            options: {
                maxWidth: '100%',
                nodeWidth: 40,
                nodeHeight: 40,
                barHeight: 3,
                showTooltip: true,
                showContent: true,

                // barType can be dashed or solid
                barType: 'dashed',

                // expects a function
                onNext: this.onNext,

                // expects a function
                onFinish: this.onFinish,

                nodes: [
                    {
                        content:'step 1',
                        tooltip:'sth about step 1'
                    },
                    {
                        content:'step 2',
                        tooltip:'sth about step 2'
                    },
                    {
                        content:'step 3',
                        tooltip:'sth about step 3'
                    },
                    {
                        content:'step 4',
                        tooltip:'sth about step 4'
                    }
                ]
            },
            errors: [],
        };
    },
    methods: {
        childMessageValidation(validationSchema){
            this.errors = validationSchema
        }
    },
    setup(){
        function onSubmit(formData) {
            console.log(JSON.stringify(formData, null, 2));
        }
        const validationSchema = [
            yup.object({
                fullName: yup.string().required().label("Nom complèt"),
                findCity: yup.string().required().label("Ville"),
                piece_id: yup.number().required().label("Nature de l'objet"),
                photos: yup.string().required().label("photos"),
            }),
            yup.object({
                name: yup.string().required().label("Votre nom"),
                email: yup.string().required().label("email"),
                phone_number: yup.number().required().label("phone_number"),
            }),
            yup.object({
                amount_check: yup.boolean().required(),
            }),
        ];
        return {
            validationSchema,
            onSubmit,
        };
    }
}

</script>
<template>
    <Head title="Enregister pièce"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Enregistrer une pièce retrouvée
            </h2>
        </template>
    </HeaderPage>

    <div class="max-w-screen-xl p-4 mx-auto mt-8">
        <nav>
            <h2 class="sr-only">Steps</h2>

            <div class="w-full">
                <ol class="flex items-center justify-between space-x-12 text-xs font-medium text-gray-500 sm:space-x-4 w-full relative">
                    <li :class="{ 'current': currentStepIdx == item, 'success': currentStepIdx > item }"
                        class="flex items-center flex-col space-y-2"
                        v-for="item in steps" :key="item">
                        <span class="leading-6 w-10 h-10 rounded-full text-[14px] font-bold flex items-center justify-center bg-blue-50">{{ item.number }}</span>
                        <span
                            class="leading-6 w-10 h-10 rounded-full text-[14px] font-bold flex items-center justify-center text-green-600 rounded bg-green-50">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 20 20"
                                fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                           </svg>
                        </span>
                        <span class="ml-2">{{ item.name }}</span>
                    </li>
                    <li class="stepper-progress">
                        <span :style="'width:' + stepperProgress " class="stepper-progress-bar"></span>
                    </li>
                </ol>
            </div>
        </nav>

        <div class="is-clearfix mb-3">
<!--            <v-step-progress :steps="['Informations de la pièce', 'Vos informations', 'Validation']"-->
<!--                             :current-step="step" icon-class="fa fa-check" />-->
           <FormWizard :validation-schema="validationSchema" @submit="onSubmit">
               <FormStep>
                   <template #header>Entrez les informations de la pièce </template>
                   <InforObject @errorsValidations="childMessageValidation" />
               </FormStep>

               <FormStep>
                   <template #header>VOS INFORMATIONS PERSONNELLES</template>
                   <YourInformation />
               </FormStep>

               <FormStep>
                   <template #header>Validation</template>
                   <Validation />
               </FormStep>

           </FormWizard>
        </div>
        <v-loading :active.sync="isLoading" :is-full-page="fullPage" />
    </div>
</template>

<style scoped>
.stepper-progress {
    position: absolute;
    background-color: #C5C5C5;
    height: 2px;
    width: 90%;
    z-index: -1;
    top: 20px;
    left: 55px;
    right: 0;
    /*margin: 0 auto;*/
}

.stepper-progress-bar {
    position: absolute;
    left: 0;
    height: 100%;
    width: 0%;
    background-color: #75CC65;
    transition: all 500ms ease;
}

.icon-success{
    opacity: 1;
    transform: scale(1);
}
</style>
