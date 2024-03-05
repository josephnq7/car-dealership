<template>
    <table class="table" v-if="manufacturers.length > 0">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="manufacturer in manufacturers" :key="manufacturer.id">
            <th scope="row">{{manufacturer.id}}</th>
            <td>{{manufacturer.name}}</td>
            <td>
                <i class="bi bi-eye p-2 icon-pointer"></i>
                <i class="bi bi-pencil-square p-2 icon-pointer"></i>
                <i class="bi bi-trash p-2 icon-pointer"></i>
            </td>
        </tr>
        </tbody>
    </table>
    <div v-else>No Car</div>
</template>

<script setup>
    import {onMounted, ref} from "vue";
    import axios from "axios";

    let manufacturers = ref([]);

    const getManufacturers = async () => {
        let response = await axios.get('/api/manufacturer')
        manufacturers.value = response.data.data;
    }

    onMounted(async () => {
        await getManufacturers()
    });
</script>
