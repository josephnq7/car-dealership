<template>
    <div class="row">
        <div class="col-6 p-4">
            <div class="col"><label for="name-text" class="form-label">Name </label></div>
            <div class="col"><input type="text" id="name-text" class="form-control" v-model="formData.name"></div>
        </div>
    </div>
</template>

<script>
import {capitalizeFirstLetter} from "../../utils";
import {reactive, ref, watch} from "vue";

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
        })

        watch(() => props.isSubmitting, async () => {
            if (props.isSubmitting) {
                await props.handleSubmit(formData)
            }
        });
        return {
            formData,
            capitalizeFirstLetter,
        };
    },
};
</script>

