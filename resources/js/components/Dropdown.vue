<template>

  <div class="dropdown-menu px-3">
  <button
                    class="bg-blue-500 hover:bg-blue-900 text-white font-bold mr-3 py-2 px-4 rounded"
                    @click="openModal"
                >
                   Add URL
                </button>
                      <a href="#" @click="logout"  class="font-bold">Logout <i class="fas fa-sign-out-alt"></i></a>
    
  </div>
  <modal :show-modal="modalVisible" title="Paste the URL to be shortened" @close="closeModal">
      
      <p>modal content.</p>
    </modal>
</template>

<script>
import Modal from './AddModal.vue';
import {useRouter} from "vue-router";

export default {
  components: {
    Modal,
  },
  data() {
    return {
      modalVisible: false,
    };
  },
  methods: {
    openModal() {
      this.modalVisible = true;
    },
    closeModal() {
      this.modalVisible = false;
    },
  },
  setup(){
            const router = useRouter();
     const logout = async () => {
      localStorage.removeItem('authToken');
                    await router.push('/')
        }
        return {
            logout,
        }
  }
};
</script>

<style scoped>
.dropdown-menu {
background-color:#fff;
display: flex;
justify-content : space-around;
align-items: center;
}

.dropdown-menu ul {
  list-style: none;
  padding: 0;
}

.dropdown-menu li {
  margin: 0.5rem 0;
}

.dropdown-menu a {
  text-decoration: none;
  color: #333; 
}


</style>
