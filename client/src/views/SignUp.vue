<template>
<div class="d-flex justify-content-center">    
    <main class="w-25">
        <div v-if="form.errors.length" class="alert alert-danger" role="alert">
                <b class="alert">Please correct the following error(s):</b>
                <ul>
                    <li v-for="error in form.errors" :value="error.message" :key="error.message">
                        <p>{{ error.message }}</p> 
                    </li>
                </ul>
        </div>
        <form v-if="!form.sucess" @submit.prevent="submit"> 
            <h1 class="h3 mb-3 fw-normal">Sign up</h1>
            <div class="form-floating">
                <!-- class="form-control" -->
            <input type="text" class="form-control" id="floatingInput" v-model="form.email" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" v-model="form.password" placeholder="Password">
            <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
        </form>
    </main>
</div>
</template>

<script>

    import axios from 'axios'
    export default {
    name: 'signup',
    components: {
        
    },
    data() {
        return  {
            form: {
                email: '',
                password: '',
                errors: [],    
            },

        }
    },
    methods: {
        async submit() {
            
            this.checkForm()
  
            if(!this.form.errors.length) {

                await axios.post('https://localhost:8000/api/register', {email: this.form.email, password: this.form.password}).then(() => {
                    this.$router.push({ name: 'signin', params: {successSignUp: true, email: this.form.email}})
                }).catch((error) => {
                   this.$notify({type: "alert", title: "Warning", text: error.response.data.message})
                })
            }
        },
        checkForm() {
            this.form.errors = []


            if(!this.form.email || !this.form.password) {
                this.form.errors.push({message: "Please fill up the fields"})
            } else {
                this.validEmail(this.form.email)
                this.validPassword(this.form.password)
            }

        },
        validEmail(email) { 
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            
            if (!re.test(String(email).toLowerCase())) {
                this.form.errors.push({message: 'Invalid email'})
            }
        },

        validPassword(password) {
           
            var capital = /[A-Z]/
            var small = /[a-z]/
            var digit = /\d/

            if(!capital.test(password)) {
                this.form.errors.push({message: "Password has to have at least one capital letter"})
            }

            if(!small.test(password)) {
                this.form.errors.push({message: "Password has to have at least one small letter"})
            }

            if(!digit.test(password)) {
                this.form.errors.push({message: "Password has to have at least one digit"})
            }

            if(password.length < 8) {
                console.log(password.length)
                this.form.errors.push({message: "Password has to have at least 8 characters"})
            }

        }
    }}
</script>
