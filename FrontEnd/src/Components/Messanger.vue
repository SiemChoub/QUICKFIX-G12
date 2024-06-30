<template>
  <transition name="fade">
    <div class="chat-container">
      <div class="chat">
        <!-- Chat Header -->
        <div class="chat-header">
          <div class="user-info">
            <img class="avatar" src="https://via.placeholder.com/50" alt="User Avatar">
            <div class="user-details">
              <p class="user-name">John Doe</p>
              <p class="user-status">Online</p>
            </div>
          </div>
          <!-- Header Icons -->
          <div class="header-icons">
            <i class="bi bi-telephone-fill call-icon" title="Call"></i>
            <button @click="closeChat" class="close-btn">&times;</button>
          </div>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages" ref="chatMessages">
          <div v-for="(message, index) in messages" :key="index" class="message-container">
            <div :class="{ 'message': true, 'outgoing': message.from === 'me', 'incoming': message.from !== 'me' }">
              <p>{{ message.text }}</p>
              <span class="message-time">{{ message.time }}</span>
            </div>
          </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input">
          <input type="text" placeholder="Type a message..." v-model="newMessage" @keyup.enter="sendMessage">
          <button @click="sendMessage" :disabled="newMessage.trim() === ''">Send</button>
          <!-- File Upload Button with Icon Only -->
          <label class="btn-upload">
            <input type="file" style="display: none;" accept="image/*" @change="handleImageUpload">
            <i class="pi pi-paperclip">q</i>
          </label>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      messages: [
        { text: 'Hello!', time: '10:00 AM', from: 'other' },
        { text: 'How are you?', time: '10:05 AM', from: 'me' },
        { text: "I'm good, thanks!", time: '10:10 AM', from: 'other' }
      ],
      newMessage: ''
    };
  },
  methods: {
    sendMessage() {
      if (this.newMessage.trim() !== '') {
        const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        this.messages.push({ text: this.newMessage, time: currentTime, from: 'me' });
        this.newMessage = '';

        // Scroll to the bottom of chat messages after updating
        this.$nextTick(() => {
          const chatMessages = this.$refs.chatMessages;
          chatMessages.scrollTop = chatMessages.scrollHeight;
        });
      }
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        console.log('Uploading image:', file);
        // Handle image upload logic here
      }
    },
    closeChat() {
      this.$emit('close');
    }
  }
};
</script>

<style scoped>
.chat-container {
  position: fixed;
  top: 55px;
  right: 0;
  bottom: 0;
  width: 400px; /* Adjust as needed */
  display: flex;
  align-items: flex-end;
  padding: 20px;
  z-index: 1050;
}

.chat {
  width: 100%;
  max-width: 100%;
  height: 100%; /* Fill the height of chat-container */
  background-color: #f0f0f0;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.chat-header {
  padding: 10px;
  background-color: orange;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.user-info {
  display: flex;
  align-items: center;
}

.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
}

.user-details {
  flex-grow: 1;
}

.user-name {
  font-weight: bold;
  margin-bottom: 3px;
}

.user-status {
  font-size: 0.8rem;
  color: #ddd;
}

.header-icons {
  display: flex;
  align-items: center;
}

.call-icon {
  font-size: 1.2rem;
  color: white;
  margin-right: 10px;
  cursor: pointer;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: white;
}

.chat-messages {
  flex-grow: 1; /* Take remaining space */
  overflow-y: auto; /* Enable scrolling */
  padding: 10px;
}

.message-container {
  display: flex;
  justify-content: flex-end;
}

.message {
  background-color: white;
  color: #333;
  max-width: 70%;
  padding: 10px;
  margin: 5px;
  border-radius: 10px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.message p {
  margin: 0;
}

.message-time {
  font-size: 0.8rem;
  color: #999;
}

.message.incoming {
  background-color: #e9e9eb;
}

.chat-input {
  display: flex;
  align-items: center;
  padding: 10px;
  background-color: white;
}

.chat-input input {
  flex-grow: 1;
  padding: 10px;
  border: none;
  border-radius: 20px;
  margin-right: 10px;
  font-size: 1rem;
}

.chat-input button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 20px;
  cursor: pointer;
}

.chat-input button:disabled {
  background-color: #ddd;
  cursor: not-allowed;
}

.btn-upload {
  display: flex;
  align-items: center;
  margin-left: 10px;
  cursor: pointer;
}

.btn-upload input[type="file"] {
  display: none;
}

.btn-upload i {
  font-size: 1.2rem;
  color: #777;
}
</style>
