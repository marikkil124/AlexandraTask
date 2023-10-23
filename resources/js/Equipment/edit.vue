<script setup>
import {ref} from "vue";
const props = defineProps(['equipment'])
const equipmentEdit = props.equipment
const emit = defineEmits(['success'])
const selected = ref(equipmentEdit.equipment_type.id)
const equipmentTypes = ref([])
const xz = ref()
const errors = ref({
    eqType: null,
    serialNumber: null,
    desc: null
})
const data = ref({
    id: null,
    state: false,
    showTemplate:false,
    equipment: {
        id: equipmentEdit.id,
        equipment_type: selected.value,
        serial_number: equipmentEdit.serial_number,
        desc: equipmentEdit.desc,
    }
})


function getEquipmentType() {
    axios.get('/api/equipment_types').then(res => {
        equipmentTypes.value = res.data.data;
    });
}

function updateEquipment() {
    console.log(selected.value)
    axios.put(`/api/equipment/${equipmentEdit.id} `, {
        id: equipmentEdit.id,
        equipment_type: selected.value,
        serial_number: equipmentEdit.serial_number,
        desc: equipmentEdit.desc,
    }).then(res => {

        data.value.equipment=res.data
        console.log(data.value.equipment)
        emit("success", data)


    }).catch(e => {
        if (e.response.data.errors) {

            if (e.response.data.errors.equipment_type)
                errors.value.eqType = e.response.data.errors.equipment_type[0]
            else
                errors.value.eqType = null

            if (e.response.data.errors.serial_number)
                errors.value.serialNumber = e.response.data.errors.serial_number[0]
            else
                errors.value.serialNumber = null

            if (e.response.data.errors.desc)
                errors.value.desc = e.response.data.errors.desc[0]
            else
                errors.value.desc = null
        }
    })
}

function deleteEquipment() {
    if (confirm('Вы уверены что хотите удалить?')) {
        axios.delete(`/api/equipment/${equipmentEdit.id} `).then(res => {
            emit("success", data)
            console.log(res)
        })
    }
}

getEquipmentType();
</script>

<template>
    <tr class="bg-gray-400 border-2 border-sky-500">
        <td>
            {{ equipment.id }}
        </td>
        <td>
            <select class="ml-2 w-24 rounded-full  border-2 border-sky-500 text-center" v-model="selected">
                <option v-for="eqType in equipmentTypes" :value="eqType.id">
                    {{ eqType.name }}
                </option>

            </select>

        </td>
        <td>
            <input class="text-center bg-gray-400 text-white" v-model=" equipmentEdit.serial_number">
            <p class="text-red-600 " v-if="errors.serialNumber!==null"> {{ errors.serialNumber }} </p>
        </td>
        <td>
            <input class="text-center bg-gray-400 text-white" v-model=" equipmentEdit.desc">
            <p class="text-red-600 " v-if="errors.desc!==null"> {{ errors.desc }} </p>
        </td>
        <td>
            <a class=" cursor-pointer w-24  bg-green-500  text-white  text-center border-1 rounded-3xl "
               type="submit" @click="updateEquipment()">
                Edit
            </a>

            <a class=" cursor-pointer w-24  bg-red-500  text-white  text-center border-1 rounded-3xl "
               type="submit" @click="deleteEquipment()">
                delete
            </a>
        </td>
    </tr>


</template>

<style scoped>

</style>
