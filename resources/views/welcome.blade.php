<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
</head>

<body class="bg-slate-50">

    <div class="max-w-xl mx-auto shadow h-screen flex flex-col" id="app">
        <div class="h-16 shadow-lg flex items-center px-4 flex-shrink-0">
            <div class="text-xl font-bold">Simple Chat Bot</div>
        </div>
        <div class="flex-grow flex flex-col p-2 gap-1 min-h-0 overflow-auto" id="chat-body">

            <div v-for="chat in chats" :key="chat.id" class=" text-white px-4 py-2 rounded-xl max-w-[70%]" :class="{'self-end bg-blue-500': chat.sender == 'user', 'self-start bg-gray-500': chat.sender == 'ai'}">
                <div class="whitespace-pre-line">@{{ chat.message }}</div>
                <img v-if="chat.type == 'chart'" :src="chat.image" class="w-full rounded my-2" />
            </div>
        </div>
        <div class="h-16 border-t flex px-4 flex-shrink-0" v-if="!loading">
            <input type="text" v-model="message" id="messageInput" class="w-full h-full border-none focus:outline-none px-4" placeholder="Type your message here...">
            <button @click="send" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full self-center">
                Send
            </button>
        </div>
        <div class="p-4 text-center" v-else>
            AI is thinking
        </div>
    </div>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: '',
                chats: [],
                loading: false,
                id: 0
            },
            methods: {
                send() {
                    this.loading = true
                    this.chats.push({
                        id: this.id++,
                        message: this.message,
                        image: null,
                        sender: 'user'
                    })

                    fetch('/api/prompt', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: this.message
                        })
                    }).then(res => res.json()).then(res => {
                        console.log(res)
                        this.chats.push({
                            id: this.id++,
                            type: res.type,
                            message: res.message,
                            sender: 'ai',
                            image: res.image
                        })
                        this.message = ''

                    }).finally(() => {
                        this.loading = false
                    })
                }
            }
        })

    </script>
</body>

</html>
