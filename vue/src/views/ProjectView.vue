<template>
<div class="project">
    <h2>Projet: {{name}}</h2>
    <div class="technologies">
      <h3>liste des technologies</h3>
      <div class="technology" v-for="technlogy, i in technologies" :key="i">
        <p>{{technlogy.name}}</p>
      </div>
      <h4>Liste des contribution</h4>
      <div class="contributions">
        <div class="contribution" v-for="contribution, i in contributions" :key="i">
          <p>Membre ayant contribué sur le projet: {{contribution.member.firstname}} {{contribution.member.lastname}} 
             technologie employée: <span>{{contribution.technology.name}}</span></p>
        </div>
      </div>
    </div>
    <button @click="showForm = !showForm" >Modifier le projet</button>
    <div class="form" v-show="showForm">
        <div class="error" v-if="error"> {{error}} </div>
        <input 
          type="text"
          v-model="name" 
          required="required" 
          placeholder="Nom du projet"
          >
        <vueMultiSelect
          ref="vue-multi-select"
          v-model="values"
          :options="options"
          :selectOptions="data"
          />
        <button @click="modifyProject">Soummetre le formulaire</button>  
    </div>      
</div>
    
</template>

<script>

import serverFile from '../api/serverFile.vue'
import vueMultiSelect from 'vue-multi-select';
import 'vue-multi-select/dist/lib/vue-multi-select.css';
import {settings} from "./../config/variables";
import {slugify} from './../utils/slug';

export default {
  components: {
    vueMultiSelect,
  },
  data() {
    return {
      id: this.$route.params.id,
      name :this.$route.params.name,
      technologies: [],
      contributions: [],
      slug: "",
      error: "",
      addTechnologies: [],
      selectedTechnologies: [],
      showForm: false,
      values: [],
      options: {
          multi: true,
          groups: true,
      },
      data: [{
        name: 'technologies',
        list: [],
        
      }],
    } 
  },
  methods: {
    getDataProject(id) {
      console.log(this.id)
      serverFile.getDataProject(id).then((response) => {
        this.technologies = response['hydra:member'][0].technologies
        this.contributions = response['hydra:member'][0].contributions
        this.values = this.technologies
      })
    },
    getTechnologies() {
      serverFile.getAllTechnologies().then((response) => {
        this.data[0].list = response['hydra:member']
      })
    },
    modifyProject() {
      this.selectedTechnologies.map((technologie) => {
        this.addTechnologies.push(settings.PATH_TECHNOLOGIES + technologie.id)
      })
      this.slugName = slugify(this.name)
      let params = {
        "name": this.name,
        "technologies": this.addTechnologies,
        "slug": this.slugName
      }
      serverFile.modifyProject(this.id, params).then((response) => {
        if (response) {
          this.showFormulaire = !this.showFormulaire
          this.name = ""
          this.technologies = ""
          this.slug = ""
          this.addTechnologies = []
          this.getDataProject(this.id)
        }
      }).catch((err) => {
        if (err) {
          console.log(err)
          this.error = "Une erreur est survenu veuillez vérifier les informations renseignées."
        }
      })
    },
  },
  mounted: function() {
    this.getTechnologies()
    this.getDataProject(this.id)
  }
}
</script>
