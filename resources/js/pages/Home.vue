<template>
  <div>
    <Header />

    <div class="container">
      <Loader v-if="isLoading"/>
    
    <Stats />

    <Latest />
    </div>
    
  </div>
</template>

<script>
import Header from '../components/Header.vue';
import Stats from '../components/Stats.vue';
import {ref, onMounted} from 'vue'
import {useRouter} from "vue-router";
import {request} from '../helper'
import Loader from '../components/Loader.vue';
import Latest from '../components/Latest.vue';


export default {
  components: {
    Header, 
    Stats, 
    Loader,
    Latest,
  },

  setup(){
    const isLoading = ref()

  
       
  }

}
</script>

<style scoped>
  .container {
    width: 80%;
    margin: auto;
  }
  @media (max-width: 768px) {
    .container {
    width: 100%;
  }
}
</style>
