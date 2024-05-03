<script setup>
import { onMounted, ref } from 'vue';
import NodeItems from '../Components/Node/NodeItems.vue';
import { store } from '../store.js';

onMounted(() => {
  store.loadRootNodes();
  store.loadBuildingNodes()
});
</script>

<template>
  <div>
    <h1>Node Tree</h1>
    <node-items :nodes="store.rootNodes" />
  </div>
</template>