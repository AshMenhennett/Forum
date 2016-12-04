<template>
    <div>
        <span v-if="reported">Reported <span class="glyphicon glyphicon-flag"></span></span>
        <a href="#" @click.prevent="report()" v-if="!reported && auth">Report <span class="glyphicon glyphicon-flag"></span></a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
               reported: false,
               auth: Forum.auth
            }
        },
        props: {
            topicSlug: null,
            postId: null
        },
        methods: {
            getStatus() {
                return this.$http.get('/forum/topics/' + this.topicSlug + '/posts/' + this.postId + '/report/status').then((response) => {
                    // type will only exist in returned JSON if a valid report for the given topic exists in the database
                    this.reported = ('type' in response.body) ? true : false;
                });
            },
            report() {
                return this.$http.post('/forum/topics/' + this.topicSlug + '/posts/' + this.postId + '/report').then((response) => {
                    this.getStatus();
                });
            }
        },
        mounted() {
            this.getStatus();
        }
    }
</script>
