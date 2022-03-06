<template>
  <div class="technolgies">
    <h2>Technologies</h2>
    <button @click="showForm = !showForm" >Ajouter une nouvelle Technologie</button>
    <div class="form" v-show="showForm">
      <div class="error" v-if="error"> {{error}} </div>
      <form>
        <input
          type="text" 
          v-model="name"
          placeholder="Nom de la technologie"
          required
          >
      </form>
      <button @click="newTechnologies">Envoyers</button>
    </div>
    <div class="technologies" v-for="technology in technologies" :key="technology.id">
      <router-link :to="{ name: 'Technology', params: {name: technology.name, id:technology.id }}">
        {{ technology.name }}
      </router-link>
    </div>
  </div>
</template>

<script>

import serverFile from './../api/serverFile.vue'

export default {
  data() {
    return {
      name: "",
      error: "",
      showForm: false,
      technologies: [],
    }
  },
  methods: {
    newTechnologies() {
      let params = {
        "name": this.name
      }
      serverFile.newTechnologies(params).then((response) => {
        if (response) {
          this.showForm = !this.showForm
          this.name = ""
          this.getAllTechnologies()
        }
      }).catch((err) => {
        if (err) {
          this.error = "Une erreur est survenu veuillez vérifier les informations renseignées."
        }
      })
    },
    getAllTechnologies() {
      serverFile.getAllTechnologies().then((response) => {
        this.technologies = response['hydra:member']
      })
    }
  },
  mounted: function() {
    this.getAllTechnologies()
  }
}
</script>