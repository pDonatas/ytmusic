<template>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                Current song: Take on me by A-ha
            </div>
            <div class="card-body">
                <youtube :video-id="videoId" :player-vars="playerVars" ref="youtube"></youtube>
                <div v-if="this.playing === false">
                    <button class="btn btn-play" @click="playVideo">Play</button>
                </div>
                <div v-else>
                    <button class="btn btn-play" @click="pauseVideo">Pause</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Channel",
        data() {
            return {
                videoId: 'dQw4w9WgXcQ',
                playerVars: {
                    showinfo: 0,
                    controls: 0,
                    autohide: 1,
                    wmode: 'transparent',
                    modestbranding: 1,
                    showsearch: 0,
                    playsinline: 1,
                    color: 'white',
                    rel: 0,
                    version: 3,
                    theme: 'light'
                },
                playing: false,
                currentTime: 0,
                timer: null,
            }
        },
        mounted() {
            this.player.addEventListener('onStateChange', this.youtubStateChange)
            this.loadData()
        },
        methods: {
            loadData(){
                let url = '/api/channels/'+this.$route.params.id;
                this.$parent.req.get(url).then(response => {
                    this.videoId = response.data.youtubeId;
                    this.currentTime = response.data.time;
                }).catch(error => {
                    console.error(error.response.data.error);
                });
            },
            updateData() {
                const info = {
                    youtubeId: this.videoId,
                    time: this.currentTime
                };
                let url = '/api/channels/updateYoutube/'+this.$route.params.id;
                this.$parent.req.patch(url, info).then(response => {
                }).catch(error => {
                    console.error(error.response.data.error);
                });
            },
            playVideo() {
                this.player.seekTo(this.currentTime);
                this.player.playVideo()
                this.playing = true
                var self = this;
                this.timer = setInterval(async function(){
                    if(self.playing === true) {
                        self.currentTime = await self.player.getCurrentTime();
                        self.updateData();
                    }
                }, 1000);
            },
            pauseVideo() {
                this.player.pauseVideo()
                this.playing = false
                clearInterval(this.timer);
                this.timer = null;
            },
            youtubStateChange (youtubeState) {
                switch(youtubeState.data) {
                    case 1:
                        if(!this.playing)
                            this.playVideo();
                        break;
                    case 2:
                        if(this.playing)
                            this.pauseVideo();
                        break;
                    case 0:
                        clearInterval(this.timer);
                        this.timer = null;
                        this.currentTime = 0;
                        console.log(this.currentTime);
                        this.playing = false;
                        break;
                }
            }
        },
        computed: {
            player() {
                return this.$refs.youtube.player
            }
        }
    }
</script>

<style scoped>

</style>
