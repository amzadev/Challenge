<template>
  <header class="header">
    <div class="brand">
    <div class="logo">
      
      <img src="https://cdn2.iconfinder.com/data/icons/pittogrammi/142/95-512.png" alt="LEGO Logo" />
    </div>
    <div class="title">
      <h1>Urlshorts</h1>
    </div>
    </div>
    <div class="dropdown">

      <Dropdown />

    </div>
  </header>
</template>

<script>
import Dropdown from './Dropdown.vue';

export default {
  components: {
    Dropdown,
  },
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background-color: #fff; 
  color: #000; 
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
border-bottom: 4px solid #fff;
}

.brand {
  display: flex;
  justify-content: center;
  align-items: center;
}

.logo img {
  max-width: 50px;
}

.title {
  text-align: center;
  flex-grow: 1;
  font-weight:800;
  font-size:25px;
  color: #00acee;
}


</style>
