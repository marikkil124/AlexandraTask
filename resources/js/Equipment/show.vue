<script setup>
import {ref} from "vue";

const state = ref(false)
const data = ref({
    id:null,
    state:false,
    equipment:null
})
const props = defineProps(['equipment'])
const emit = defineEmits(['editVisibleEmit'])
function stateChange(id,state,equipment)
{
    data.value.id=id
    data.value.state=!state
    data.value.equipment= equipment
    emit('editVisibleEmit',data)


}
</script>

<template>

    <tr class="hover:bg-gray-300 cursor-pointer" @click="stateChange(equipment.id,data.state,equipment)">
        <td>
            {{equipment.id}}
        </td>
        <td>
            {{equipment.equipment_type.name}}
        </td>
        <td>
            {{equipment.serial_number}}
        </td>
        <td>
            {{equipment.desc}}
        </td>
    </tr>

</template>

<style scoped>
td,th{

    border:1px solid gray;

}
</style>
