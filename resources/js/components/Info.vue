<template>
    <div class="row">
        <div class="col-6 p-4">
            <div class="row" v-for="(value, key ) in record" :key="key">
                <div class="col">{{ capitalizeFirstLetter(key) + ':' }}</div>
                <div class="col">{{ value ?? '-' }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import {capitalizeFirstLetter} from "../utils";
export default {
    props: {
        record: {
            type: Object,
            required: true,
        },
    },
    setup() {
        return {
            capitalizeFirstLetter,
        };
    },
};
</script>

