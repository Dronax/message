<template>
    <li :class="className">
        <div class="row margin-left-none margin-right-none">
            <div class="col-md-2 padding-right-none">
                <div class="avatar-user text-center">
                        <img :src="user.avatar" alt="">
                </div>
            </div>

            <div class="col-md-10 padding-left-none">
                <div class="user-name">
                    <span>{{ user.name }} <i data-toggle="tooltip" title="Онлайн" class="material-icons online">fiber_manual_record</i> <span class="date float-right">{{ time }}</span></span>
                </div>
                <div class="message">{{ message }}</div>
            </div>
        </div>
     </li>
</template>

<script>
    export default {
        props: [
            'message',
            'user',
            'time',
            'seen',
        ],
        computed: {
            className() {
                return this.seen == 1 ? '' : 'unread';
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
