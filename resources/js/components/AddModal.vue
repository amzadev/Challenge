<template>
    <div class="modal-overlay" v-if="showModal">
      <div class="modal">
        <div class="modal-header">
          <h2 class="title">{{ title }}</h2>
          <button @click="closeModal">X</button>
        </div>
        <div class="modal-content">
          <form @submit.prevent="shortenUrl" v-if="step">
            <div class="form-group inline-input">
                <input type="text" id="input" v-model="form.url" />
                <button type="submit">shorten</button>
              </div>
                     <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{errors}}</p>

          </form>
          <div v-else>
          Shortened url : {{ short_url }}
         </div>

        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { reactive, ref } from 'vue';
import {request} from '../helper'
import {useRouter} from "vue-router";

  export default {
    props: {
      showModal: Boolean,
      title: String,
    },
   
    methods: {
      closeModal() {
        this.refrech()
        this.$emit('close');
      },
      submitForm() {
        
        console.log(this.form);
      },
    },

    setup(){
        const errors = ref()
        const step = ref(true);
        const short_url = ref();
        const original_url = ref();
        const router = useRouter();
        const form = reactive({
            url: '',
        })
        const shortenUrl = async () => {
            try {
                const result = await request('post', '/api/url/shortner', form)
                if (result.status === 201 && result.data) {
                   original_url.value = result.data.data.original_url
                   short_url.value = result.data.data.shortned_url
                   step.value = !step.value;
                }
            } catch (e) {
              console.log(e);
                if(e && e.data && e.data.errors) {
                    errors.value = Object.values(e.data.errors)
                } else {
                    errors.value = e.data.message || ""
                }
            }
        }

       const refrech =  async () => {
          await router.push('/home')
        
      }

        return {
            form,
            errors,
            shortenUrl,
            step,
            short_url,
            refrech,
        }
      }
  };
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .title{
    font-size: 20px;
    font-weight: 700;
  }
  
  .modal {
    background: #fff;
    width: 50%;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
  }
  
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .modal-header h2 {
    margin: 0;
  }
  
  .modal-header button {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
  }
  
  .form-group {
    margin-bottom: 16px;
    margin-top: 16px;

  }
  
  .form-group.inline-input {
  display: flex;
  align-items: center;
}

.form-group.inline-input input[type="text"] {
  flex: 1;
}

  label {
    display: block;
    font-weight: bold;
  }
  
  input[type="text"] {
    width: 100%;
    padding: 7px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .form-actions {
    text-align: right;
  }
  
  button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  @media (max-width: 768px) {
  .modal {
    width: 95%;
  }
}
  </style>
  