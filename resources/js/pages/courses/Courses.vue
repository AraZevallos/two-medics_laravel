<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import CourseDetail from '@/pages/courses/CourseDetail.vue';
import CourseList from '@/pages/courses/CourseList.vue';
import CourseParents from '@/pages/courses/CourseParents.vue';
import { Course, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { PropType } from 'vue';
import { toast } from 'vue-sonner';
import CourseDetailEmpty from './CourseDetailEmpty.vue';
import CourseListEmpty from './CourseListEmpty.vue';

const props = defineProps({
    parents: {
        type: Array as PropType<Array<Course>>,
        required: true,
    },
    selectedParent: {
        type: Object as PropType<Course>,
        default: null,
    },
    selectedCourse: {
        type: Object as PropType<Course>,
        default: null,
    },
    summary: {
        type: Object as PropType<{ parents: number; courses: number; visibles: number }>,
        default: null,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cursos',
        href: '/cursos',
    },
];

function selectParent({ parent }: { parent: number }) {
    router.visit(route('courses.parent', { parent }));
}

function selectCourse({ parent, course }: { parent: number; course: number }) {
    router.visit(route('courses.course', { parent, course }));
}

function refreshParentCode(payload: { parent: number; course?: number }) {
    let path = 'courses.refresh-parent';

    if (payload.course) path += '-with-child';
    else delete payload.course;

    router.post(
        route(path, payload),
        {},
        {
            preserveUrl: true,
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => toast('Nuevo código', { description: 'El código se ha generado nuevamente' }),
            onError: () => toast('Error al generar código', { description: 'El código no se ha generado' }),
        },
    );
}

function refreshCourseCode({ parent, course }: { parent: number; course: number }) {
    router.post(
        route('courses.refresh-course', { parent, course }),
        {},
        {
            preserveUrl: true,
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => toast('Nuevo código', { description: 'El código se ha generado nuevamente' }),
            onError: () => toast('Error al generar código', { description: 'El código no se ha generado' }),
        },
    );
}

function deleteCourseCode(payload: { parent: number; course: number; code: number }) {
    router.post(
        route('courses.delete-course-code', payload),
        {},
        {
            preserveUrl: true,
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => toast('Código eliminado', { description: 'El código se ha eliminado' }),
            onError: () => toast('Error al eliminar código', { description: 'El código no se ha eliminado' }),
        },
    );
}

function addCourseCode(payload: { parent: number; course: number }) {
    router.post(
        route('courses.add-course-code', payload),
        {},
        {
            preserveUrl: true,
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => toast('Nuevo código', { description: 'El código se ha generado nuevamente' }),
            onError: () => toast('Error al generar código', { description: 'El código no se ha generado' }),
        },
    );
}

function disableCourse(payload: { parent: number; course: number }) {
    router.post(
        route('courses.disable-course', payload),
        {},
        {
            preserveUrl: true,
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => toast('Curso deshabilitado', { description: 'El curso se ha deshabilitado' }),
            onError: () => toast('Error al deshabilitar curso', { description: 'El curso no se ha deshabilitado' }),
        },
    );
}

function enableCourse(payload: { parent: number; course: number }) {
    router.post(
        route('courses.enable-course', payload),
        {},
        {
            preserveUrl: true,
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => toast('Curso habilitado', { description: 'El curso se ha habilitado' }),
            onError: () => toast('Error al habilitar curso', { description: 'El curso no se ha habilitado' }),
        },
    );
}

function deleteCourse(payload: { parent: number; course: number }) {
    router.delete(route('courses.delete-course', payload), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            toast('Curso eliminado', { description: 'El curso se ha eliminado' });
            router.visit(route('courses.parent', { parent: payload.parent }), {
                preserveScroll: true,
                preserveState: false,
                replace: true,
            });
        },
        onError: () => toast('Error al eliminar curso', { description: 'El curso no se ha eliminado' }),
    });
}

function deleteCourseFile(payload: { parent: number; course: number; file: number }) {
    router.post(
        route('courses.delete-course-file', payload),
        {},
        {
            preserveUrl: true,
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => toast('Archivo eliminado', { description: 'El archivo se ha eliminado' }),
            onError: () => toast('Error al eliminar archivo', { description: 'El archivo no se ha eliminado' }),
        },
    );
}

function addCourseFile(formData: FormData) {
    formData.append('parent', `${props.selectedParent?.id}`);
    if (props.selectedCourse) formData.append('course', `${props.selectedCourse?.id}`);

    router.post(route('courses.add-course-file'), formData, {
        preserveUrl: true,
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => toast('Archivo añadido', { description: 'El archivo se ha añadido' }),
        onError: () => toast('Error al añadir archivo', { description: 'El archivo no se ha añadido' }),
    });
}

function updateCourseFile(formData: FormData) {
    formData.append('parent', `${props.selectedParent?.id}`);
    if (props.selectedCourse) formData.append('course', `${props.selectedCourse?.id}`);

    router.post(route('courses.update-course-file'), formData, {
        preserveUrl: true,
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => toast('Archivo actualizado', { description: 'El archivo se ha actualizado' }),
        onError: () => toast('Error al actualizar archivo', { description: 'El archivo no se ha actualizado' }),
    });
}

function saveCourse(formData: FormData) {
    formData.append('parent', `${props.selectedParent?.id}`);
    if (props.selectedCourse) formData.append('course', `${props.selectedCourse?.id}`);

    router.post(route('courses.upload'), formData, {
        preserveUrl: true,
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => toast('Curso creado', { description: 'El curso se ha creado' }),
        onError: () => toast('Error al crear curso', { description: 'El curso no se ha creado' }),
    });
}
</script>

<template>
    <Head title="Cursos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex size-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <CourseParents v-bind="{ parents, selectedParent }" @select:parent="selectParent" />

            <div v-if="selectedParent" class="flex w-full gap-6">
                <CourseList
                    v-bind="{ selectedParent, selectedCourse }"
                    @refresh:parent-code="refreshParentCode"
                    @select:course="selectCourse"
                    @save:course="saveCourse"
                />

                <CourseDetail
                    v-if="selectedCourse"
                    :selected-course="selectedCourse"
                    @add:course-code="addCourseCode"
                    @add:course-file="addCourseFile"
                    @delete:course-code="deleteCourseCode"
                    @delete:course-file="deleteCourseFile"
                    @delete:course="deleteCourse"
                    @disable:course="disableCourse"
                    @enable:course="enableCourse"
                    @refresh:course-code="refreshCourseCode"
                    @update:course-file="updateCourseFile"
                />

                <CourseDetailEmpty v-else @save:course="saveCourse" />
            </div>

            <CourseListEmpty v-else :summary="summary" />
        </div>
    </AppLayout>
</template>
