
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// ES6
import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('message', require('./components/message.vue'));

const app = new Vue({
    el: '#app',
    data:{
        message: '',
        convId: $('meta[name=convId]').attr('content'),
        user: {
            userId: $('meta[name=userId]').attr('content'),
            name: $('meta[name=name]').attr('content'),
            avatar: $('meta[name=avatar]').attr('content'),
        },
        chat: {
            message: [],
            user: [],
            time: [],
            seen: [],
        },
        typing: '',
    },
    watch: {
        message() {
            Echo.private('mc-chat-conversation.' + this.convId)
                .whisper('typing', {
                    name: this.message
                });
        }
    },
    methods: {
        seenMessage() {
            if(this.message.length != 0) {
                axios.post('/setMessagesSeen/' + this.convId, {
                    message: this.message,
                })
                .then( response => { $('li').removeClass('unread'); }) 
                .catch( response => { console.log(response) } )
            }
        },
        send(){
            if(this.message.length != 0 && this.message.length <= 4000) {
                this.chat.message.push(this.message);
                this.chat.user.push(this.user);
                this.chat.time.push(this.getTime());
                this.chat.seen.push(0);
                axios.post('/sendMessage/' + this.convId, {
                    message: this.message,
                  })
                  .then(response => {
                    console.log(response);
                    this.message = '';
                  })
                  .catch(error => {
                    console.log(error);
                  });
            }
        },
        getTime() {
            let time = new Date();
            return time.getHours() + ':' + time.getMinutes();
        }
    },

    mounted() {
        Echo.private('mc-chat-conversation.' + this.convId)
            .listen('.Musonza\\Chat\\Messages\\MessageWasSent', (e) => {
                // this.chat.message.push(e.message);
                // this.chat.user.push(e.user.conversation.users);
                // this.chat.time.push(this.getTime());
                var users = e.message.conversation.users;
                Object.keys(users).map(function(objectKey, index) {
                    var value = users[objectKey];
                    if(value.id != this.user.userId && e.message.user_id != this.user.userId) {
                        document.getElementById('newmessage').play();
                        flashTitle("У вас новое сообщение", 10); // toggles it 10 times.../
                        this.chat.message.push(e.message.body);
                        this.chat.seen.push(0);
                        this.chat.user.push(value);
                        this.chat.time.push(this.getTime());
                        //console.log(value);
                    }
                }, this);
                //console.log(e.message);
            })
            .listenForWhisper('typing', (e) => {
                if(e.name != '') {
                    this.typing = 'Набирает сообщение..';

                }
                else {
                    this.typing = null;
                }
            });

        let that = this;
        Echo.private('conversation.'+this.convId+'.'+ this.user.userId)
             .listen('MessageIsSeen', (e) => {
                console.log(e);
        //        let message = e.message

        //        let lookingForMessage = that.chat.messages.find((m) => {
        //   // I presume in your db messages table  has field content and time
        //             return m.content == message.content && m.time => message.time
        //        });
        //        try {
        //          lookingForMessage.readed = 1
        //        }catch (err){
        //          // message not found
        //          console.log(err)
        //        }
        });
    }
});
