<template>
  <div class="container">
    <div class="left">
      <img :src="user.image" alt="Img" />
      <div class="img">
        <img
          src="https://i.pinimg.com/originals/61/54/18/61541805b3069740ecd60d483741e5bb.jpg"
          alt="camera"
        />
      </div>
    </div>
    <div class="right">
      <div class="left2">
        <div class="info">
          <label>Role:</label>
          <input type="text" v-model="user.role" class="info-value" />
        </div>
        <div class="info">
          <label>User Name:</label>
          <input type="text" v-model="user.name" class="info-value" />
        </div>
        <div class="info">
          <label>Email:</label>
          <input type="text" v-model="user.email" class="info-value" />
        </div>
        <div class="info">
          <label>Phone Number:</label>
          <input type="text" v-model="user.phone" class="info-value" />
        </div>
        <div class="info">
          <label>Create Date:</label>
          <input type="text" v-model="user.createDate" class="info-value" />
        </div>
        <div class="info">
          <label>Create Time:</label>
          <input type="text" v-model="user.createTime" class="info-value" />
        </div>
      </div>
      <router-link to="/service/profile">
        <button type="button" class="btn" style="background-color: gray;">Cancel</button> </router-link>
        <router-link to="/service/profile">
            <button type="button" class="btn button2" > Update </button>
        </router-link>                                                            
        
    </div>
    <router-link/>
  </div>
</template>


<script>
export default {
  data() {
    return {
      user: {
        role: 'admin',
        name: 'Admin',
        email: 'admin@gmail.com',
        phone: '123-456-7890',
        createDate: '2024-06-24',
        createTime: '08:18:17',
        image: 'https://i.pinimg.com/564x/58/b6/52/58b6528f3b6c1b77a119f9efc2ef8f61.jpg'
      }
    }
  }
}
</script>

<style>
.container {
  display: flex;
  height: 80vh;
  margin-top: 30px;
}
#jj {

  margin-left: -70px;
}
.left {
  width: 40%;
  /* background-color: rgb(200, 197, 197); */
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.right {
  width: 60%;
  /* background-color: rgb(224, 208, 211); */
  height: 100%;
}
.left img {
  height: 50%;
  width: 50%;
  border-radius: 20px;

}
.left2 {
  float: left;
  width: 60%;
  height: 100%;
  padding-top: 13%;
 
}
.right button {
  border: 1px solid;
  padding: 5px 10px;
  margin-top: 55%;
  background-color: orange;
  border-radius: 5px;
  gap: 20px;
}
.left2 label {
  display: block;
  font-weight: bold;

}
.info {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}
.info-value {
  flex: 1;
  text-align: start;
  margin-left: 50px;
}
.info label {
  width: 120px;
  margin-top: 5px;
}
.img {
  position: absolute;
  bottom: 140px;
  right: 0;
  width: 10%;
  height: 15%;
  margin-right: 63%;

}
input {
  width: 100%;
  padding: 7px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 14px;
  color: #333;
  transition: border-color 0.3s ease;
  
}

input:hover,
input:focus {
  outline: none;
  border-color: #666;
}
.button2{
    margin-left: 10px;
}
</style>