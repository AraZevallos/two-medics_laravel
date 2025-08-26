<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';

import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Form, FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Course, CourseFile } from '@/types';
import { PropType } from 'vue';

const props = defineProps({
    course: {
        type: Object as PropType<Course>,
        default: null,
    },
    file: {
        type: Object as PropType<CourseFile>,
        default: null,
    },
});

const formSchema = toTypedSchema(
    z.object({
        // nombre: z.string().min(2, 'El nombre es muy corto').max(100),
        pdf: z.any().refine((file) => file instanceof File, 'Debes subir un archivo PDF'),
    }),
);

const emit = defineEmits(['save:course']);

function onSubmit(values: any) {
    const formData = new FormData();

    formData.append('name', values.nombre);
    formData.append('pdf', values.pdf);
    if (props.file) formData.append('file', `${props.file.id}`);

    emit('save:course', formData);
}
</script>

<template>
    <Form v-slot="{ handleSubmit }" as="" keep-values :validation-schema="formSchema">
        <Dialog>
            <DialogTrigger as-child>
                <slot></slot>
            </DialogTrigger>

            <DialogContent class="sm:max-w-[425px]">
                <!-- Caso: Actualizar contenido de curso existente -->
                <DialogHeader v-if="file">
                    <DialogTitle>Actualizar material</DialogTitle>
                    <DialogDescription> Curso: {{ course.name }} </DialogDescription>
                    <DialogDescription> Archivo: {{ file.file_name }} </DialogDescription>
                </DialogHeader>

                <!-- Caso: Agregar contenido a curso existente -->
                <DialogHeader v-else-if="course">
                    <DialogTitle>Agregar material</DialogTitle>
                    <DialogDescription> Curso: {{ course.name }} </DialogDescription>
                </DialogHeader>

                <!-- Caso: Crear curso nuevo -->
                <DialogHeader v-else>
                    <DialogTitle>Nuevo curso</DialogTitle>
                    <DialogDescription> Ingresa el nombre del curso y adjunta un archivo PDF como material inicial. </DialogDescription>
                </DialogHeader>

                <form id="dialogForm" @submit="handleSubmit($event, onSubmit)">
                    <!-- Campo nombre -->
                    <FormField v-slot="{ componentField }" name="nombre">
                        <!-- Caso: nuevo curso -->
                        <FormItem v-if="!course">
                            <FormLabel>Nombre del curso</FormLabel>
                            <FormControl>
                                <Input placeholder="Ej: Introducción a la Biología" type="text" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <!-- Campo PDF -->
                    <FormField v-slot="{ handleChange }" name="pdf">
                        <FormItem>
                            <FormLabel>Selecciona un archivo PDF</FormLabel>
                            <FormControl>
                                <Input type="file" accept="application/pdf" @change="(e: any) => handleChange(e.target.files?.[0] ?? null)" />
                            </FormControl>
                            <FormDescription>Solo se permite PDF.</FormDescription>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </form>

                <DialogFooter>
                    <Button type="submit" form="dialogForm">Guardar curso</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </Form>
</template>
