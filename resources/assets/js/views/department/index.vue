<template>
   <department-tree></department-tree>
</template>

<script>
    import DepartmentTree from '../../components/department/tree.vue'
    export default {
        name:'DepartmentIndexView',
        components: {
            'department-tree':DepartmentTree
        },
    }
</script>