<template>
    <div class="row" v-if="users.length">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Delete users</div>
                <div class="panel-body">
                    <button @click.prevent="order()" class="btn btn-default"><span v-bind:class="'glyphicon glyphicon-sort-by-attributes' + (orderBy === 'desc' ? '' : '-alt')"></span> {{ (orderBy === 'asc' ? 'Newest' : 'Oldest') }}</button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th> <th>User</th> <th>Email</th> <th>Role</th> <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users">
                                <td>{{ user.id }}</td><td><a v-bind:href="'/user/profile/@' + user.name">{{ user.name }}</a></td> <td>{{ user.email }}</td> <td>{{ user.role }}</td> <td><a href="#" class="btn btn-danger btn-xs" @click.prevent="destroy(index, user.name)"><span class="glyphicon glyphicon-remove"></span> Delete</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                orderBy: 'asc'
            }
        },
        props: {
            usersProp: null
        },
        methods: {
            destroy(index, name) {
                this.users.splice(index, 1);
                return this.$http.delete('/admin/dashboard/users/' + name);
            },
            order() {
                this.users.reverse();
                this.orderBy = (this.orderBy === 'asc' ? 'desc' : 'asc');
            }
        },
        mounted() {
            this.users = JSON.parse(this.usersProp);
        }
    }
</script>
