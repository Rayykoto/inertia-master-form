<template>
    <Head>
        <tite>Roles - Master Form</tite>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> ROLES</span>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="input-group mb-3">
                                    <Link href="/apps/roles/create" v-if="hasAnyPermission(['roles.create'])" class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                                    <input type="text" class="form-control" placeholder="search by role name . . .">

                                    <button class="btn btn-primary input-group-text" type="submit"> <i class="fa fa-search me-2"></i> SEARCH</button>
                                </div>
                            </form>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"> Role Name </th>
                                        <th scope="col" style="width:50%">Permissions</th>
                                        <th scope="col" style="width:20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(role, index) in roles.data" :key="index">
                                        <td>{{ role.name }}</td>
                                            <td>
                                                <span v-for="(permission, index) in role.permissions" :key="index" class="badge badge-primary shadow border-0 ms-2 mb-2">
                                                    {{ permission.name }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <Link href="#" v-if="hasAnyPermission(['roles.edit'])" class="btn btn-success btn-sm me-2"><i class="fa fa-pencil-alt me-1"></i> EDIT</Link>
                                                <button v-if="hasAnyPermission(['roles.delete'])" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> DELETE</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

    export default {
        //layout
        layout: LayoutApp,

        //register component
        components: {
            Head,
            Link
        },

        props: {
            roles: Object,
        }
    }
</script>