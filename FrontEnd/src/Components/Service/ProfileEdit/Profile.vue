<template>
  <div class="custom-container">
    <div class="custom-left">
      <img
        :src="users.profile"
        alt="Profile Image"
      />
      <div class="custom-img">
        <label for="fileInput">
          <img 
            src="https://i.pinimg.com/originals/61/54/18/61541805b3069740ecd60d483741e5bb.jpg"
            alt="camera"
            style="cursor: pointer;"
          />
        </label>
        <input type="file" id="fileInput" style="display: none;" @change="handleFileInputChange">
      </div>
    </div>
    <div class="custom-right">
      <div class="custom-left2">
        <div class="custom-info">
          <label>Role:</label>
          <span class="custom-info-value">{{ users.role }}</span>
        </div>
        <div class="custom-info">
          <label>User Name:</label>
          <span class="custom-info-value">{{ users.name }}</span>
        </div>
        <div class="custom-info">
          <label>Email:</label>
          <span class="custom-info-value">{{ users.email }}</span>
        </div>
        <div class="custom-info">
          <label>Phone Number:</label>
          <span class="custom-info-value">{{ users.phone }}</span>
        </div>
        <div class="custom-info">
          <label>Create Date:</label>
          <!-- <span class="custom-info-value">{{ users.createDate }}</span> -->
        </div>
        <div class="custom-info">
          <label>Create Time:</label>
          <!-- <span class="custom-info-value">{{ users.createTime }}</span> -->
        </div>
        
      </div>
      <router-link to="/Service">
        <button type="button" class="custom-b" style="background-color: gray;" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Back
        </button>
      </router-link>
      <router-link to="/profile/edit">
        <button type="button" class="custom-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Edit Information
        </button>
      </router-link>
    </div>
  </div>
</template>

<script>
// export default {
//   data() {
//     return {
//       user: {
//         role: 'admin',
//         name: 'Admin',
//         email: 'admin@gmail.com',
//         phone: '123-456-7890',
//         createDate: '2024-06-24',
//         createTime: '08:18:17',
//         image: 'https://i.pinimg.com/564x/58/b6/52/58b6528f3b6c1b77a119f9efc2ef8f61.jpg'
//       }
//     };
//   },
//   methods: {
//     handleFileInputChange(event) {

//       const file = event.target.files[0].name;
//       console.log(file);
//       document.getElementById('fileInput').textContent = file.name;
//       }
//     }
// };
import axios from 'axios'
export default {
  data() {
    return {
      users:[] 
    }
  },
  mounted() {
    this.GetData();
  },
  methods: {
    GetData() {
      axios
        .get('http://127.0.0.1:8000/api/list')
        .then((response) => {
          console.log(response.data.data[0]);
          this.users = response.data.data[0]
        })
        .catch((error) => {
          console.error('Error:', error.response)
        })
    },
    Profile() {
      axios
        .post('http://127.0.0.1:8000/api/update/profile')
        .then((response) => {
          console.log(response.data.data[0]);
          this.users = response.data.data[0]
        })
        .catch((error) => {
          console.error('Error:', error.response)
        })
    },
    loginWithFacebook() {
      console.log('Logging in with Facebook')
    },
    loginWithGoogle() {
      console.log('Logging in with Google')
    },
    handleFileInputChange(event) {

      const file = event.target.files[0].name;
      console.log(file);
      document.getElementById('fileInput').textContent = file.name;
      }
    }
  }
</script>

<style>
.custom-container {
  display: flex;
  height: 80vh;
  margin-top: 30px;
  background: #b6b3b3;
  border-radius: 5px;
}

.custom-left {
  width: 40%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.custom-right {
  width: 60%;
  height: 100%;
}

.custom-left img {
  height: 50%;
  width: 50%;
  border-radius: 20px;
}

.custom-left2 {
  float: left;
  width: 50%;
  height: 100%;
  padding-top: 12%;
  padding-left: 20px;
}

.custom-btn {
  border: 1px solid orange;
  padding: 5px 10px;
  margin-top: 45%;
  background: orange;
  border-radius: 5px;
  
}
.custom-b{
  margin-right: 20px;
  padding: 5px 10px;
  border-radius: 5px;
  border: 1px solid gray;
}

.custom-left2 label {
  display: block;
  font-weight: bold;
}

.custom-info {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.custom-info-value {
  flex: 1;
  text-align: start;
  margin-left: 50px;
}

.custom-info label {
  width: 120px;
  margin-top: 5px;
}

.custom-img {
  position: absolute;
  bottom: 155px;
  right: 0;
  width: 10%;
  height: 15%;
  margin-right: 63%;
}
</style>