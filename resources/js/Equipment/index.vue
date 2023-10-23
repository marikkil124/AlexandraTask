<script setup>
import {onMounted, onUpdated, reactive, ref, watch} from "vue";

import Show from "@/Equipment/show.vue";
import Edit from "@/Equipment/edit.vue";



const links = ref([])
const equipmentTypes = ref([])
const selected = ref();
const xx = ref()
const equipments = ref([])
const foundItems = ref(null)

const currentPage = ref('/api/equipment')
const findItems = ref({
    showTemplate: true,
    serialNumber: null,
})
const editVisibleData = ref({
    id: null,
    state: false,
    equipment:null
})
function getEquipmentType() {
    axios.get('/api/equipment_types').then(res => {
        equipmentTypes.value = res.data.data;
        //console.log(equipmentTypes.value);
    });

};
getEquipmentType();
function getEquipments(curPage) {
    //получение пагинированного списка при нажатии кнопок NextPage ,Prev Page или список идущий с контоллера
    curPage = curPage || '/api/equipment'
   axios.get(curPage).then(res => {

        //links хранит параметры пагинации идущие с EquipmentResource , page
        links.value = res.data.links
        equipments.value = res.data.data;


    });

};
// watch(currentPage,(cu)=>{
//
//
//     getEquipments(cu)
//     console.log( equipments.value)
// })


function nextPage() {

    getEquipments(links.value.next)
}

function prevPage() {

    getEquipments(links.value.prev)
}

function lastPage() {

    getEquipments(links.value.last)
}

function showEdit(msg) {
    // для дальнешего показа edit component

    editVisibleData.value.id = msg.value.id
    editVisibleData.value.state = msg.value.state
    //foundItems.value = equipments[msg.value.id].value
    getEquipments(currentPage.value)
}

async function editShow(msg)
{
    editVisibleData.value.id = msg.value.id
    editVisibleData.value.state = msg.value.state
    foundItems.value = msg.value.equipment
    console.log( foundItems.value)
   // getEquipments(currentPage.value)
}



 function findeqtype(Item) {
    findItems.value.showTemplate=false
   // getEquipments(  'api/equipments')
     axios.get('api/equipments').then(res => {

         xx.value = res.data.data;
         foundItems.value =xx.value.filter(item => item.equipment_type.id==selected.value)
         console.log(res.data)

     });
     console.log( xx.value)


}

function findSerialNumber() {
    findItems.value.showTemplate=false
    foundItems.value = equipments.value.filter(item => item.serial_number==findItems.value.serialNumber)
    console.log(foundItems.value)
    if(foundItems.value===undefined)
    {
        findItems.showTemplate=true
    }
}

getEquipments(currentPage.value)
</script>

<template>

    <div class="flex justify-center mt-1">
        <div class="  rounded-full ">
            Поиск по серийноме номеру
            <input class="rounded-full w-40  border-2 border-sky-500 text-center" placeholder=" серийный номер "
                   v-model="findItems.serialNumber">
            <a class=" cursor-pointer w-24   bg-blue-500  text-white  text-center border-1 rounded-3xl mt-6"
               type="submit" @click="findSerialNumber()">
              поиск
            </a>
        </div>

    </div>

    <div class="flex justify-center mt-1">

        <div class="  rounded-full ">
            Поиск по типу
            <select class="ml-2 w-24 rounded-full  border-2 border-sky-500 text-center" v-model="selected">
                <option v-for="eqType in equipmentTypes" :value="eqType.id">
                    {{ eqType.name }}
                </option>
            </select>
            <a class=" cursor-pointer w-24   bg-blue-500  text-white  text-center border-1 rounded-3xl mt-6"
               type="submit" @click="findeqtype()">
                поиск
            </a>
        </div>

    </div>

    <div class="flex justify-center mt-6 text-red-600" v-if="foundItems===undefined"> Такой серийный номер не найден!</div>
    <div class="flex justify-center mt-6">

        <a class=" cursor-pointer w-24  bg-green-500  text-white  text-center border-1 rounded-3xl "
           type="submit" @click="prevPage( )">
            PrevPage
        </a>
        <a class=" cursor-pointer w-24  bg-green-500  text-white  text-center border-1 rounded-3xl "
           type="submit" @click="nextPage( )">
            NextPage
        </a>
        <a class=" cursor-pointer w-24  bg-green-500  text-white  text-center border-1 rounded-3xl "
           type="submit" @click="lastPage( )">
            LastPage
        </a>
    </div>

    <div class=" flex justify-center text-center mt-3">

        <table class="border-2  solid border-gray-300 ">
            <thead>
            <th>id</th>
            <th>Название типа оборудования</th>
            <th>Серийный номер</th>
            <th>Примечание</th>
            </thead>
            <tbody>
            <template  v-if="findItems.showTemplate" v-for="equipment in equipments"
                      class="border-2  solid border-gray-300 ">
                <show   :equipment="equipment" @editVisibleEmit="(msg) =>{showEdit(msg)}"></show>

                <edit v-if="(equipment.id == editVisibleData.id)&&editVisibleData.state" :equipment="equipment"
                      @success="(msg) =>{showEdit(msg)}"
                ></edit>
            </template>
            <template v-if="!findItems.showTemplate" v-for="fd in foundItems">
                <show   :equipment="fd" @editVisibleEmit="(msg) =>{showEdit(msg)}"></show>

                <edit v-if="(editVisibleData.state)" :equipment="fd"
                      @success="(msg) =>{editShow(msg)}"
                ></edit>
            </template>
            </tbody>
        </table>

    </div>


</template>

<style scoped>
td, th {

    border: 1px solid gray;

}
</style>
