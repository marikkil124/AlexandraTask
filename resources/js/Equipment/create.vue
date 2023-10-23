<script setup>
import {ref} from "vue";

const selected = ref(null)
const equipmentTypes = ref([])
const success = ref()
const serialNumber = ref(null)
const desc = ref(null)
const errors = ref({
    eqType: null,
    serialNumber: null,
    desc: null
})

function getEquipmentType() {
    axios.get('/api/equipment_types').then(res => {
        equipmentTypes.value = res.data.data;
        //console.log(equipmentTypes.value);
    });

};
getEquipmentType();

function addEquipment() {
    if (selected.value != null && serialNumber.value != null && desc.value != null) {
        axios.post('/api/equipment', {
            equipment_type: selected.value,
            serial_number: serialNumber.value,
            desc: desc.value,
        }).then(res => {
            selected.value = null
            serialNumber.value = null
            desc.value = null
            errors.value.eqType = null
            errors.value.serialNumber = null
            errors.value.desc = null
            success.value = "Успешно!"

        })
            .catch(e => {
                        //ловим ошибки валидации
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

                    console.log(e.response.data.errors)

                }


            })
    } else {
        selected.value == null ? errors.value.eqType = "Выберите тип обородувания!" : errors.value.eqType = null
        serialNumber.value == null ? errors.value.serialNumber = "Введите серийный номер" : errors.value.serialNumber = null
        desc.value == null ? errors.value.desc = "Введите примечание!" : errors.value.desc = null


    }

}

</script>

<template>
    <div class=" mt-6 flex justify-center grid  ">
        <form>
            <div class="mb-3">
                Выберите id типа оборудования:
                <select class="ml-2 w-24 rounded-full  border-2 border-sky-500 text-center" v-model="selected">
                    <option v-for="eqType in equipmentTypes" :value="eqType.id">
                        {{ eqType.id }}
                    </option>

                </select>
                <p class="text-red-600 " v-if="errors.eqType!=null"> {{ errors.eqType }} </p>
            </div>
            <div class="mb-3">

                <label for="serialNumber">Введите серийный номер: </label>

                <input id="serialNumber" class=" form-input rounded-full w-40  border-sky-500 border-2 text-center h-10"
                       placeholder="Серийный номер" v-model="serialNumber">
                <p class="text-red-600 " v-if="errors.serialNumber!==null"> {{ errors.serialNumber }} </p>
            </div>
            <div>
                <label for="serialNumber">Введите примечание: </label>
                <p class="mt-3">
                    <textarea id="serialNumber"
                              class=" form-input rounded-full w-96  border-sky-500 border-2 text-center"
                              placeholder="примечание" v-model="desc"></textarea>
                </p>
                <p class="text-red-600 " v-if="errors.desc"> {{ errors.desc }} </p>
            </div>
            <a class=" cursor-pointer w-24  bg-blue-500  text-white  text-center border-1 rounded-3xl px-2 py-0.5
        hover:bg-white hover:text-black border border-gray-300 ml-72"
               type="submit" @click="addEquipment( )">
                Добавить
            </a>
            <p class="text-green-600  " v-if="success"> {{ success }} </p>
        </form>
    </div>

</template>

<style scoped>

</style>
