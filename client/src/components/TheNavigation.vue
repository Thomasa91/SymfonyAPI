<template>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <!-- <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            
        </a> -->

        <router-link class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"
                    :to="{
                        name: 'home'
                    }">
                    <span class="fs-4">JWT APP</span>
        </router-link>
        <ul class="nav nav-pills">
            <li  class="nav-item">
                <router-link class="nav-link"
                    :to="{
                        name: 'home'
                    }">
                    Home
                </router-link>
            </li>
            <template v-if="authenticated">
                <li class="nav-item">
                    <router-link class="nav-link"
                        :to="{
                            name: 'dashboard'
                        }">
                        Dashboard
                    </router-link>
                </li>
                <template v-if="isAdmin">
                    <li class="nav-item">
                        <router-link class="nav-link"
                            :to="{
                                name: 'admin'
                            }">
                            Admin
                        </router-link>
                    </li>
                </template>
                <li class="nav-item">
                    <a href="#" @click.prevent="signOut" class="nav-link">Signout</a>
                </li>
            </template>
            <template v-else>
                <li class="nav-item">
                    <router-link class="nav-link"
                        :to="{
                            name: 'signin'
                        }">
                        Sign-in
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link"
                        :to="{
                            name: 'signup'
                        }">
                        Sign-up
                    </router-link>
                </li>
            </template>
        </ul>
        </header>
    </div>
</template>


<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                isAdmin: 'auth/isAdmin'
            })
        },

        methods: {
            ...mapActions({
                signOutAction: 'auth/signOut'
            }),

            signOut() {
                this.signOutAction().then(() => {
                    this.$router.replace({
                        name: 'home'
                    })
                })
            }  
        }
    }
</script>