<template>
  <div class="member">
    <h2>Membres</h2>
    <button @click="showForm = !showForm">Ajouter un Membre</button>
    <div class="showForm" v-show="showForm">
      <form>
        <div class="error" v-if="error"> {{error}} </div>
        <input 
          type="text"
          v-model="firstname"
          required="required"
          placeholder="Ajouter un prenom"
          >
        <input 
          type="text"
          v-model="lastname"
          required="required"
          placeholder="Ajouter un nom de famille"
          >
        <input 
          type="email"
          v-model="email"
          required="required"
          placeholder="Ajouter un Email"
          >
      </form>
      <button @click="newMember">Envoyer le formulaire</button>
    </div>
    <div class="members" v-for="member in members" :key="member.id">
      <router-link :to="{ name: 'Member', params: { name: member.lastname, id: member.id }}">
         {{member.firstname}} - {{ member.lastname }} {{member.email}}
      </router-link>
    </div>
  </div>
</template>

<script>

import serverFile from "./../api/serverFile.vue";

export default {
  data() {
    return {
      firstname: "",
      lastname: "",
      email: "",
      showForm: false,
      members: [],
      error: "",
    }
  },
  methods: {
    newMember() {
      let params = {
        "firstname": this.firstname,
        "lastname": this.lastname,
        "email": this.email
      }
      serverFile.newMember(params).then((response) => {
        if (response) {
          this.showForm = !this.showForm
          this.firstname = ""
          this.lastname = ""
          this.email = ""
          this.getAllMembers()
        }
      }).catch((err) => {
        if (err) {
          this.error = "Une erreur est survenu veuillez vérifier les informations renseignées."
        }
      })
    },
    getAllMembers() {
      serverFile.getAllMembers().then((response) => {
          this.members = response['hydra:member']
      })
    }
  },
  mounted: function() {
    this.getAllMembers()
  }
}
</script>