<template>
    <div class="row" v-if="users">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete users</div>
                <div class="panel-body">
                    <button @click.prevent="order(users)" class="btn btn-default"><span v-bind:class="'glyphicon glyphicon-sort-by-attributes' + (orderBy === 'desc' ? '' : '-alt')"></span> {{ (orderBy === 'asc' ? 'Newest' : 'Oldest') }}</button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th> <th>User</th> <th>Email</th> <th>Role</th> <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users">
                                <td>{{ user.id }}</td><td><a v-bind:href="'/user/profile/@' + user.name">{{ user.name }}</a></td> <td>{{ user.email }}</td> <td>{{ user.role }}</td> <td><a href="#" class="btn btn-danger btn-xs" @click.prevent="destroy(user.name)"><span class="glyphicon glyphicon-remove"></span> Delete</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
</template>

<script>
    import {reverse} from '../filters.js';

    export default {
        data() {
            return {
                users: [],
                orderBy: 'asc'
            }
        },
        methods: {
            getUsers() {
                return this.$http.get('/admin/dashboard/users/index').then((response) => {
                    this.users = response.body;
                });
            },
            destroy(name) {
                for (var i = 0; i < this.users.length; i++) {
                    (this.users[i].name === name) ? this.users.splice(i, 1) : false;
                }
                return this.$http.delete('/admin/dashboard/users/' + name);
            },
            order(users) {
                this.users = reverse(users);
                this.orderBy = (this.orderBy === 'asc' ? 'desc' : 'asc');
            }
        },
        mounted() {
            this.getUsers();
        }
    }
</script>
