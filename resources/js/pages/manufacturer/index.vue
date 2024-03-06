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
                <i class="bi bi-eye p-2 icon-pointer" @click="redirectToRecord(manufacturer.id)"></i>
                <i class="bi bi-trash p-2 icon-pointer" @click="handleDelete(manufacturer.id)"></i>
            </td>
        </tr>
        </tbody>
    </table>
    <div v-else>No Car</div>
</template>

<script setup>
    import {onMounted, ref} from "vue";
    import axios from "axios";
    import {toast} from 'vue3-toastify'
    import {useRouter} from "vue-router";

    let manufacturers = ref([]);

    const getManufacturers = async () => {
        let response = await axios.get('/api/manufacturer')
        manufacturers.value = response.data.data;
    }

    const handleDelete = async (id) => {
        try {
            await axios.delete('/api/manufacturer/' + id)
            toast("Delete successfully", {
                autoClose: 1000,
                type: 'success'
            });
            await getManufacturers();
        } catch (exception) {
            const message = exception.response.data.message;
            toast(message, {
                autoClose: 1000,
                type: 'error'
            });
        }
    }

    const router = useRouter();

    const redirectToRecord = (id) => {
        router.push({ path: `/manufacturer/${id}` });
    };

    onMounted(async () => {
        await getManufacturers()
    });
</script>
