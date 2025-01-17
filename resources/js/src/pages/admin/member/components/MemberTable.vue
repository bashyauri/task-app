<script setup>
const props = defineProps({
    members: {
        type: Array,
        required: true,
    },
});

const emits = defineEmits(["editMember"]);

function editMember(member) {
    emits("editMember", member);
}
</script>

<template>
    <div class="row">
        <div class="row">
            <div class="col-md-4 mb-3">
                <input
                    type="text"
                    @keydown="search"
                    v-model="query"
                    placeholder="search..."
                    class="form-control"
                />
                <span
                    style="color: blue"
                    v-show="loading === true ? true : false"
                    ><b>Searching....</b></span
                >
            </div>
        </div>

        <div class="row">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(member, index) in props.members"
                        :key="member.id"
                    >
                        <td>{{ index + 1 }}</td>
                        <td>{{ member.name }}</td>
                        <td>{{ member.email }}</td>
                        <td>
                            <button
                                class="btn btn-outline-primary"
                                @click="editMember(member)"
                            >
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
