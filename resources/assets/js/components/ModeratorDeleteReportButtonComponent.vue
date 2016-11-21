<template>
    <span>
        <button v-if="!deleted" @click.prevent="destroy(reportId)" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Delete report</button>
        <button v-if="deleted" class="btn btn-success btn-xs" disabled="disabled"><span class="glyphicon glyphicon-thumbs-up"></span> Deleted report</button>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                deleted: false
            }
        },
        props: {
            reportId: null
        },
        methods: {
            destroy(id) {
                this.deleted = true;
                return this.$http.delete('/moderator/dashboard/reports/' + id);
            }
        }
    }
</script>
