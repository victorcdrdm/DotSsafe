<template>
  <div class="contributioon">
    <h2>Contributions</h2>
    <button @click="showForm = !showForm">Ajouter une contribution</button>
    <div class="form" v-show="showForm">
      <form>
        <select v-model="selectedMember">
          <option disable value="">Choisiez un membre</option>
          <option v-for="member in members" :key="member.id" :value="member.id">
            {{member.firstname}} {{ member.lastname }}
          </option>
        </select>
        <select v-model="selectedProject">
          <option disable value="">Choisiez un projet</option>
          <option v-for="project in projects" :key="project.id" :value="project.id">
            {{project.name}}
          </option>
        </select>
        <select v-model="selectedTechnology">
          <option disable value="">Choisiez une technologie</option>
          <option v-for="technology in technologies" :key="technology.id" :value="technology.id">
            {{technology.name}}
          </option>
        </select>  
      </form>
      <button @click="newContribution">Envoyer le formulaire</button>
    </div>
    <div >
      <div class="contributions" v-for="contribution in contributions" :key="contribution.id">
      <a href="">{{contribution.contribution.id}}
                 {{contribution.member.firstname}} 
                 {{contribution.member.lastname}} 
                 {{contribution.project.name}} 
                 {{contribution.technology.name}} </a> 
      </div>
    </div>  
  </div>
</template>

<script>

import serverFileVue from '../api/serverFile.vue'
import { settings } from '../config/variables'

export default {
  name: 'ContributionView',
  
  data() {
    return {
      contributions: [],
      projects: [],
      members: [],
      technologies: [],
      showForm: false,
      selectedMember: "",
      selectedProject: "",
      selectedTechnology: "",
      loadData: false,
    }
  },
  methods: {
    getAllContributions() {
      serverFileVue.getAllContributions().then((response) => {
       let results = response['hydra:member']
       results.map((result) => {
        serverFileVue.getDataContribution(result.id).then((response) => {
            this.contributions.push(response['hydra:member'][0])
         })
       })
      })
    },
    getAllProjects() {
      serverFileVue.getAllProjects().then((response) => {
        this.projects = response['hydra:member']
      })
    },
    getAllMembers() {
      serverFileVue.getAllMembers().then((response) => {
        this.members = response['hydra:member']
      })
    },
    getAllTechnologies() {
      serverFileVue.getAllTechnologies().then((response) => {
        this.technologies = response['hydra:member']
      })
    },
    newContribution() {
      let data = []
      let technology = settings.PATH_TECHNOLOGIES + this.selectedTechnology
      let params = {
        "project": settings.PATH_PROJECTS + this.selectedProject,
        "membre": settings.PATH_MEMBERS + this.selectedMember,
        "technology": settings.PATH_TECHNOLOGIES + this.selectedTechnology
      }
      serverFileVue.getProject(this.selectedProject).then((response) =>{
        let technologies = response.technologies
        technologies.map((technology) => {
          technology = technology.substring(1)
          data.push(technology)
        })
        if (!technologies.includes(technology)){
          
          data.push(settings.PATH_TECHNOLOGIES + this.selectedTechnology)
          let paramTechnologie ={'technologies': data}
          console.log(paramTechnologie)
          serverFileVue.modifyProject(this.selectedProject, paramTechnologie).then(() => {

          })  
        }
      })
      serverFileVue.newContributions(params).then((response) => {
        if (response) {
          this.getAllContributions()
        }
      })
    },
  },
  mounted: function() {
    this.getAllContributions()
    this.getAllProjects()
    this.getAllMembers()
    this.getAllTechnologies()
  }
}
</script>

<style>

</style>