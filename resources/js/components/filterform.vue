<template>
    <div id="filter">
        <form class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <strong>Search By : </strong>
                </div>
                <div class="col-md-3">
                    <select :select="field" @change="selected($event)" class="form-control" id="">
                        <option value="name">Name</option>
                        <option value="email">Email</option>

                    </select>
                </div>
                <div class="col-md-7">
                    <!-- <input :value="q" @input="search($event)" type="text" class="form-control" placeholder="Search here..."> -->

                    <button class="btn btn-md btn-primary" @click.prevent="search"> Search Item</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "FilterForm",

        props : ['field', 'q'],

        methods: {
            search() {
                console.log(this.q)

            },

            selected(field) {
                this.queryField = field.target.value;
                this.$emit('selected', this.queryField)
            }
        },
    }
</script>

<style scoped>

</style>
