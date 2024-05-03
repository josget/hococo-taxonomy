<script setup>
import { store } from "../../store.js";
import { ref, watch } from "vue";

const { node } = defineProps(['node'])
const selectedParentNodeId = ref('')
selectedParentNodeId.value = node.parentId || '';

const changeParentNode = async (nodeId, parentNodeId) => {
  try {
    await axios.patch(`/api/v1/nodes/${nodeId}/change-parent-node`, { parent_id: parentNodeId });
    window.location.reload();
  } catch (error) {
    console.error('Failed to change parent node:', error);
    alert('Failed to change parent node: ' + error.message);
  }
}

watch(selectedParentNodeId, (newValue) => {
  changeParentNode(node.id, newValue)
})
</script>

<template>
    Name: {{node.name}} | Type: {{node.type}} | Height: {{ node.height }}
    <select v-if="node.height > 0 && node.type === 'Property'" v-model="selectedParentNodeId">
      <option value="">Select</option>
      <option
          v-for="building in store.buildingNodes"
          :key="building.id"
          :value="building.id"
      >
          {{ building.name }}
      </option>
    </select>
</template>