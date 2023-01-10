<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import moment from 'moment';

    const props = defineProps({
        blogs: {
            type: Object,
            default: () => ({})
        }
    })

    const form = useForm()

    function destroy(id) {
        if (confirm("Are you sure want to delete")) {
            form.delete(route('blogs.destroy', id))
        }
    }
</script>
<template>
    <Head title="Blog"/>
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blogs</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    v-if="$page.props.flash.message"
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert"
                >
                    <span class="font-medium">
                        {{ $page.props.flash.message }}
                    </span>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                       <div class="mb-2">
                            <Link :href="route('blogs.create')">
                                <PrimaryButton>Add Blog</PrimaryButton></Link
                            >
                        </div>
                         <div
                            class="rounded-lg border"
                        >
                            <Table 
                            :striped="true" 
                            :resource="blogs"
                            class="mt-4">
                                <template v-slot:tableGlobalSearch="slotProps">
                                    <input
                                        class="border rounded-lg px-1 w-full text-sm"
                                        placeholder="Search"
                                        @input="slotProps.onChange($event.target.value)"
                                    />
                                </template>
                                <template #cell(actions)="{ item: blog }">
                                    <Link
                                        :href="
                                            route(
                                                'blogs.edit',
                                                blog.id
                                            )
                                        "
                                        class="px-4 py-2 text-white bg-blue-600 rounded-lg mr-1" >Edit</Link
                                    >
                                </template>
                                <template #cell(created_at)="{item: created_at}">
                                    <p>{{ moment(created_at).format('DD-MM-YYYY') }}</p>
                                </template>
                            </Table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>