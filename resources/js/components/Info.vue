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
export default {
    props: {
        record: {
            type: Object,
            required: true,
        },
    },
    setup() {

        const capitalizeFirstLetter = (str) => {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        return {
            capitalizeFirstLetter,
        };
    },
};
</script>

