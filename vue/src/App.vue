<template>
  <div id="app">
    <h1>Test DotSafe</h1>
    <nav>
      <router-link to="/">Projets</router-link>
      <router-link to="/technologies">Technologies</router-link>
      <router-link to="/membres">Membres</router-link>
      <router-link to="/contributions">Contributions</router-link>
    </nav>
    <router-view/>
  </div>
</template>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;
    margin: 0 5px;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
