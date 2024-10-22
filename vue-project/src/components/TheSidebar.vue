<template>
    
</template>

<script>
import {
    MDBTabs,
    MDBTabNav,
    MDBTabContent,
    MDBTabItem,
    MDBTabPane,
} from 'mdb-vue-ui-kit';
import { ref } from 'vue';

export default {
    components: {
        MDBTabs,
        MDBTabNav,
        MDBTabContent,
        MDBTabItem,
        MDBTabPane,
    },
    setup() {
        const activeTabId4 = ref('ex4-1');

        return {
            activeTabId4,
        };
    },
};
</script>