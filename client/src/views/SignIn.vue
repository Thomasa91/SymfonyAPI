<template>
<div class="d-flex justify-content-center">    
    <main class="w-25">
        <div  v-if="warningNotify.seen" id="hide" class="alert alert-danger" role="alert">
            {{ warningNotify.message }}
        </div>
        <form @submit.prevent="submit">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" v-model="form.email" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" v-model="form.password" placeholder="Password">
            <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
    </main>
</div>
</template>

<script>
import { mapActions } from 'vuex'
    export default {
    name: 'signin',
    components: {
        
    },
    data() {
        return  {
            form: {
                email: this.$route.params.email ? this.$route.params.email : '',
                password: '',     
            },
            warningNotify: {
                seen: false,
                message: ''
            },
            singUpSuccess: {
                message : this.$route.params.successSignUp ? this.$notify({type: "success", title: "Success", text: "Now you can log in"}) : null,
            }
        }
    },
    methods: {
        ...mapActions({
            signIn : 'auth/signIn'   
        }),

        submit() {
            this.signIn(this.form).then(() => {
                this.$router.replace({
                    name: 'dashboard'
                })
            }).catch((e) => {
                var message = e.response.data.message
                this.warningNotify.seen = true
                this.warningNotify.message = message                
            })
        }
    }
    }
</script>
