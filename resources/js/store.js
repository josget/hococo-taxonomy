import { reactive } from 'vue'

export const store = reactive({
    buildingNodes: [],
    rootNodes: [],
    async loadBuildingNodes() {
        try {
            const { data } = await axios.get('/api/v1/nodes', { params: { type: 'Building' } });
            this.buildingNodes = data
        } catch (error) {
            console.error('Failed to fetch building nodes:', error);
        }
    },
    async loadRootNodes() {
        try {
            const { data } = await axios.get('/api/v1/nodes', { params: { height: 0 } });
            this.rootNodes = data;
        } catch (error) {
            console.error('Failed to fetch root nodes:', error);
        }
    }
})