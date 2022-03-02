<template>
  <div class="home">
    <ul>
      <li v-for="category in this.categories" :key="category.id" @click="changeSection(category)" :class="{active: category.isActive}">
        {{category.name}}
      </li>
    </ul>
    <projectsView v-show="this.categories[0].isActive"/>
  
  </div>
</template>

<script>
import ProjectsView from '../components/ProjectsView.vue';

export default {
  name: 'HomeView',
  components: {
    ProjectsView
  },
  data() {
    return {
      selectedSection: "Projets",
      categories: [
        { id: 0, name:"Projets", isActive: true },
        { id: 1, name:"Technologies", isActive: false }, 
        { id: 2, name:"Membres", isActive: false }
      ],
    }
  },
  methods: {
    changeSection(selected) {
      this.categories.map((category) => {
        if (selected.id === category.id) {
          category.isActive = true
        } else {
          category.isActive = false
        }
      }); 
    }
  },
}
</script>

<style lang="scss">
  ul li{
    list-style: none;
    display: inline;
    margin: 10px 5px;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    text-align: center;
  }
  li:hover, .active{
    font-weight: bold;
    text-decoration: underline;
  }
</style>
