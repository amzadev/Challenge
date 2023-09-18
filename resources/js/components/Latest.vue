<template>
  <h3 class="hd">Previously shortened URLs</h3>
        <p class="list-disc text-red-400 mt-4 text-center" v-if="typeof errors === 'string'">{{errors}}</p>
        <div v-if="urlsList.length === 0">
      <p>The list is empty.</p>
    </div>
    <div class="table-container"  v-else>
  
      <table>
        <thead>
          <tr>
            <th>Original URL</th>
            <th>Shortened URL</th>
            <th>Total Visits</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(url, idx) in urlsList" :key="url.id">
            <td>{{ url.original_url }}</td>
            <td><a :href="url.shortned_url" class="surl" target="_blank">{{ url.shortned_url }}</a></td>
            <td v-if="url.statistic !== null">{{ url.statistic.click_count }}</td>
            <td v-else>0</td>
            <td><button @click="deleteUrl(url, idx)" class="bg-red-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"><i class="fas fa-times"></i></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import {request} from '../helper'
  import { onMounted, ref } from 'vue';

  export default {
    
    setup(){

      const urlsList = ref([])

      onMounted(() => {
        fetchUrls()
        });

      const fetchUrls = async () => {
        try {
        const result = await request('get', '/api/url/previous')
         if(result.status && result.data) {
          console.log(result.data)
          urlsList.value = result.data.data
         }
        } catch(e) {
             if(e && e.data && e.data.errors) {
                    errors.value = Object.values(e.data.errors)
                } else {
                    errors.value = e.data.message || ""
                }
        }
      }

      const deleteUrl = async (val, index) => {
        if (window.confirm("Are you sure")) {
                try {
                    const req = await request('delete', `/api/url/delete/${val.id}`)
                    if (req.data.status) {
                        urlsList.value.splice(index, 1)
                    }
                } catch (e) {
                    
                }
            }
      }


      return {
        urlsList,
        deleteUrl,
      }
    }
  };
  </script>
  
  <style scoped>
  .surl {
    color: rgb(0, 42, 255);
  }
  .table-container {
    overflow-x: auto; 
    padding: 10px;
  }


.hd {
    margin-top: 20px;
    margin-bottom: 30px;
  font-size: 25px;
  font-weight: bold;
  padding: 1rem;
}
  
  table {
    width: 100%;
    border-collapse: collapse;
    
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  thead {
    background-color: #f2f2f2;
  }
  
  table tbody td:nth-child(1) {
    max-width: 300px; 
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; 
}
  
  </style>
  