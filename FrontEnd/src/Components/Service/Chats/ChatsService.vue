<template>
  <div id="app" class="container my-5">
      <section style="background-color: #CDC4F9;">
        <div class="container py-5">
          <div class="row">
            <div class="col-md-12">
              <div class="card" id="chat3" style="border-radius: 15px;">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                      <div class="p-3">
                        <div class="input-group rounded mb-3">
                          <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                            aria-describedby="search-addon" />
                          <span class="input-group-text border-0" id="search-addon">
                            <i class="bi bi-search"></i>
                          </span>
                        </div>
                        <div data-mdb-perfect-scrollbar-init style="position: relative; height: 400px">
                          <ul class="list-unstyled mb-0">
                            <li class="p-2 border-bottom">
                              <a href="#!" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                  <div>
                                    <img
                                      src="./assets/images/lee-min-ho.jpg"
                                      alt="avatar" class="d-flex align-self-center me-3 rounded-circle me-2 img-fluid" style="width:50px; height:50px"  >
                                    <span class="badge bg-success badge-dot"></span>
                                  </div>
                                  <div class="pt-1">
                                    <p class="fw-bold mb-0">Lee Min-Ho</p>
                                    <p class="small text-muted">Hello, Are you there?</p>
                                  </div>
                                </div>
                                <div class="pt-1">
                                  <p class="small text-muted mb-1">Just now</p>
                                  <span class="badge bg-danger rounded-pill float-end">3</span>
                                </div>
                              </a>
                            </li>
                            <li class="p-2 border-bottom">
                              <a href="#!" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                  <div>
                                    <img
                                      src="./assets/home.jpg"
                                      alt="avatar" class="d-flex align-self-center me-3 rounded-circle me-2 img-fluid" style="width:50px; height:50px">
                                    <span class="badge bg-warning badge-dot"></span>
                                  </div>
                                  <div class="pt-1">
                                    <p class="fw-bold mb-0">ZA ZA</p>
                                    <p class="small text-muted">Here is your bag.</p>
                                  </div>
                                </div>
                                <div class="pt-1">
                                  <p class="small text-muted mb-1">5 mins ago</p>
                                  <span class="badge bg-danger rounded-pill float-end">2</span>
                                </div>
                              </a>
                            </li>
                            <li class="p-2 border-bottom">
                              <a href="#!" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                  <div>
                                    <img
                                      src="./assets/heart.jpg"
                                      alt="avatar" class="d-flex align-self-center me-3 rounded-circle me-2 img-fluid" style="width:50px; height:50px">
                                    <span class="badge bg-success badge-dot"></span>
                                  </div>
                                  <div class="pt-1">
                                    <p class="fw-bold mb-0">Kongkea</p>
                                    <p class="small text-muted">Do you miss me?</p>
                                  </div>
                                </div>
                                <div class="pt-1">
                                  <p class="small text-muted mb-1">Yesterday</p>
                                </div>
                              </a>
                            </li>
                            <li class="p-2 border-bottom">
                              <a href="#!" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                  <div>
                                    <img
                                      src="./assets/coca-team.jpg"
                                      alt="avatar" class="d-flex align-self-center me-3 rounded-circle me-2 img-fluid" style="width:50px; height:50px">
                                    <span class="badge bg-danger badge-dot"></span>
                                  </div>
                                  <div class="pt-1">
                                    <p class="fw-bold mb-0">Mina</p>
                                    <p class="small text-muted">Good morning!</p>
                                  </div>
                                </div>
                                <div class="pt-1">
                                  <p class="small text-muted mb-1">Yesterday</p>
                                </div>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  <div class="col-md-6 col-lg-7 col-xl-8">
                    <h5 class="card-title">
                      <div class="profile w-100 p-1 rounded-2 d-flex gap-3 shadow align-items-center">
                        <img id="imgPro" src="./assets/lee-min-ho.jpg" class="rounded-circle me-2 img-fluid" style="width: 40px; height: 40px;"  />
                        <h4 class="align-baseline">Lee Min-Ho</h4>
                        <div class="ms-auto">
                          <button type="button" class="btn-close " aria-label="Close"></button>  
                        </div>
                      </div>
                    </h5>
                    <div class="card-body p-4 d-flex flex-column align-items-center">
                      <img src="./assets/lee-min-ho.jpg" alt="User Avatar" class="rounded-circle mb-3 img-fluid" style="width: 100px; height:100px" />
                      <h5 class="card-title mb-1">Lee Min-Ho</h5>
                      <div class="d-flex align-items-center">
                        <div class="me-2 status-indicator bg-success rounded-circle"></div>
                        <p class="card-text text-muted mb-0">Online</p>
                      </div>
                      <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary btn-sm">Message</button>
                        <button class="btn btn-outline-secondary btn-sm">Profile</button>
                      </div>
                    </div>
                    <div class="chat-messages">
                      <div v-for="message in messages" :key="message.id" class="chat-message row no-gutters" :class="[message.sender === 'user' ? 'justify-content-end' : '']">
                        <div class="col-auto" :class="[message.sender === 'user' ? 'order-2' : '']">
                          <div class="col-auto">
                            <div class="user-profile d-flex align-items-center">
                              <img :src="message.sender === 'user' ? userProfilePicture : otherUserProfilePicture" class="rounded-circle" alt="User Profile" />
                              <div class="user-name ms-2">{{ message.sender === 'user' ? userName : otherUserName }}</div>
                            </div>
                          </div>
                          <div class="message-bubble p-2 rounded" :class="[message.sender === 'user' ? 'bg-primary text-white' : 'bg-light']">
                            <span class="content">{{ message.content }}</span>
                          </div>
                          <div class="message-time text-muted">
                            <small>{{ getFormattedTime(message.timestamp) }}</small>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="shadow-lg p-2  d-flex gap-1">
                      <button class="btn"><i class="bi text-25px text-success bi-image"></i></button>
                      <button class="btn"><i class="bi text-25px text-success bi-telephone"></i></button>
                      <input type="text" v-model="newMessage" @keyup.enter="sendMessage" class="form-control w-100" placeholder="Type your message..." />
                      <button class="btn" @click="sendMessage"><i class="bi text-25px text-success bi-send-arrow-up"></i></button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      messages: [],
      newMessage: '',
      userProfilePicture: './assets/coca-team.jpg',
      otherUserProfilePicture: './assets/coca-team.jpg',
      userName: 'Coca Team',
      otherUserName: 'SREYNUCH LOVE',
    };
  },
  methods: {
    sendMessage() {
      if (this.newMessage.trim() !== '') {
        this.messages.push({
          id: this.messages.length,
          sender: 'user',
          content: this.newMessage,
          timestamp: new Date().getTime(),
        });
        this.newMessage = '';

        // Simulate assistant response after 1 second
        setTimeout(() => {
          this.messages.push({
            id: this.messages.length,
            sender: 'assistant',
            content: 'I Love you',
            timestamp: new Date().getTime(),
          });
        }, 1000);
      }
    },
    getFormattedTime(timestamp) {
      const date = new Date(timestamp);
      const hours = date.getHours();
      const minutes = date.getMinutes();
      return `${hours}:${minutes.toString().padStart(2, '0')}`;
    },
  },
};
</script>