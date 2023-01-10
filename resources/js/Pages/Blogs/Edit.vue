<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        blog: {
            type: Object,
            default: () => ({})
        }
    });

    const form = useForm({
        id: props.blog.id,
        title: props.blog.title,
        slug: props.blog.slug,
        content: props.blog.content,
        
    });

    const submit = () => {
        form.patch(route("blogs.update", props.blog.id));
    };
</script>
<template>
    <Head title="Blog Create"/>
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blogs</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">Blog Edit</h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    please insert form for edit blogs
                                </p>
                            </header>
                            <form @submit.prevent="submit" class="mt-6 space-y-6">
                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput
                                        id="title"
                                        type="text"
                                        class="mt-2 block w-full"
                                        v-model="form.title"
                                        required
                                        autofocus
                                        autocomplete="title"
                                    />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                                <div>
                                    <InputLabel for="slug" value="Slug" />
                                    <TextInput
                                        id="slug"
                                        type="text"
                                        class="mt-2 block w-full"
                                        v-model="form.slug"
                                        required
                                        autofocus
                                        autocomplete="slug"
                                    />
                                    <InputError class="mt-2" :message="form.errors.slug" />
                                </div>
                                <div>
                                    <InputLabel for="content" value="Content" />
                                    <textarea
                                        type="text"
                                        v-model="form.content"
                                        name="content"
                                        id=""
                                        class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    ></textarea>
                                    <InputError class="mt-2" :message="form.errors.content" />
                                </div>
                                <div class="flex items-center gap-4">
                                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                    </Transition>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

