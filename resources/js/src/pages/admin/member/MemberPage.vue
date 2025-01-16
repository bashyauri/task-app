<script setup>
import MemberTable from "./components/MemberTable.vue";
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
                        <MemberTable>
                            <!-- <template #pagination>
                                <Bootstrap5Pagination
                                    v-if="memberData?.data"
                                    :data="memberData?.data"
                                    @pagination-change-page="getMembers"
                                />
                            </template> -->
                        </MemberTable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
