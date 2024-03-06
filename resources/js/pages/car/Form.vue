<template>
    <div class="row">
        <div class="col-6 p-4">
            <div class="col"><label for="name-text" class="form-label">Name </label></div>
            <div class="col"><input type="text" id="name-text" class="form-control" v-model="formData.name"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 p-4">
            <div class="col"><label for="name-text" class="form-label">Year </label></div>
            <div class="col"><input type="text" id="year-text" class="form-control" v-model="formData.year"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-6 p-4">
            <div class="col"><label class="form-label">Manufacturer </label></div>
            <select class="form-select" aria-label="Default select example" v-model="formData.manufacturer_id">
                <option :value="option.id" v-for="option in manufacturerOptions" :key="option.id">{{ option.name }}</option>
            </select>
        </div>
    </div>


</template>

<script>
import {capitalizeFirstLetter} from "../../utils";
import {onMounted, reactive, watch, ref} from "vue";
import axios from "axios";

export default {
    props: {
        record: {
            type: Object,
            required: true,
        },
        isSubmitting: {
            type: Boolean,
            required: true,
        },
        handleSubmit: {
            type: Function,
            required: true,
        }
    },
    setup(props) {
        let formData = reactive({
            name: props.record.name,
            year: props.record.year,
            manufacturer_id: props.record.manufacturer_id
        })

        const manufacturerOptions = ref([]);

        watch(() => props.isSubmitting, async () => {
            if (props.isSubmitting) {
                await props.handleSubmit(formData)
            }
        });

        const fetchOptions = async () => {
            const response = await axios.get(`/api/manufacturer`);
            manufacturerOptions.value = response.data.data
        };

        onMounted(() => {
            fetchOptions();
        });

        return {
            capitalizeFirstLetter,
            formData,
            manufacturerOptions
        };
    },
};
</script>

