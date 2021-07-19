<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <vue-progress-bar></vue-progress-bar>
                    <div class="card-header">
                         <h3 class="title"> {{msg}}</h3>

                         </div>
                    <div class="card-body">
                     <div class="form-group">
                         <label for="name">Your Full name</label>
                         <input v-model="form.name" type="text" class="form-control" id="name" placeholder="Enter Your Name">
                         <!-- <span v-for="erro in error" :key="erro.name"> {{erro.name}}</span> -->
                          <span v-if="allerror.name" class="text-danger">{{ allerror.name[0] }}</span>
                     </div>
                       <div class="form-group">
                         <label for="name">Your Email </label>
                         <input v-model="form.email" type="text" class="form-control" id="name" placeholder="Enter Your Email">
                       <span v-if="allerror.email" class="text-danger">{{ allerror.email[0] }}</span>

                     </div>

                     <div class="form-group">
                         <button @click="save" class="btn btn-primary btn-block">{{isEditing ? 'Update':'Save'}} </button>
                     </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8" >
                <filter-component
                           :q="query"
                            @f="query = $event"
                            :field="queryField"
                            @selected="queryField = $event"
                 />
                <table class="table" v-if="lists.length > 0">

                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         <tr v-for="item in lists" :key="item.id">
                        <th scope="row"></th>
                        <td>{{item.name}}</td>
                        <td>{{item.email}}</td>
                        <td>
                            <button class="btn btn-md btn-warning" @click="editpe(item)"> Edit </button>
                            <button @click="deleteit(item)" class="btn btn-md btn-danger"> Delete </button>
                        </td>
                        </tr>
                    </tbody>

                    </table>

            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return{

                 tempid: null,
                 isEditing :false,
                 queryField : 'name',
                 query:'',
                msg:'Welcome to Vue JS CRUD Oprations',
                lists:[],
                form:{
                    name:null,
                    email:null,

                  },
                  allerror:[]

            }
        },
        mounted() {
            // Display an info toast with no title

            this.fetchAll();
             this.$Progress.finish()
            // console.log('Component mounted.');


        },
        watch:{
              query : function (newQuery, oldQuery) {
                newQuery === '' ?  this.fetchAll() : this.searchStudents();
            },

        },
        methods:{


               searchStudents() {


                axios.get('/api/search/' + this.queryField+ '/' + this.query)
                    .then(response => {
                        this.lists = response.data.data;
                        console.log(this.lists);
                        this.$Progress.finish();
                    })
                    .catch(e => {
                        console.log(e.data.data);

                        this.$Progress.fail();
                    })
            },
            fetchAll(){
                try {
                    axios.get('/api/data')
                        .then(response=>this.lists = response.data)
                } catch (error) {

                }
            },
            editpe(item){
                try {
                     this.form = {
                        name:   item.name,
                        email:  item.email,
                        id: item.id,


                    };

                    this.tempid = item.id;
                    this.isEditing = true;

                } catch (error) {

                }

            },
            deleteit(item){
                try {
                     this.$Progress.start();
                    axios.delete('/api/data/'+item.id)
                    .then(res=>{
                        this.fetchAll();
                         this.$Progress.finish();


                    })

                } catch (error) {

                }
            },
                save(){

                    let method = axios.post;
                    let url = 'api/data/';

                    if(this.isEditing){
                         method = axios.put;


                         url = `/api/data/${this.tempid}`;

                    }


                       this.$Progress.start();

                        method(url,this.form)
                        .then(response=>{
                       console.log(response.data);
                            this.form = {name:'', email:''};
                            this.allerror = [];

                            this.msg = 'Data add Successfully !!'

                            this.fetchAll();
                        })


                    .catch ((error)=>{

                 this.allerror =  error.response.data.errors;

                        console.log(error.response.data.errors);
                    })



                }
        }
    }
</script>

<style scoped>
.title{
    color: rgb(0, 0, 0);
    background: orange;
    padding: 10px;
    text-align: center;
}
.container{
    margin-top: 10px;
}
</style>

