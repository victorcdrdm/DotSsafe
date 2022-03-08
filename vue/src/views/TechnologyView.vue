<template>
  <div class="technology">
    <h2>technlogie: {{name}}</h2>
    <div class="contributions">
      <h3>Contributions</h3>
        <div class="contribution" v-for="contribution, i  in contributions" :key="i">
          {{contribution.member.firstname}} {{contribution.member.lastname}} {{contribution.project.name}}
        </div>
    </div>
    <button @click="showForm = !showForm" >Modifier le project</button>
    <div class="update" v-show="showForm">
      <input type="text" v-model="name">
      <button @click="updateTechnology">Mettre a jour la technologie</button>
    </div>
  </div>
</template>

<script>

import serverFile from '../api/serverFile.vue'

export default ({
  data() {
    return {
      id: this.$route.params.id,
      name: '',
      contributions: [],
      showForm: false,
    }  
  },
  methods: {
    getDataTechnology() {
      this.contributions = []
      serverFile.getTechnology(this.id).then((response) => {
        let results = response.contributions
        results.map((result) => {
          let id = result.replace(/[^\d]/g, "")
          serverFile.getDataContribution(id).then((response) => {
            let contribution = response['hydra:member'][0]
            this.contributions.push(contribution)
          })
        })
      })
    },
    updateTechnology() {
      let params = { 'name': this.name }
      serverFile.updateTechnology(this.id, params).then((response) => {
        if(response) {
          this.getDataTechnology()
          this.name = params.name
        }
      })
    }
  },
  mounted: function() {
  this.getDataTechnology()
  this.name = this.$route.params.name
  }
})
</script>
