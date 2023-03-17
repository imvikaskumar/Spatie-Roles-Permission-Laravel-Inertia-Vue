<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';

defineProps(['users']);
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <div class="max-w-7xl max-auto py-4">
        	<div class="flex justify-between">
               <h1>Users Index</h1>
               <Link :href="route('users.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">New User</Link> 
            </div>
           <div class="mt-6">
	           	<Table>
	           		<template #table-header>
	           			<TableRow>
	           				<TableHeaderCell>ID</TableHeaderCell>
	           				<TableHeaderCell>Name</TableHeaderCell>
	           				<TableHeaderCell>Email</TableHeaderCell>
	           				<TableHeaderCell>Action</TableHeaderCell>
	           			</TableRow>
	           		</template>
	           		<template #default>
	           			<TableRow v-for="user in users" :key="user.id" class="border-b">
	           				<TableHeaderCell>{{ user.id }}</TableHeaderCell>
	           				<TableHeaderCell>{{ user.name }}</TableHeaderCell>
	           				<TableHeaderCell>{{ user.email }}</TableHeaderCell>
	           				<TableHeaderCell class="space-x-4">
                                <Link :href="route('users.edit', user.id)" class="text-green-400 hover:text-green-600">Edit</Link>
                                <Link :href="route('users.destroy', user.id)" method="DELETE" as="button" class="text-red-400 hover:text-red-600">Delete</Link>
                            </TableHeaderCell>
	           			</TableRow>
	           		</template>
	           	</Table>
           </div>
        </div>
    </AdminLayout>
</template>
