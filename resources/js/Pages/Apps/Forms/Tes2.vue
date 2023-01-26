<template>
    <Head>
        <title>FORMS - Master Form</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 rounded-3 shadow border-top-purple">
                        <div class="card-header">
                            <span class="font-weight-bold"><i class="fa fa-form"></i> Master Forms</span>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="input-group mb-3">
                                    <Link href="/apps/forms/create" class="btn btn-primary input-group-text"> <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border-0 rounded-3 shadow border-top-purple">
                                            <div class="card-header">
                                                <span class="font-weight-bold"><i class="fa fa-chart-bar"></i> DIVISION</span>
                                            </div>
                                            <div class="card-body">
                                                
                                                    <div class="row" id="app">
                                                        <div class="col-md-12" id="app">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">DIVISION</label>
                                                                
                                                                <select class="form-control" v-model="divisions.id">
                                                                    <option value="">-- Select Divions --</option>
                                                                    <option v-for="division in divisions" :key="division.id">{{ division.name }}</option>
                                                                </select>
                                                                <!-- <input type="text" v-model="search" class="form-control">  -->
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">FORMS</label>
                                                                <select class="form-control">
                                                                    <option value="">-- Select Forms --</option>
                                                                    <option v-for="form in formsFilter" v-bind:key="form.id">{{ form.name }}</option>
                                                                </select>   
                                                            </div>
                                                        </div>
                                                    </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
   
</template>

<script>
import LayoutApp from '../../../Layouts/App.vue';

export default {    
    layout: LayoutApp,

    data() {
        return {
            divisions: [],
            search: "-",         
            forms : [],
        };
    },

    created() {

        this.divisions = [
                { id: 0, name: 'Select Form' },
                { id: 1, name: 'Form Support' },
                { id: 2, name: 'Form Marketing' },
                { id: 3, name: 'Form Application Support' },
        ],
    
        this.forms = [
                {id: 1, name: 'Form Support', url: 'tes'},
                {id: 2, name: 'Form Marketing', url: 'tes'},
                {id: 1, name: 'Form Application Support', url: 'tes'},
        ]
    },  

    computed: {
        formsFilter() {
            return this.forms.filter((form) => {
                return form.name.match(this.divisions.id);
            });
        }
    }


}

</script>