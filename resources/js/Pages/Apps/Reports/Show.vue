<template>
    <Head>
        <title>FORMS - Master Reports</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            
                                <span class="font-weight-bold"><i class="fa fa-form"></i> Master Reports - {{ table_name }}</span>
                         
                            <!-- <div class="col-md-3 d-flex flex-row-reverse">
                                <button @click.prevent="reset" class="btn btn-md btn-warning border-0 shadow w-55"><i class="fa fa-filter"></i> RESET FILTER</button>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="filter">

                                <div class="row">
                                    <div class="col-md-2">
                                        <div  class="mb-3" v-if="user_role.includes('user')">
                                            <input type="hidden" name="user" v-model="user">
                                        </div>
                                        <div  class="mb-3" v-else>
                                            <label class="form-label fw-bold">Select User</label>
                                            <select class="form-control" v-model="user">
                                                <option :value="null" disabled selected>-- Users --</option>
                                                <option v-for="user in users" :key="user" :value="user.id">{{ user.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Forms</label>
                                            <select class="form-control">
                                                <option value="">-- Forms --</option>
                                                <option>Form 1</option>
                                                <option>Form 2</option>
                                                <option>Form 3</option>
                                            </select>   
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">START DATE</label>
                                            <input type="date" v-model="start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">END DATE</label>
                                            <input type="date" v-model="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">*</label>
                                            <button class="btn btn-md btn-purple border-0 shadow w-100"><i class="fa fa-filter"></i> FILTER</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div v-if="data">
                                <hr>
                                <div class="export text-end mb-3">
                                    <a :href="`/apps/master/reports/${table}/export?user=${selected_user}&start_date=${start_date}&end_date=${end_date}`" target="_blank" class="btn btn-success btn-md border-0 shadow me-3"><i class="fa fa-file-excel"></i> EXCEL</a>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <th v-for="header in headers" :key="header" style="background-color: #e6e6e7;">
                                            {{ header.field_description }}
                                        </th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="form in data" :key="form">
                                        <td v-for="header in headers" :key="header">
                                            <div v-if="header.input_type == 'File'">
                                                <img :src="showImage() + form[header.field_name]" class="object-cover h-40 w-80"/>
                                            </div>
                                            <div v-else-if="header.input_type == 'Yes/No'" class="text-center">
                                                <div v-if="form[header.field_name] == '1'">
                                                    Yes
                                                </div>
                                                <div v-else>
                                                    No
                                                </div>
                                            </div>
                                            <div v-else>
                                                {{ form[header.field_name] }}
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
   
</template>

<script>
import LayoutApp from '../../../Layouts/App.vue';

import { Head, Link } from '@inertiajs/inertia-vue3';

import { Inertia } from '@inertiajs/inertia';

import { ref } from 'vue';

export default {    
    layout: LayoutApp,

    components: {
        Head, Link
    },

    props:{
        table: String,
        users: Array,
        selected: Array,
        table_name: String,
        headers: Array,
        forms:Object,
        csrfToken: String,
        data: Array,
        user_role:String,
        user_id:String,
        selected_user:String,
    },


    setup(props) {
        const user = ref('' || (new URL(document.location)).searchParams.get('user'));
        const start_date = ref('' || (new URL(document.location)).searchParams.get('start_date'));
        const end_date = ref(''|| (new URL(document.location)).searchParams.get('end_date'));
        const url = props.table;

        const filter = () => {
            Inertia.get(`/apps/master/reports/${url}/filter`, {
                user : user.value,
                start_date: start_date.value,
                end_date: end_date.value,
            
            });
        }

        const reset = () => {
            Inertia.get(`/apps/master/reports/${url}/show`, {

            });
        }

        return {
            start_date,
            end_date,
            user,
            filter,
            reset
        }
    }

}

</script>