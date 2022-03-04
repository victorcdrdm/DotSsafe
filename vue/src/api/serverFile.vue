<script>

import http from '@/utils/http'

function getAllProjects() {
    return http.get('api/projects')
}

function addProject(params) {
    return http.post('api/projects', params)
}

function getProject(id) {
    return http.get('api/projects/'+ id )
}

function getDataProject(id) {
    return http.get('api/projects/'+id+'/data')
}

function getAllTechnologies() {
    return http.get('api/technologies')
}

function newTechnologies(params) {
    return http.post('api/technologies', params)
}

function newMember(params) {
    return http.post('api/members', params)
}

function getAllMembers() {
    return http.get('api/members')
}

function getAllContributions() {
    return http.get('api/contributions')
}

function newContributions(params) {
    return http.post('api/contributions', params)
}

function getDataContribution(id) {
    return http.get('api/contributions/'+id+'/data')
}

export default {
   name: 'serverFile',
   getAllProjects,
   addProject,
   getAllTechnologies,
   newMember,
   getAllMembers,
   newTechnologies,
   getAllContributions,
   newContributions,
   getDataContribution,
   getDataProject,
   getProject,
}

</script>