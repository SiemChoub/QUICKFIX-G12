<template>
  <div class="box">
    <div class="box__ghost">
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>
      <div class="symbol"></div>

      <div class="box__ghost-container">
        <div class="box__ghost-eyes">
          <div class="box__eye-left"></div>
          <div class="box__eye-right"></div>
        </div>
        <div class="box__ghost-bottom">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
      <div class="box__ghost-shadow"></div>
    </div>

    <div class="box__description">
      <div class="box__description-container">
        <div class="box__description-title">Whoops! 404</div>
        <div class="box__description-text">It seems like we couldn't find the page you were looking for</div>
      </div>
    <router-link to="/" class="box__button">Go back</router-link>

    </div>
  </div>
</template>
<script>
import $ from 'jquery'; 

export default {
  mounted() {
    let pageX = $(document).width();
    let pageY = $(document).height();
    let mouseY = 0;
    let mouseX = 0;

    $(document).mousemove(function(event) {
      mouseY = event.pageY;
      let yAxis = (pageY / 2 - mouseY) / pageY * 300;

      mouseX = event.pageX / -pageX;
      let xAxis = -mouseX * 100 - 100;

      $('.box__ghost-eyes').css({
        transform: `translate(${xAxis}%, -${yAxis}%)`
      });
    });
  }
}
</script>
<style scoped>
html, body {
  background: #28254C; 
  font-family: 'Ubuntu', sans-serif;
}

.box {
  width: 350px;
  max-height: 600px;
  min-height: 450px;
  background: #332F63;
  border-radius: 20px;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  padding: 30px 50px;
}

.box__ghost {
  padding: 15px 25px 25px;
  position: absolute;
  left: 50%;
  top: 30%;
  transform: translate(-50%, -30%);
}

.symbol {
  position: relative;
  opacity: 0.2;
  animation: shine 4s ease-in-out 3s infinite;
}

.symbol:nth-child(1) {
  &:before, &:after {
    content: '';
    width: 12px;
    height: 4px;
    background: #fff;
    position: absolute;
    border-radius: 5px;
    bottom: 65px;
    left: 0;
  }
  &:before {
    transform: rotate(45deg);
  }
  &:after {
    transform: rotate(-45deg);
  }
}

.symbol:nth-child(2) {
  position: absolute;
  left: -5px;
  top: 30px;
  height: 18px;
  width: 18px;
  border: 4px solid #fff;
  border-radius: 50%;
  opacity: 0.2;
  animation: shine 4s ease-in-out 1.3s infinite;
}

.symbol:nth-child(3) {
  opacity: 0.2;
  animation: shine 3s ease-in-out 0.5s infinite;
  &:before, &:after {
    content: '';
    width: 12px;
    height: 4px;
    background: #fff;
    position: absolute;
    border-radius: 5px;
    top: 5px;
    left: 40px;
  }
  &:before {
    transform: rotate(90deg);
  }
  &:after {
    transform: rotate(180deg);
  }
}

.symbol:nth-child(4) {
  opacity: 0.2;
  animation: shine 6s ease-in-out 1.6s infinite;
  &:before, &:after {
    content: '';
    width: 15px;
    height: 4px;
    background: #fff;
    position: absolute;
    border-radius: 5px;
    top: 10px;
    right: 30px;
  }
  &:before {
    transform: rotate(45deg);
  }
  &:after {
    transform: rotate(-45deg);
  }
}

.symbol:nth-child(5) {
  position: absolute;
  right: 5px;
  top: 40px;
  height: 12px;
  width: 12px;
  border: 3px solid #fff;
  border-radius: 50%;
  opacity: 0.2;
  animation: shine 1.7s ease-in-out 7s infinite;
}

.symbol:nth-child(6) {
  opacity: 0.2;
  animation: shine 2s ease-in-out 6s infinite;
  &:before, &:after {
    content: '';
    width: 15px;
    height: 4px;
    background: #fff;
    position: absolute;
    border-radius: 5px;
    bottom: 65px;
    right: -5px;
  }
  &:before {
    transform: rotate(90deg);
  }
  &:after {
    transform: rotate(180deg);
  }
}

.box__ghost-container {
  background: #fff;
  width: 100px;
  height: 100px;
  border-radius: 100px 100px 0 0;
  position: relative;
  margin: 0 auto;
  animation: upndown 3s ease-in-out infinite;
}

.box__ghost-eyes {
  position: absolute;
  left: 50%;
  top: 45%;
  height: 12px;
  width: 70px;
}

.box__eye-left, .box__eye-right {
  width: 12px;
  height: 12px;
  background: #332F63;
  border-radius: 50%;
  margin: 0 10px;
  position: absolute;
}

.box__eye-left {
  left: 0;
}

.box__eye-right {
  right: 0;
}

.box__ghost-bottom {
  display: flex;
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
}

.box__ghost-bottom div {
  flex-grow: 1;
  position: relative;
  top: -10px;
  height: 20px;
  border-radius: 100%;
  background-color: #fff;
}

.box__ghost-bottom div:nth-child(2n) {
  top: -12px;
  margin: 0 -0px;
  border-top: 15px solid #332F63; /* Lighter purple */
  background: transparent;
}

.box__ghost-shadow {
  height: 20px;
  box-shadow: 0 50px 15px 5px #3B3769;
  border-radius: 50%;
  margin: 0 auto;
  animation: smallnbig 3s ease-in-out infinite;
}

.box__description {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
}

.box__description-container {
  color: #fff;
  text-align: center;
  width: 200px;
  font-size: 16px;
  margin: 0 auto;
}

.box__description-title {
  font-size: 24px;
  letter-spacing: .5px;
}

.box__description-text {
  color: #8C8AA7; 
  line-height: 20px;
  margin-top: 20px;
}

.box__button {
  display: block;
  position: relative;
  background: orange; 
  border: 1px solid transparent;
  border-radius: 50px;
  height: 50px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  line-height: 50px;
  font-size: 18px;
  padding: 0 70px;
  white-space: nowrap;
  margin-top: 25px;
  transition: background .5s ease;
  overflow: hidden;
  -webkit-mask-image: -webkit-radial-gradient(white, black);
}

.box__button:before {
  content: '';
  position: absolute;
  width: 20px;
  height: 100px;
  background: #fff;
  bottom: -25px;
  left: 0;
  border: 2px solid #fff;
  transform: translateX(-50px) rotate(45deg);
  transition: transform .5s ease;
}

.box__button:hover {
  background: transparent;
  border-color: #fff;
}

/* Keyframes */
@keyframes upndown {
  0% { transform: translateY(5px); }
  50% { transform: translateY(15px); }
  100% { transform: translateY(5px); }
}

@keyframes smallnbig {
  0% { width: 90px; }
  50% { width: 100px; }
  100% { width: 90px; }
}

@keyframes shine {
  0% { opacity: 0.2; }
  25% { opacity: 0.1; }
  50% { opacity: 0.2; }
  100% { opacity: 0.2; }
}
</style>
