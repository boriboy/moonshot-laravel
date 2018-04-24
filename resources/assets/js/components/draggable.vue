<template>

    <draggable :list="hierarchyNew" :options="{animation:200, handle:'.my-handle'}" :element="'ul'" @change="update" class="list-group">
        <div v-for="(unit, index) in hierarchyNew" class="my-handle">
            <li class="list-group-item">{{unit.user.name}}</li>
            <hierarchy-draggable :hierarchy="unit.children"></hierarchy-draggable>
        </div>

        <!--<tr v-for="(depth, index) in hierarchyNew" class="my-handle">-->
            <!--<td v-for="">{{ depth}</td>-->
        <!--</tr>-->

    </draggable>

</template>

<script type="text/babel">
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable
        },

        props: ['hierarchy'],
//
        data() {
            console.log(this.hierarchy);
            return {
                hierarchyNew: this.hierarchy,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },

        methods: {
            update() {
                this.hierarchyNew.map((unit, index) => {
                    console.log(unit, index)
                })
            }
        },

        mounted() {
            console.log('Component hierarchy mounted.')
        }
    }
</script>
