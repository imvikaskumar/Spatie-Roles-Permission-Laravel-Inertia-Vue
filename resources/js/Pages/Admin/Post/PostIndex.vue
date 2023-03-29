<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

defineProps(['posts']);
const form = useForm({});
const showConfirmPostModal = ref(false);

const confirmDeletePost = () => {
	showConfirmPostModal.value = true;
}

const deletePost = (id) => {
	form.delete(route('posts.destroy', id), {
		onSuccess: () => closeModal()
	});
}

const closeModal = () => {
	showConfirmPostModal.value = false;
}
</script>

<template>
    <Head title="Post" />

    <AdminLayout>
        <div class="max-w-7xl max-auto py-4">
        	<div class="flex justify-between">
               <h1>Post Index</h1>
               <Link :href="route('posts.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">New Post</Link> 
            </div>
           <div class="mt-6">
	           	<Table>
	           		<template #table-header>
	           			<TableRow>
	           				<TableHeaderCell>ID</TableHeaderCell>
	           				<TableHeaderCell>Title</TableHeaderCell>
	           				<TableHeaderCell>Action</TableHeaderCell>
	           			</TableRow>
	           		</template>
	           		<template #default>
	           			<TableRow v-for="post in posts" :key="post.id" class="border-b">
	           				<TableHeaderCell>{{ post.id }}</TableHeaderCell>
	           				<TableHeaderCell>{{ post.title }}</TableHeaderCell>
	           				<TableHeaderCell class="space-x-4">
                                <Link :href="route('posts.edit', post.id)" class="text-green-400 hover:text-green-600">Edit</Link>
                                <button @click="confirmDeletePost" class="text-red-400 hover:text-red-600">Delete</button>
                                <Modal :show="showConfirmPostModal" @close="closeModal">
                                	<div class="p-6">
                                		<h2 class="text-lg font-semibold text-slate-800">Are you sure to delete this post?</h2>
                                		<div class="mt-6 flex space-x-4">
                                			<DangerButton @click="$event => deletePost(post.id)">Delete</DangerButton>
                                			<SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                		</div>
                                	</div>
                                </Modal>
                            </TableHeaderCell>
	           			</TableRow>
	           		</template>
	           	</Table>
           </div>
        </div>
    </AdminLayout>
</template>
