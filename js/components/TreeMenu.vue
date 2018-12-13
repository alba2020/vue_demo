<template>
  <div class="tree-menu">
    <div class="label-wrapper" @click="toggleChildren">
      <div :style="indent" :class="labelClasses">
        <i v-if="nodes" class="fa" :class="iconClasses"></i>
        {{ name }}
      </div>
    </div>
    <tree-menu
    v-if="showChildren"
    v-for="node in nodes"
    v-bind:key="node.id"
    v-bind:nodes="node.children"
    v-bind:name="node.name"
    >
  </tree-menu>
</div>
</template>
<style scoped>
.tree-menu .label-wrapper {
  padding-bottom: 10px;
  margin-bottom: 10px;
  border-bottom: 1px solid #ccc;
}
.tree-menu .label-wrapper .has-children {
  cursor: pointer;
}
</style>
<script>
export default {
  template: '#tree-menu',
  props: [ 'nodes', 'name' ],
  data() {
    return {
      showChildren: false
    }
  },
  computed: {
    iconClasses() {
      return {
        'fa-plus-square-o': !this.showChildren,
        'fa-minus-square-o': this.showChildren
      }
    },
    labelClasses() {
      return { 'has-children': this.nodes }
    },
    indent() {
      return { transform: `translate(${this.depth * 50}px)` }
    }
  },
  methods: {
    toggleChildren() {
      this.showChildren = !this.showChildren;
    }
  }
}
</script>
