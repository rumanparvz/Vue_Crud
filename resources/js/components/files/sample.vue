<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
               <div class="card">
                        {{postTitle}}
               </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
    props: ['postTitle'],
        data(){
            return{

            }
        },
        mounted() {

        },
        watch:{

        },
        methods:{
    }
 }
</script>

<style scoped>

</style>

