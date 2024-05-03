<script setup>
import NodeItem from "./NodeItem.vue";

const { nodes } = defineProps(['nodes'])

</script>

<template>
  <ul v-for="node in nodes">
    <node-item :nodeId="node.id" :key="node.id" />
  </ul>
</template>