<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <form class="form-horizontal" @submit.prevent="submit">

                            <div class="form-group" v-bind:class="{ 'has-error': errors.username }">
                                <label for="username" class="col-md-4 control-label">Username</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username"  autofocus v-model="username">

                                    <span class="help-block" v-if="errors.username">
                                        {{ errors.username[0] }}
                                    </span>
                                </div>

                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': errors.email }">
                                <label for="email" class="col-md-4 control-label">Email</label>
                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email"  v-model="email">
                                    <span class="help-block" v-if="errors.email">
                                        {{ errors.email[0] }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" v-bind:class="{ 'has-error': errors.password }">
                                <label for="password" class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password"  v-model="password">
                                    <span class="help-block" v-if="errors.password">
                                        {{ errors.password[0] }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {
        data(){

            return {
                username: null,
                email: null,
                password: null,
                errors: []

            }
        },
        methods: {

            ...mapActions({
                register: 'auth/register'
            }),

            submit(){
                this.register({

                    payload: {

                        username: this.username,
                        email: this.email,
                        password: this.password
                    },

                    context: this
                }).then(() => {
                    this.$router.replace({ name: 'home'})
                })
            }
        }
    }
</script>