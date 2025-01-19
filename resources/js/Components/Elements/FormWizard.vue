<template>
    <form @submit="onSubmit">
        <TheCard>
            <template #body>
                <slot/>
            </template>

            <template #footer>
                <div class="flex items-center space-x-3">
                    <Button v-if="hasPrevious" type="button" @click="goToPrev">
                        Precedent
                    </Button>
                    <Button type="submit">{{ isLastStep ? "Soumettre" : "Suivant" }}</Button>
                </div>
            </template>
        </TheCard>
    </form>
</template>

<script>
import { useForm } from "vee-validate";
import { ref, computed, provide, watch } from "vue";
import TheCard from "@/Components/Elements/TheCard";
import Button from "@/Components/Button";

export default {
    name: "FormWizard",
    components: { Button, TheCard },
    emits: ["next", "submit", "CURRENT_STEP"],
    props: {
        validationSchema: {
            type: Array,
            required: true,
        },
    },
    setup(props, { emit }) {
        const formData = ref({});
        const currentStepIdx = ref(0);

        // Injects the starting step, child <form-steps> will use this to generate their ids
        const stepCounter = ref(0);
        provide("STEP_COUNTER", stepCounter);
        // Inject the live ref of the current index to child components
        // will be used to toggle each form-step visibility
        provide("CURRENT_STEP_INDEX", currentStepIdx);

        // Émettre l'événement à chaque changement d'étape
        watch(currentStepIdx, (newVal) => {
            emit('CURRENT_STEP', newVal);
        }, { immediate: true });

        const currentIdx = computed(() => {
            return currentStepIdx.value;
        });

        // if this is the last step
        const isLastStep = computed(() => {
            return currentStepIdx.value === stepCounter.value - 1;
        });

        // If the `previous` button should appear
        const hasPrevious = computed(() => {
            return currentStepIdx.value > 0;
        });

        // extracts the indivdual step schema
        const currentSchema = computed(() => {
            return props.validationSchema[currentStepIdx.value];
        });

        // vee-validate will be aware of computed schema changes
        const { resetForm, handleSubmit } = useForm({
            validationSchema: currentSchema,
        });

        // We are using the "submit" handler to progress to next steps
        // and to submit the form if its the last step
        // parent can opt to listen to either events if interested
        const onSubmit = handleSubmit((values) => {
            formData.value = {
                ...formData.value,
                ...values,
            };

            // Sets initial values for the values already filled
            // effectively fills the inputs when clicking on "previous"
            resetForm({
                values: {
                    ...formData.value,
                },
            });

            if (!isLastStep.value) {
                currentStepIdx.value++;
                emit("next", formData.value);

                return;
            }

            emit("submit", formData.value);
        });

        function uploadImage() {
            let formData  = new FormData();
            formData.append('photos', formData.photos)
        }

        function goToPrev() {
            if (currentStepIdx.value === 0) {
                return;
            }

            currentStepIdx.value--;

            resetForm({
                values: {
                    ...formData.value,
                },
            });
        }

        return {
            onSubmit,
            hasPrevious,
            isLastStep,
            goToPrev,
            uploadImage,
            currentIdx,
        };
    },
};
</script>


<style>
/*.container{*/
/*    text-align: center;*/

/*}*/
.progress-container{
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 30px;
    max-width: 100%;
    width: 300px;

}
.progress-container::before{
    content: '';
    background-color: #efefef;
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    height: 4px;
    width: 100%;
    z-index: -1;

}
.progress{
    background-color: #3498db;
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    height: 4px;
    width: 00%;
    z-index: -1;
    transition: 0.4s ease;
}
.circle{
    background-color: #fff;
    color: #999;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #efefef;

    transition: 0.4s ease;
}
.circle.active{
    border-color: #3498db;
}
.btn{
    background-color: #3498db;
    color: white;
    border: 0;
    border-radius: 6px;
    cursor: pointer;
    padding: 8px 30px;
    margin: 5px;
    font-size: 14px;
}
.btn:disabled{
    background-color: #999;
    cursor: not-allowed;

}
.btn:focus{
    outline: 0 ;
}
.btn.active{
    transform: scale(0.98);
}

</style>
