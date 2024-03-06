<template>
    <div class="container">
        <div v-if="record">
            <div class="row">
                <div class="col">
                    <h2>{{ capitalizeFirstLetter(model) + " " + (isEdit ? "Update" : "Detail") }}</h2>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-info" @click="toggleEdit()">{{isEdit ? "Save" : "Edit"}}</button>
                </div>
            </div>
            <Info :record="record" v-if="!isEdit" />
            <Form :record="record" v-else />
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
import Form from "./Info.vue";
import {capitalizeFirstLetter} from "../utils";


export default {
    props: ['model', 'id'],
    components: {
        Info,
        Form
    },
    setup(props) {
        const recordToShow = ref(null);
        const recordToEdit = ref(null);
        const record = ref(null);
        const isEdit = ref(false);


        const fetchRecord = async () => {
            const response = await axios.get(`/api/${props.model}/${props.id}`);
            const obj = response.data.data;
            delete obj.manufacturer_id;
            record.value = obj;
        };

        onMounted(() => {
            fetchRecord();
        });

        const toggleEdit = () => {
            isEdit.value = !isEdit.value;
        }

        return {
            record,
            isEdit,
            toggleEdit,
            capitalizeFirstLetter
        };
    },
};
</script>
