<template>
  <div class="projects">
    <h2>Tout les projets</h2>
    <button @click="showFormulaire = !showFormulaire">Ajouter un projet</button>
    <div class="form" v-show="showFormulaire">
      <form>
        <div class="error" v-if="error"> {{error}} </div>
        <input 
          type="text"
          v-model="name" 
          required="required" 
          placeholder="Nom du projet"
          >
        <vueMultiSelect
          ref="vue-multi-select"
          v-model="selectedTechnologies"
          :options="options"
          :selectOptions="data"
          />
      </form>
      <button @click="addProject">Envoyer le formulaire</button>
    </div>

    <button @click="toggleshow">
      {{ messagetoggle }} les filtres</button>
    <div class="filter" v-show="showFilters">
        <select v-model="filterTechnology">
          <option disable value="">Choisiez une technologie</option>
          <option v-for="technology in technologies" :key="technology.id" :value="technology">
            {{technology.name}}
          </option>
        </select>
        <select v-model="filterMember">
          <option disable value="">Choisiez un membre</option>
          <option v-for="member in members" :key="member.id" :value="member">
            {{member.firstname}} {{member.lastname}}
          </option>
        </select>
        <button @click="activeFilters">Ajouter des filtre</button>
    </div>

    <div class="projects" v-for="project in projects" :key="project.id" v-show="showProject">
      <router-link :to="{ name: 'Project', params: {name: project.name, id: project.id }}">
           {{project.name}}
      </router-link>
    </div>
    <div class="filterdProject" v-for="project in projectsFilterd" :key="project.name" v-show="showFilters">
        {{project.name}}
    </div>
  </div>
</template>

<script>

import serverFile from "./../api/serverFile.vue";
import {settings} from "./../config/variables";
import vueMultiSelect from 'vue-multi-select';
import 'vue-multi-select/dist/lib/vue-multi-select.css';
import {slugify} from './../utils/slug'; 

export default {
  name: 'HomeView',
  components: {
    vueMultiSelect,
  },
  data() {
    return {
      projects: [],
      members: [],
      showFormulaire: false,
      name: "",
      slugName: "",
      selectedTechnologies: [],
      technologies: [],
      addTechnologies: [],
      error: '',
      options: {
          multi: true,
          groups: true,
      },
      data: [{
        name: 'technologies',
        list: [],
      }],
      showProject: true,
      showFilters: false,
      showProjectFilterd: false,
      filterTechnology: "",
      filterMember: "",
      projectsFilterd: [],
      messagetoggle: 'Afficher',   
    } 
  },
  methods: {
    getProjects() {
      serverFile.getAllProjects().then((response) => {
        this.projects = response['hydra:member']
      })
    },
    addProject() {
      this.selectedTechnologies.map((technologie) => {
        this.addTechnologies.push(settings.PATH_TECHNOLOGIES + technologie.id)
      })
      this.slugName = slugify(this.name)
      let params = {
        "name": this.name,
        "technologies": this.addTechnologies,
        "slug": this.slugName
      }
      serverFile.addProject(params).then((response) => {
        if (response) {
          this.getProjects()
          this.showFormulaire = !this.showFormulaire
          this.name = ""
          this.technologies = ""
          this.slug = ""
          this.addTechnologies = []
        }
      }).catch((err) => {
        if (err) {
          this.error = "Une erreur est survenu veuillez vérifier les informations renseignées."
        }
      })
    }, 
    getTechnologies() {
      serverFile.getAllTechnologies().then((response) => {
        this.technologies = response['hydra:member']
        this.data[0].list = this.technologies
      })
    },
    activeFilters() {
      this.showProject = false
      this.showProjectFilterd = true
      this.projectsFilterd = []     
      if (this.filterTechnology) {
        this.projectsFilterd = this.findBYTechnology()
      }
      if (this.filterMember) { 
        this.projectsFilterd = this.findyByMembers()
      }
    },
    getMembers() {
      serverFile.getAllMembers().then((response) => {
          this.members = response['hydra:member']
      })
    },
    findBYTechnology() {
      let projects = []
      this.filterTechnology.projects.map((project) => {
        let id = project.replace(/[^\d]/g, "")
        serverFile.getProject(id).then((response) => {
          projects.push(response)
        })
      })
      return projects
    },
    findyByMembers () {
      let projects = []
      let idcheck = []
      this.filterMember.contributions.map((contribution) => {
        let id = contribution.replace(/[^\d]/g, "")
        serverFile.getDataContribution(id).then((response) => {
          let result = response['hydra:member'][0]
          if(this.filterTechnology) {
            if(this.filterTechnology.id === result.technology.id) {
              if (idcheck.length <= 0) {
              projects.push(result.project)
              idcheck.push(result.project.id)
            }
            if(idcheck.indexOf(result.project.id) < 0 ) {
              projects.push(result.project)
              idcheck.push(result.project.id)
              }
            }
          } else {
            if (idcheck.length <= 0) {
              projects.push(result.project)
              idcheck.push(result.project.id)
            }
            if(idcheck.indexOf(result.project.id) < 0 ) {
              projects.push(result.project)
              idcheck.push(result.project.id)
            }
          }
        })
      })
      return projects
    },
    toggleshow (){
      this.showFilters = !this.showFilters
      this.showProject = !this.showProject
      if( this.showProject === true) {
        this.messagetoggle = 'Afficher'
      } else {
        this.messagetoggle = 'Masquer'
      }
    }
  },
 
  mounted: function() {
    this.getProjects(),
    this.getTechnologies()
    this.getMembers()
  },
  
}
</script>

<style lang="scss">
  form{
    display: flex;
    flex-direction: column;
    width: 250px;
    text-align: center;
    margin: auto;
    button{
      width: 250px;
    }
  }
  form > *{
    margin-top: 5px;
  }
</style>
