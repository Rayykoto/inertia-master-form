<template>
    <Head>
        <title>Form {{ table_name }}</title>
    </Head>
    <div class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa-fa-shield-alt"></i> {{ table_name }}</span>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="input-group mb-3">
                                        <Link href="#" v-if="hasAnyPermission(['form.create'])" class="btn btn-primary input-group-text" data-bs-toggle="modal" data-bs-target="#add_dataModal"> <i class="fa fa-plus-circle me-2"></i> Add Data</Link>
                                        <Link href="#" v-if="hasAnyPermission([create_data])" class="btn btn-primary input-group-text ms-auto" data-bs-toggle="modal" data-bs-target="#addModal"> <i class="fa fa-plus-circle me-2"></i> Add Column</Link>
                                    </div>
                                    <div class="input-group mb-3" >
                                        
                                    </div>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                <thead>
                                       <th v-for="header in headers" :key="header"> {{ header.field_description }}</th> 
                                       <th v-if="hasAnyPermission([edit_data]) || hasAnyPermission([delete_data])"> Action </th>
                                </thead>
                                <tbody>
                                    <tr v-for="form in forms" :key="form">
                                        <td v-for="header in headers" :key="header"> {{ form[header.field_name]  }}</td>
                                            <td class="text-center"  v-if="hasAnyPermission([edit_data]) || hasAnyPermission([delete_data])">
                                                <button v-if="hasAnyPermission([edit_data])" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editModal" @click="sendInfo(form)"> <i class="fa fa-pencil-alt me-1"></i> Update Data</button>
                                                <button @click.prevent="destroy(table,form.id)" v-if="hasAnyPermission([delete_data])" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <!-- The Modal Add Colum -->
                        <div class="modal" id="addModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Column : {{ table_name }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="/apps/master/forms/add_column" method="POST">
                                            <input class="form-control" :value="table" type="hidden" name="table">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <div class="mb-3">
                                                <label class="fw-bold">Name Column</label>
                                                <input class="form-control" type="text" name="name" placeholder="Name Column">
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-control" name="data_type">
                                                    <option v-for="field in fields" :key="field" :value="field.datatype">{{ field.name }}</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">SAVE</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal Add Column -->

                        <!-- The Modal Add Data [NEW]-->
                        <div class="modal" id="add_dataModal" ref="add_dataModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Data : {{ table_name }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="/apps/master/forms/new_data" method="POST">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <input class="form-control" name="table" :value="table" type="hidden">
                                            <input class="form-control" name="data_id" :value="selectedUser.id" type="hidden">
                                            <div class="mb-3" v-for="header in headers" :key="header">
                                                <label class="fw-bold">{{ header.field_name }}</label>
                                                <div v-if="header.input_type === 'Text'">
                                                    <input class="form-control" :name="header.field_name" type="text" :placeholder="header.field_description">
                                                </div>
                                                <div v-else-if="header.input_type === 'Number'">
                                                    <input class="form-control" :name="header.field_name" type="number" :placeholder="header.field_description">
                                                </div>
                                                <!-- <input class="form-control" :name="header.field_name" type="text" :placeholder="header.field_description"> -->
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">Save</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal Add Data -->

                        <!-- The Modal Edit Data -->
                        <div class="modal" id="editModal" ref="editModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update Data : {{ table_name }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="/apps/master/forms/update_data" method="POST">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <input class="form-control" name="table" :value="table" type="hidden">
                                            <input class="form-control" name="data_id" :value="selectedUser.id" type="hidden">
                                            <div class="mb-3" v-for="header in headers" :key="header">
                                                <label class="fw-bold">{{ header.field_name }}</label>
                                                <input class="form-control" :name="header.field_name" :value="selectedUser[header.field_name]" type="text" :placeholder="header.field_description">
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary shadow-sm rounded-sm" type="submit">Update</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal Edit Data -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutApp from '../../../Layouts/App.vue';

import { Head, Link } from '@inertiajs/inertia-vue3';

import { Inertia } from '@inertiajs/inertia';

import Swal from 'sweetalert2';

export default {
    layout: LayoutApp,

    components: {
            Head,
            Link
        },

    props: {
            table: String,
            table_name: String,
            headers: Object,
            create_data: String,
            edit_data: String,
            delete_data: String,
            forms:Array,
            fields:Array,
        },
    
    data: () => ({
        selectedUser: '',
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }), 
    
    methods: {
        sendInfo(form) {
            this.selectedUser = form;
        }    
    },

    setup() {
        const destroy = (table,id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {

                    Inertia.delete(`/apps/master/forms/${table}/delete_data/${id}`);

                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Role deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            })
        }

        return {
            destroy
        }
    }
}



</script>