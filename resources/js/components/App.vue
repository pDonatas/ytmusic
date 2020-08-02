<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">DiscoMan</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" v-for="item in items">
                        <a class="nav-link" :href="item.path">{{item.name}}</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.$router.options.routes.forEach(route => {
                this.items.push({
                    name: route.name
                    , path: route.path
                })
            })
        }
        , data() {
            return {
                items: []
            }
        }
    }
</script>
