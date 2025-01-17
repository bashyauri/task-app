<script setup>
import MemberTable from "./components/MemberTable.vue";
import useGetMembers from "./actions/getMember";
import { onMounted } from "vue";

const { loading, members, getMembers } = useGetMembers();

async function showListOfMembers() {
    await getMembers();
}
onMounted(async () => {
    showListOfMembers();
});
</script>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        Members
                        <RouterLink
                            style="float: right"
                            to="/create-members"
                            class="btn btn-primary"
                            >Create Member</RouterLink
                        >
                    </div>
                    <div class="card-body">
                        <MemberTable :members="members" />
                        <!-- <template #pagination>
                                <Bootstrap5Pagination
                                    v-if="memberData?.data"
                                    :data="memberData?.data"
                                    @pagination-change-page="getMembers"
                                />
                            </template> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
