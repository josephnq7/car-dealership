<template>
    <div class="row">
        <div class="col-6 p-4">
            <div class="col"><label for="name-text" class="form-label">Name: </label></div>
            <div class="col"><input type="text" id="name-text" class="form-control" aria-describedby="passwordHelpBlock"></div>

        </div>
    </div>
</template>

<script>
import {capitalizeFirstLetter} from "../../utils";

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
    setup() {
        return {
            capitalizeFirstLetter,
        };
    },
};
</script>

