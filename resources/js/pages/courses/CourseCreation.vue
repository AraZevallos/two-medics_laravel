<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';

import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import Separator from '@/components/ui/separator/Separator.vue';
import Tooltip from '@/components/ui/tooltip/Tooltip.vue';
import TooltipContent from '@/components/ui/tooltip/TooltipContent.vue';
import TooltipProvider from '@/components/ui/tooltip/TooltipProvider.vue';
import TooltipTrigger from '@/components/ui/tooltip/TooltipTrigger.vue';
import { Course, CourseFile } from '@/types';
import { Upload } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { PropType, ref } from 'vue';

const props = defineProps({
    course: {
        type: Object as PropType<Course | null>,
        default: null,
    },
    file: {
        type: Object as PropType<CourseFile>,
        default: null,
    },
    classes: {
        type: String,
        default: '',
    },
});

const isOpen = ref(false);
const fileInput = ref<{ el: HTMLInputElement } | null>(null);

const formSchema = toTypedSchema(
    z.object({
        nombre: z
            .string()
            .min(1, 'El título no debe estar vacío')
            .max(150, 'El título es muy largo'),
        pdf: z
            .any()
            .refine(
                (file) => file instanceof File,
                'Debes subir un archivo PDF',
            ),
    }),
);

const { isFieldDirty, handleSubmit } = useForm({
    validationSchema: formSchema,
    initialValues: {
        nombre: props.course?.name ?? '',
    },
});

const onSubmit = handleSubmit((values) => {
    const formData = new FormData();

    formData.append('name', values.nombre);
    formData.append('pdf', values.pdf);
    if (props.file) formData.append('file', `${props.file.id}`);

    emit('save:course', formData);
});

const emit = defineEmits(['save:course']);
</script>

<template>
    <Dialog class="w-full max-w-[520px] min-w-[520px]" v-model:open="isOpen">
        <DialogTrigger :class="classes">
            <slot />
        </DialogTrigger>

        <DialogContent class="flex flex-col gap-6">
            <DialogTitle>
                <h5 class="font-medium text-gray-600">
                    {{
                        file
                            ? 'Actualizar material'
                            : course
                              ? 'Agregar material'
                              : 'Completa la información del nuevo contenido'
                    }}
                </h5>
            </DialogTitle>

            <DialogDescription />

            <form
                id="dialogForm"
                @submit="onSubmit"
                class="flex flex-col gap-6"
            >
                <!-- Campo nombre -->
                <FormField
                    name="nombre"
                    class="flex flex-col gap-2"
                    v-slot="{ componentField }"
                    :validate-on-blur="!isFieldDirty('nombre')"
                >
                    <FormItem>
                        <FormLabel
                            class="font-normal text-gray-400 data-[error=true]:text-gray-400"
                        >
                            Título del contenido
                        </FormLabel>

                        <FormControl>
                            <Input
                                v-bind="{
                                    ...componentField,
                                    type: 'text',
                                    disabled: course?.id,
                                    placeholder: 'Ingresa un título',
                                }"
                            />
                        </FormControl>

                        <FormMessage class="text-destructive" />
                    </FormItem>
                </FormField>

                <!-- Campo PDF -->
                <FormField
                    v-slot="{ handleChange, value, errors }"
                    name="pdf"
                    class="flex flex-col gap-2"
                    :validate-on-blur="!isFieldDirty('pdf')"
                >
                    <FormItem>
                        <FormLabel
                            class="font-normal text-gray-400 data-[error=true]:text-gray-400"
                        >
                            Archivo PDF
                            <span v-if="file"> ({{ file.file_name }}) </span>
                        </FormLabel>

                        <div
                            class="flex cursor-pointer items-center justify-center gap-4 rounded-[8px] border-2 border-dashed border-blue-300 bg-white px-6 py-4 text-gray-600 hover:bg-blue-100 hover:text-blue-500"
                            :class="[
                                { 'border-destructive': errors.length > 0 },
                            ]"
                            @click="fileInput?.el.click()"
                        >
                            <div
                                class="flex size-9 items-center justify-center rounded-full bg-blue-500 p-2"
                            >
                                <Upload class="size-[14px] text-white" />
                            </div>

                            <TooltipProvider v-if="value">
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <p
                                            class="truncate"
                                            style="width: 330px"
                                        >
                                            {{ value?.name }}
                                        </p>
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        {{ value?.name }}
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>

                            <p v-else>
                                Sube tu archivo aquí

                                <span class="text-gray-500"> (solo PDF) </span>
                            </p>
                        </div>

                        <FormControl style="display: none">
                            <Input
                                ref="fileInput"
                                type="file"
                                accept="application/pdf"
                                @change="
                                    (e: any) =>
                                        handleChange(
                                            e.target.files?.[0] ?? null,
                                        )
                                "
                            />
                        </FormControl>

                        <FormMessage class="text-destructive" />
                    </FormItem>
                </FormField>
            </form>

            <DialogFooter>
                <div class="flex w-full flex-col gap-4">
                    <Separator orientation="horizontal" class="bg-blue-100" />

                    <div class="flex justify-end gap-2">
                        <Button
                            variant="outline"
                            size="xl"
                            @click="isOpen = false"
                        >
                            Cancelar
                        </Button>

                        <Button type="submit" form="dialogForm" size="xl">
                            Guardar contenido
                        </Button>
                    </div>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
