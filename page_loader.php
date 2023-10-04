<style>

.loading-screen {
  width: 100vw;
  height: 100vh;
  background: #000;
  position: fixed;
  top: 0;
  z-index: 1001;
}

.loading-screen .ring {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 150px;
  height: 150px;
  background: transparent;
  border: 3px solid #3c3c3c;
  border-radius: 50%;
  text-align: center;
  line-height: 150px;
  font-size: 20px;
  color: #fff000;
  letter-spacing: 4px;
  text-shadow: 0 0 10px #fff000;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

.loading-screen .ring:before {
  content: "";
  position: absolute;
  top: -3px;
  left: -3px;
  width: 150px;
  height: 150px;
  border-top: 3px solid #fff000;
  border-right: 3px solid #fff000;
  border-radius: 50%;
  animation: animateC 2s linear infinite;
}

.loading-screen .ring span {
  display: block;
  position: absolute;
  top: calc(50% - 2px);
  left: 50%;
  width: 50%;
  height: 4px;
  background: transparent;
  transform-origin: left;
  animation: animate 2s linear infinite;
}

.loading-screen .ring span:before {
  content: "";
  position: absolute;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background-color: #fff000;
  top: -6px;
  right: -8px;
  box-shadow: 0 0 20px #fff000;
}

@keyframes animateC {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes animate {
  0% {
    transform: rotate(45deg);
  }
  100% {
    transform: rotate(405deg);
  }
}

</style>


<div class="loading-screen">
    <div class="ring">
        LOADING
        <span></span>
    </div>
</div>

<script>
    window.onload= () =>{
        document.querySelector(".loading-screen").style.display = "none";
    }

</script>