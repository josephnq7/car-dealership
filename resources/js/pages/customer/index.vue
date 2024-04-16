<template>
    <table class="table" v-if="customers.length > 0">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="customer in customers" :key="customer.id">
            <th scope="row">{{customer.id}}</th>
            <td>{{customer.name}}</td>
            <td>
                <i class="bi bi-eye p-2 icon-pointer" @click="redirectToRecord(customer.id)"></i>
                <i class="bi bi-trash p-2 icon-pointer" @click="handleDelete(customer.id)"></i>
            </td>
        </tr>
        </tbody>
    </table>
    <div v-else>No Customer</div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "axios";
import {toast} from 'vue3-toastify'
import {useRouter} from "vue-router";

let customers = ref([]);

const getCustomers = async () => {
    let response = await axios.get('/api/customer')
    customers.value = response.data.data;
}

const handleDelete = async (id) => {
    try {
        await axios.delete('/api/customer/' + id)
        toast("Delete successfully", {
            autoClose: 1000,
            type: 'success'
        });
        await getCustomers();
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
    router.push({ path: `/customer/${id}` });
};

onMounted(async () => {
    await getCustomers()
});
</script>
