<script>

import http from '@/utils/http'

function getAllProjects() {
    return http.get('api/projects')
}

function getProject(id) {
    return http.get('api/projects/'+ id)
}

function addProject(params) {
    return http.post('api/projects', params)
}

function modifyProject(id, params) {
    return http.put('api/projects/'+ id , params)
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

function getTechnology(id) {
    return http.get('api/technologies/'+ id)
}

function updateTechnology(id, params) {
    return http.put('api/technologies/'+ id, params)
}

function newMember(params) {
    return http.post('api/members', params)
}

function getAllMembers() {
    return http.get('api/members')
}

function getMember(id) {
    return http.get('api/members/' + id)
}

function updateProfile(id, params) {
    return http.put('api/members/' + id, params)
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

function getContribution(id) {
    return http.get('api/contributions/'+ id)
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
   modifyProject,
   getTechnology,
   updateTechnology,
   getMember,
   updateProfile,
   getContribution,
}
</script>