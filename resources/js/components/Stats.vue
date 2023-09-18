<template>
 <div class="section-title">
 <h3 class="hd">OverView</h3>
 </div>
  <div class="dashboard">
    <div class="stats-card">
      <div class="title">Total Visits</div>
      <div class="value">{{ totalVisits }}</div>
    </div>
    <div class="stats-card">
      <div class="title">Unique Visitors</div>
      <div class="value">{{ uniqueVisitors }}</div>
    </div>
    <div class="stats-card">
      <div class="title">Total URLs</div>
      <div class="value">{{ totalUrls }}</div>
    </div>
    <div class="most-visited-urls">
      <div class="title">Most Visited URLs</div>
      <ul>
        <li v-for="(urlItem, index) in topUrls" :key="index" class="url-item">
          <span class="url">{{ urlItem.shortned_url }}</span>
          <span class="visits">{{ urlItem.click_count }} visits</span>
        </li>
      </ul>
    </div>
    <p class="list-disc text-red-400 mt-4 text-center" v-if="typeof errors === 'string'">{{errors}}</p>

  </div>
</template>

<script>
import {request} from '../helper'
  import { onMounted, ref } from 'vue';

export default {
  
  setup(){
    const errors = ref()
    const totalVisits = ref()
    const topUrls = ref([])
    const uniqueVisitors = ref()
    const totalUrls = ref()

    onMounted(() => {
      getStats()
      });

    const getStats = async () => {
      try {
        const result = await request('get', '/api/statistics')
         if(result.status && result.data) {
          console.log(result.data)
          totalVisits.value = result.data.totalVisits
          topUrls.value = result.data.topUrls
          uniqueVisitors.value = result.data.uniqueVisitors
          totalUrls.value = result.data.totalUrls
         }
      } catch (e) {
        if(e && e.data && e.data.errors) {
                    errors.value = Object.values(e.data.errors)
                } else {
                    errors.value = e.data || ""
                }
      }
    }

    return {
      totalVisits,
      topUrls,
      uniqueVisitors,
      totalUrls,
      errors,
    }
  }
};
</script>

<style scoped>
.section-title {
  margin-top: 20px;
  margin-bottom: 10px;
  padding: 1rem;
}

.hd {
  font-size: 25px;
  font-weight: bold;
}

.dashboard {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1rem;
  padding: 1rem;

}

.stats-card {
  background-color: #fff;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center; 
  align-items: center; 
  text-align: center;
}

.title {
  font-size: 18px;
  font-weight: bold;
  color: #00acee;
}

.value {
  font-size: 24px;
  color: #888;
  font-weight: bold;
}

.most-visited-urls {
  background-color: #fff;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

ul {
  list-style: none;
  padding: 0;
}

.url-item {
  display: flex;
  justify-content: space-between;
  margin: 0.5rem 0;
}

.url {
  font-weight: bold;
}

.visits {
  color: #888;
  font-weight: bold;
}

</style>
