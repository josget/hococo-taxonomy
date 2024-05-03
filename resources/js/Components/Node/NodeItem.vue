<script setup>
import { onMounted, ref } from "vue";
import NodeDetails from "./NodeDetails.vue";
import NodeItems from "./NodeItems.vue";

const { nodeId } = defineProps(['nodeId'])

const node = ref(null);
const getNode = async () => {
  try {
    const { data } = await axios.get(`/api/v1/nodes/${nodeId}`);
    node.value = data;
  } catch (error) {
    console.error('Failed to fetch node:', error);
  }
}

onMounted(getNode);
</script>

<template>
  <li v-if="node">
    <node-details :node="node" />
    <node-items :nodes="node.children" />
  </li>
</template>