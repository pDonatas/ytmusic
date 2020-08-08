<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Channels
            </div>
            <div class="card-body">
                <div v-if="alert">
                    <div :class="alert.class">{{alert.content}}</div>
                </div>
                <ul class="list-group">
                    <div v-if="channels.length === 0">There are no channels yet.</div>
                    <li v-else class="list-group-item" v-for="channel in channels" v-bind:key="channel.id">
                        Channel: {{channel.name}}<br/>
                        Current song: {{channel.youtubeId}}<br/>
                        <a :href="'/channel/' + channel.id">Enter</a>
                    </li>
                    <button id="creationButton" @click="creationForm()" class="btn btn-primary form-control">Create channel</button>
                    <div id="creation" style="display: none;">
                        <form @submit.prevent="submitForm()" method="post">
                            <div class="form-group">
                                <label for="title">Channel title</label>
                                <input id="title" v-model="channel.title" type="text" class="form-control">
                            </div>
                            <input type="submit" class="form-control btn btn-primary" value="Create">
                        </form>
                    </div>
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
                channel: {
                    title: ''
                },
                alert: {
                    class: '',
                    'content': ''
                },
                channels: []
            }
        },
        mounted() {
            this.LoadChannels()
        },
        methods: {
            LoadChannels() {
                this.$parent.req.get('api/channels').then(response => {
                    this.channels = response.data;
                }).catch(error => {
                    console.error(error.response.data.error);
                });
            },
            creationForm(){
                document.getElementById('creation').style.display = 'block';
                document.getElementById('creationButton').style.display = 'none';
            },
            submitForm() {
                const info = {
                    name: this.channel.title,
                };
                this.$parent.req.post('api/channels', info).then(response => {
                    let div = document.getElementById('alerts');
                    if(response.data.success) {
                        this.alert.class = 'alert alert-success';
                        this.alert.content = response.data.success;
                    }else{
                        this.alert.class = 'alert alert-danger';
                        this.alert.content = response.data.error;
                    }
                    this.LoadChannels();
                }).catch(error => {
                   console.error(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>
