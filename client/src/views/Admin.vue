<template>
    <div>
        <ul class="list-group" v-for="user in users" :key="user.id">
            <li  class="list-group-item " v-bind:id="user.id">
                <p class="text-left d-inline p-3">{{ user.email }} </p>
                <button class="btn btn-primary" v-on:click="kickOut(user.id)">Kick him</button>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'admin',
  components: {
    
  },
    data() {
        return {
            users : []
        }  
    },
    mounted() {
        axios.get('https://localhost:8000/api/admin').then(response => {
            this.users = response.data        
        })
    },

    methods: {
        async kickOut(id) {
            try {
                await axios.post('https://localhost:8000/api/admin/kick-out/' + id)
                var el = document.getElementById(id);
                el.remove()
                this.$notify({type: "success", title: "Success", text: `User with id ${id} has been kicked`})
            } catch(e) {
                this.$notify({type: "alert", title: "Error", text: e.response.data.message})
            }

        }
    }
}
</script>
<style scoped>
div {
    width: 30%;
    margin: auto;
}
</style>