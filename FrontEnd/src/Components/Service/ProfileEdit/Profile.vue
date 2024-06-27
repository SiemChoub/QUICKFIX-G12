<template>
  <div class="container">
    <div class="left">
      <img
        :src="user.image"
        alt="Img"
      />
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
          <span class="info-value">{{ user.role }}</span>
        </div>
        <div class="info">
          <label>User Name:</label>
          <span class="info-value">{{user.name}}</span>
        </div>
        <div class="info">
          <label>Email:</label>
          <span class="info-value">{{ user.email }}</span>
        </div>
        <div class="info">
          <label>Phone Number:</label>
          <span class="info-value">{{user.phone}} </span>
        </div>
        <div class="info">
          <label>Create Date:</label>
          <span class="info-value">{{user.createDate}}</span>
        </div>
        <div class="info">
          <label>Create Time:</label>
          <span class="info-value">{{user.createTime}}</span>
        </div>
      </div>
      <router-link to="/profile/edit"><button type="button" id="jj" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Edit information
      </button></router-link>
    </div>
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
    };
  }
}
</script>

<style>
.container {
  display: flex;
  height: 80vh;
  margin-top: 30px;
  background: #b6b3b3;
  border-radius: 5px;
}

.left {
  width: 40%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
 
}
.right {
  width: 60%;
  height: 100%;
}
.left img {
  height: 50%;
  width: 50%;
  border-radius: 20px;

}
.left2 {
  float: left;
  width: 50%;
  height: 100%;
  padding-top: 12%;
  padding-left: 20px;
}
#jj {
  border: 1px solid orange;
  padding: 5px 10px;
  margin-top: 45%;
  background: orange;
  border-radius: 5px;

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
  bottom: 155px;
  right: 0;
  width: 10%;
  height: 15%;
  margin-right: 63%;

}
</style>