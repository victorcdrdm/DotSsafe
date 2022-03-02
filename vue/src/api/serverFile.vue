<script>

import http from '@/utils/http'

function getAllProjects() {
    return http.get('api/projects')
}

export default {
   name: 'serverFile',
   getAllProjects
}
</script>