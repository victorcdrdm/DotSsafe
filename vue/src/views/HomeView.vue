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

    <button @click="showFilters = !showFilters">Plus de filtre</button>
    <div class="filter" v-show="showFilters">
      <select v-model="filtreTechnology">
        <option disable value="">Choisiez une technologie</option>
        <option v-for="technology in technologies" :key="technology.id" :value="technology.id">
          {{technology.name}}
        </option>
      </select>
      <button @click="activeFilters">Ajouter des filtre</button>
    </div>

    <div class="projects" v-for="project in projects" :key="project.id" v-show="showProject">
      <a href=""> {{project.project.name}} </a>
    </div>
    <div class="filterdProject" v-for="project in projectsFilterd" :key="project.id">
        {{project.project.name}}
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
      findBYTechnology: null,
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
      filtreTechnology: "",
      projectsFilterd: []
    }
  },
  methods: {
    getProjects() {
      serverFile.getAllProjects().then((response) => {
        let results = response['hydra:member']
        results.map((result) => {
          serverFile.getDataProject(result.id).then((response) => {
              let project = response['hydra:member'][0]
              this.projects.push(project)
          }) 
        })
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
        this.technologies.map((result) => {
          let technologie = {
            id: result.id,
            name: result.name
          }
        this.data[0].list.push(technologie)  
        })
      })
    },
    activeFilters() {
      this.showProject = false
      this.showProjectFilterd = true
      let technoFiltre = '/api/technologies/' + this.filtreTechnology +''
      let projects = this.projects
      console.log(projects[0].contributions)
      this.projectsFilterd = []
      projects.map((data) => {
        if ( data.project.technologies[0] === technoFiltre ) {
            this.projectsFilterd.push(data)
        }
      })
    },
    getMembers() {
      serverFile.getAllMembers().then((response) => {
          this.members = response['hydra:member']
          console.log(this.members)
      })
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
