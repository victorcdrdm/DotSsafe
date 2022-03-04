<template>
  <div class="form-project">
    <button @click="showFormulaire = !showFormulaire">Ajouter un projet</button>
    <div class="form" v-show="showFormulaire">
    <form>
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
    <button @click="addProject">Ajouter un project</button>
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
  name: 'FormProject',
  components: {
      vueMultiSelect,
  },
  data () {
    return {
      showFormulaire: false,
      name: "",
      slugName: "",
      selectedTechnologies: [],
      technologies: [],
      addTechnologie: [],
      erorr: '',
      options: {
          multi: true,
          groups: true,
      },
      data: [{
        name: 'technologies',
        list: [],
        }]
    }
  },
  methods: {
    addProject() {
      this.selectedTechnologies.map((technologie) => {
        this.addTechnologie.push(settings.PATH_TECHNOLOGIE + technologie.id)
      })
      this.slugName = slugify(this.name)
      this.alredyExist(this.slugName)
      let params = {
        "name": this.name,
        "technologies": this.addTechnologie,
        "slug": this.slugName
      }
      serverFile.addProject(params).then((response) => {
        console.log(response)
      }).catch((err) => {
        let error = "Un errreur est survenu veuillez verifier les information rensigner"
        console.log(error)
        console.log(err)
      })
    },
    alredyExist(slug) {
    serverFile.getAllProjects().then((response) => {
      response['hydra:member'].map((project) => {
        if (project.slug === slug) {
          this.erorr = 'exist deja'
        } 
      })
    })
    return this.erorr
    }, 
    getTechnologies() {
      serverFile.getAllTechnologies().then((response) => {
        let results = response['hydra:member']
        results.map((result) => {
          let technologie = {
            id: result.id,
            name: result.name
          }
        this.data[0].list.push(technologie)  
        })
      })
    }
  },
  mounted: function() {
      this.getTechnologies()
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
