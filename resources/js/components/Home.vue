<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Channels
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item" v-for="channel in channels" v-bind:key="channel.id">
                        Channel: {{channel.name}}<br/>
                        Current song: {{channel.youtubeId}}<br/>
                        <a :href="'/channel/' + channel.id">Enter</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data() {
            return {
                channels: []
            }
        },
        mounted() {
            this.LoadChannels()
        },
        methods: {
            LoadChannels() {
                this.$parent.req.get('api/channels').then(response => {
                    console.log(response.data);
                    this.channels = response.data;
                }).catch(error => {
                    console.error(error.response.data.error);
                });
            }
        }
    }
</script>

<style scoped>

</style>
