<template>
    <div class="container">
        <button
            class="btn btn-primary"
            @click="followUser"
            v-text="buttonText"
        ></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'followStatus'],

        data() {
            return {
                status: this.followStatus
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            followUser() {
                axios
                    .post('/follow/' + this.userId)
                    .then((result) => {
                        this.status = ! this.status
                    })
                    .catch((err) => {

                        if(err.response.status == 401) {
                            window.location = '/login';
                        }
                    });
            },
        },

        computed: {
            buttonText() {
               return (this.status) ? 'Unfollow' : 'Follow'
            }
        }
    }
</script>
