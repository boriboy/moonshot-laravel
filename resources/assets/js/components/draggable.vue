<template>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Balance</th>
        </tr>
        </thead>

        <draggable :list="usersNew" :options="{animation:200, handle:'.my-handle'}" :element="'tbody'" @change="update">
            <tr v-for="(user, index) in usersNew" class="my-handle">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.login_at}}</td>
                <td>{{ user.balance.balance}}</td>
            </tr>

        </draggable>

    </table>
</template>

<script type="text/babel">
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable
        },

        props: ['users'],
//
        data() {
            return {
                usersNew: this.users,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },

        methods: {
            update() {
                this.usersNew.map((user, index) => {
                    user.order = index + 1;
                })

                axios.put('/admin/users/updateAll', {
                    users: this.usersNew
                }).then((response) => {
                    // success message
                })
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
