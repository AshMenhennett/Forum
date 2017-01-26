<template>
    <div>
        <template v-if="messages.length" v-for="message in messages">
            <div class="msg-container" v-bind:class="(message.recipient_id === data_recipient.id) ? 'pull-right' : 'pull-left'">
                <div class="msg" v-bind:class="(message.recipient_id === data_recipient.id) ? 'sender' : 'recipient'">
                     {{ message.content }}
                </div>
            </div>
        </template>
        <template v-else>
            <p>There are no messages to display.</p>
        </template>

        <div class="msg-form form-group">
            <label for="content" class="control-label">Your Message</label>
            <textarea v-model="messageInput" name="content" id="content" class="form-control" placeholder="Your message" rows="8"></textarea>
        </div>
        <button type="submit" @click.prevent="send()" class="btn btn-default pull-right">Send</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages: [],
                data_recipient: {
                    id: Number,
                    name: String
                },
                user_id: Forum.user_id,
                messageInput: null
            }
        },
        props: {
            recipient: {
                id: Number,
                name: String
            }
        },
        methods: {
            getMessages() {
                return this.$http.get('/user/chat/threads/@' + this.data_recipient.name + '/messages/fetch').then((response) => {
                    this.messages = response.body;
                });
            },
            send() {
                this.messages.push({
                    sender_id: this.user_id,
                    recipient_id: this.data_recipient.id,
                    content: this.messageInput
                });
                return this.$http.post('/user/chat/threads/@' + this.data_recipient.name + '/messages', {
                    content: this.messageInput
                }).then((response) => {
                    this.messageInput = null;
                });
            }
        },
        mounted() {
            this.data_recipient = JSON.parse(this.recipient);
            this.getMessages();

            Echo.private('chat-messages.' + this.user_id).listen('UserSentMessage', (data) => {
                // listing to a channel that is all for us
                this.messages.push({
                    // pushing a Message to the array.
                    // The sender of the message is the 'other user', not us,
                    // so the sender_id must be the curerent recipient of our messages.
                    sender_id: this.data_recipient.id,
                    // then, the recipient of the message is actually us.
                    recipient_id: this.user_id,
                    content: data.message.content
                });
            }, (e) => {
                console.log(e);
            });

        }
    }
</script>
