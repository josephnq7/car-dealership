<template>
    <div class="container">
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input type="search" class="form-control" placeholder="Search By Manufacturer..." aria-label="Search" v-model="keyword" @keyup="searchCars()" @click="searchCars()">
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
            <td>{{car.manufacturer_name ?? '-'}}</td>
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

    onMounted(async () => {
        await searchCars(0);
    });
</script>
