<template>
    <div class="container">
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input type="search" class="form-control" placeholder="Search By Manufacturer..." aria-label="Search" v-model="keyword" @keyup="searchCars()" @click="searchCars(0)">
        </form>
    </div>
    <table class="table" v-if="cars.length > 0">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Year</th>
            <th scope="col">Manufacturer</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="car in cars" :key="car.id">
            <th scope="row">{{car.id}}</th>
            <td>{{car.name}}</td>
            <td>{{car.year}}</td>
            <td>{{car.manufacturer ?? '-'}}</td>
            <td>
                <i class="bi bi-eye p-2 icon-pointer" @click="redirectToRecord(car.id)"></i>
                <i class="bi bi-trash p-2 icon-pointer" @click="handleDelete(car.id)"></i>
            </td>
        </tr>
        </tbody>
    </table>
    <div v-else>No Car</div>
</template>

<script setup>
    import {onMounted, ref} from "vue";
    import axios from "axios";
    import {useRouter} from "vue-router";
    import {toast} from "vue3-toastify";

    let cars = ref([]);
    let keyword = ref('');

    const getCars = async () => {
        let response = await axios.get('/api/car')
        return response.data.data;
    }

    let typingTimeout = null;
    //reducing the hit to BE
    const searchCars = async (timeout = 1000) => {
       new Promise((resolve) => {
            if (typingTimeout) clearTimeout(typingTimeout)
            typingTimeout = setTimeout(() => {
                let response;
                if (keyword.value) {
                     response = axios.get('/api/search-car?keyword=' + keyword.value).then((res) => res.data.data);
                } else {
                    response = getCars();
                }
                resolve(response)
            }, timeout)
        }).then((data) => {
            cars.value = data;
        })
    }

    const router = useRouter();

    const redirectToRecord = (id) => {
        router.push({ path: `/car/${id}` });
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete('/api/car/' + id)
            toast("Delete Car successfully", {
                autoClose: 1000,
                type: 'success'
            });
            await searchCars(0);
        } catch (exception) {
            const message = exception.response.data.message;
            toast(message, {
                autoClose: 1000,
                type: 'error'
            });
        }
    }

    onMounted(async () => {
        await searchCars(0);
    });
</script>
