<template>
  <div class="Projects">
    <h2>Tout les projets</h2>
   
  </div>
</template>

<script>

import serverFile from "./../api/serverFile.vue";

export default {
  name: 'ProjectsView',
  props: {
    msg: String
  },
  data() {
    return {
      projects: [],
    }
  },
  methods: {
    getProjects() {
      serverFile.getAllProjects().then((response) => {
        console.log(response)
      })
    }
  },
  mouted: function() {
    this.getProjects()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
