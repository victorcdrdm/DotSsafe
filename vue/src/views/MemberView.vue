<template>
  <div class="member">
    <h2>{{firstname}} {{lastname}}</h2>
    <h3>technologies</h3>
    <div>
    <div  class="technologies" v-for="technology, key ,j in technologies" :key="j">
      {{key}} {{technology}}
    </div>
    </div>
    <h3>contributions</h3>
    <div class="contribution" v-for="contribution, i in contributions" :key="i">
      {{contribution.project.name}} {{contribution.technology.name}}
    </div>
    <button @click="showForm = !showForm">Modifier le profile</button>
    <div  class='form' v-show="showForm">
      <input type="text" v-model="firstname">
      <input type="text" v-model="lastname">
      <input type="text" v-model="email">
      <button @click="updateProfile">Mettre a jour les informations</button>
    </div>
  </div>
</template>

<script>

import serverFile from "../api/serverFile.vue"

export default ({
  data() {
    return {
      lastname: this.$route.params.name,
      firstname: '',
      email: '',
      id: this.$route.params.id,
      member: [],
      contributions: [],
      technologies: [],
      showForm: false
    }
  },
  methods: {
    getMember() {
      serverFile.getMember(this.id).then((response) => {
        this.member = response
        this.lastname = response.lastname
        this.firstname = response.firstname
        this.email = response.email
        let results = response.contributions
        results.map((result) => {
          let id = result.replace(/[^\d]/g, "")
          serverFile.getDataContribution(id).then((response) => {
            let result = response['hydra:member'][0]
            this.contributions.push(result)
            this.technologies.push(result.technology)
          }) 
        })
      })
    },
    numberContibutionForTechnologie() {
    let arr = []
    this.technologies.map((technology)=>{
       arr.push(technology.name)
    })
    const map = arr.reduce((acc, curr) => (acc[curr] = (acc[curr] || 0) + 1, acc), {});
    this.technologies = map
    },
    updateProfile() {
      let params = {
        'firstname' : this.firstname, 
        'lastname' : this.lastname,
        'email' : this.email,
      }
      serverFile.updateProfile(this.id, params).then((response) => {
        if (response) {
          this.showForm = false
        }
      })
    }
  },  
  mounted: function() {
    this.getMember()
   setTimeout(() => {
      this.numberContibutionForTechnologie()
   },200)
   }
})
</script>
