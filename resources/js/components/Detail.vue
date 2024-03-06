<template>
    <div class="container">
        <div v-if="recordToShow">
            <div class="row">
                <div class="col">
                    <h2>{{ capitalizeFirstLetter(model) + " " + (isEdit ? "Update" : "Detail") }}</h2>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary" @click="handleClick()" :disabled="isSubmitting">{{isEdit ? "Save" : "Edit"}}</button>
                    <button type="button" class="btn btn-secondary mx-2" @click="handleCancel()" v-if="isEdit" :disabled="isSubmitting">Cancel</button>
                </div>
            </div>
            <Info :record="recordToShow" v-if="!isEdit" />
            <div v-else>
                <FormCar :record="recordToEdit" :isSubmitting="isSubmitting" :handleSubmit="handleEditRecord" v-if="model === 'car'"  />
                <FormManufacturer :record="recordToEdit" :isSubmitting="isSubmitting" :handleSubmit="handleEditRecord" v-if="model === 'manufacturer'"  />
            </div>

        </div>
        <div v-else>
            Loading...
        </div>
    </div>

</template>

<script>
import { ref, onMounted } from 'vue';
import axios from "axios";
import Info from "./Info.vue";
import FormCar from "../pages/car/Form.vue";
import FormManufacturer from "../pages/manufacturer/Form.vue";
import {capitalizeFirstLetter} from "../utils";
import {toast} from "vue3-toastify";

export default {
    props: ['model', 'id'],
    components: {
        Info,
        FormCar,
        FormManufacturer
    },
    setup(props) {
        let recordToShow = ref(null);
        let recordToEdit = ref(null);
        let isEdit = ref(false);
        let isSubmitting = ref(false);



        const fetchRecord = async () => {
            const response = await axios.get(`/api/${props.model}/${props.id}`);
            const obj = response.data.data;
            if (props.model === 'car') {
                recordToShow.value = {...obj};
                delete recordToShow.value.manufacturer_id;

                recordToEdit.value = {...obj};
            } else {
                recordToShow.value = recordToEdit.value = obj;
            }
        };

        const handleEditRecord = async (formData) => {
            try {
                await axios.put(`/api/${props.model}/${props.id}`, formData);
                isEdit.value = false;
                isSubmitting.value = false;

                await fetchRecord();
                toast("Updated successfully", {
                    autoClose: 1000,
                    type: 'success'
                });
            } catch (exception) {
                const message = exception.response.data.message;
                toast(message, {
                    autoClose: 1000,
                    type: 'error'
                });
            }
        };

        onMounted(() => {
            fetchRecord();
        });

        const handleClick = () => {
            if (!isEdit.value) {
                isEdit.value = true;
            } else {
                isSubmitting.value = true;
            }
        }

        const handleCancel = () => {
            isEdit.value = false;
            isSubmitting.value = false;
        }

        return {
            recordToEdit,
            recordToShow,
            isEdit,
            handleClick,
            capitalizeFirstLetter,
            handleEditRecord,
            isSubmitting,
            handleCancel
        };
    },
};
</script>
