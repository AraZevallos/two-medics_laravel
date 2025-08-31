<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import AppLayout from '@/layouts/AppLayout.vue';
import { ClientConfiguration, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import {
    Cctv,
    Mail,
    MessageCircle,
    SaveAll,
    Send,
    Trash,
    Upload,
} from 'lucide-vue-next';
import { PropType, ref } from 'vue';
import { toast } from 'vue-sonner';
import * as z from 'zod';

defineProps({
    configuration: {
        type: Object as PropType<ClientConfiguration>,
        required: true,
    },
    imageBase64: {
        type: String,
        default: '',
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Configuraciones',
        href: '/configs',
    },
];

const fileVisible = ref(false);
const fileInput = ref<{ el: HTMLInputElement } | null>(null);

const imageSectionSchema = toTypedSchema(
    z.object({
        image: z
            .any()
            .refine(
                (file) => file instanceof File,
                'Debes subir un archivo PNG o JPEG',
            )
            .refine(
                (file) =>
                    file && ['image/jpeg', 'image/png'].includes(file.type),
                'Solo se permiten imágenes PNG o JPEG',
            ),
    }),
);

function onSubmitImageSection(values: any) {
    const formData = new FormData();

    formData.append('image', values.image);
    formData.append('image_visible', `${fileVisible.value}`);

    router.post(route('configs.image'), formData, {
        preserveUrl: true,
        preserveScroll: true,
        preserveState: false,
        onSuccess: () =>
            toast('Imagen actualizada', {
                description: 'La nueva imagen se ha guardado correctamente',
            }),
        onError: () => {
            toast('Error al actualizar imagen', {
                description: 'La nueva imagen no se ha guardado',
            });
        },
    });
}

function onDeleteImageSection() {
    router.delete(route('configs.image'), {
        preserveUrl: true,
        preserveScroll: true,
        preserveState: false,
        onSuccess: () =>
            toast('Imagen eliminada', {
                description: 'La imagen se ha eliminado correctamente',
            }),
        onError: () => {
            toast('Error al eliminar imagen', {
                description: 'La imagen no se ha eliminado',
            });
        },
    });
}

function onSubmitSocialsSection(values: any) {
    router.post(route('configs.socials'), values, {
        preserveUrl: true,
        preserveScroll: true,
        preserveState: false,
        onSuccess: () =>
            toast('Información de contacto actualizada', {
                description:
                    'La información de contacto se ha actualizado correctamente',
            }),
        onError: () => {
            toast('Error al actualizar información de contacto', {
                description: 'La información de contacto no se ha actualizado',
            });
        },
    });
}

function onSubmitQuestionSection(values: any) {
    router.post(route('configs.questions'), values, {
        preserveUrl: true,
        preserveScroll: true,
        preserveState: false,
        onSuccess: () =>
            toast('Pregunta del día actualizada', {
                description:
                    'La pregunta del día se ha actualizado correctamente',
            }),
        onError: () => {
            toast('Error al actualizar pregunta del día', {
                description: 'La pregunta del día no se ha actualizado',
            });
        },
    });
}
</script>

<template>
    <Head title="Configuraciones" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- image section -->
        <div class="flex justify-center gap-6 p-6">
            <Form
                v-slot="{ handleSubmit }"
                :validation-schema="imageSectionSchema"
            >
                <form
                    @submit="handleSubmit($event, onSubmitImageSection)"
                    class="flex min-w-[50%] flex-col justify-center gap-6 rounded-[16px] bg-white px-10 py-6"
                >
                    <FormField
                        v-slot="{ handleChange, value, errors }"
                        name="image"
                    >
                        <FormItem>
                            <FormLabel class="data-[error=true]:text-gray-400">
                                <h5 class="font-semibold text-blue-950">
                                    Imagen promocional
                                </h5>
                            </FormLabel>

                            <div
                                class="flex cursor-pointer items-center justify-center gap-4 rounded-[8px] border-2 border-dashed border-blue-300 bg-white px-6 py-4 text-gray-600 hover:bg-blue-100 hover:text-blue-500"
                                :class="[
                                    {
                                        'border-destructive': errors.length > 0,
                                    },
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

                                    <span class="text-gray-500">
                                        (PNG o JPEG)
                                    </span>
                                </p>
                            </div>

                            <FormControl style="display: none">
                                <!-- solo png y jpeg -->
                                <Input
                                    ref="fileInput"
                                    name="image"
                                    type="file"
                                    accept="image/png, image/jpeg"
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

                    <div class="flex items-center gap-2">
                        <Button size="xl" type="submit" class="flex-1">
                            <Upload class="size-4" />
                            Subir imagen
                        </Button>

                        <Button
                            :disabled="!configuration.image_path"
                            class="size-[52px]"
                            size="xl"
                            variant="destructive"
                            @click.prevent="onDeleteImageSection"
                        >
                            <Trash class="size-4" />
                        </Button>
                    </div>

                    <img
                        v-if="imageBase64"
                        :src="imageBase64"
                        :alt="configuration.image_name!"
                        class="w-full rounded-[16px] object-cover"
                    />
                </form>
            </Form>

            <div class="flex min-w-[50%] flex-col justify-center gap-6">
                <div
                    class="flex flex-col justify-center gap-6 rounded-[16px] bg-blue-200 px-10 py-6"
                >
                    <h5 class="font-semibold text-blue-950">
                        Información de contacto
                    </h5>

                    <Form
                        :initial-values="{
                            tiktok: configuration.tiktok ?? '',
                            whatsapp: configuration.whatsapp ?? '',
                            telegram: configuration.telegram ?? '',
                            correo: configuration.correo ?? '',
                        }"
                        v-slot="{ handleSubmit }"
                    >
                        <form
                            class="flex flex-col gap-4"
                            id="socialsForm"
                            @submit="
                                handleSubmit($event, onSubmitSocialsSection)
                            "
                        >
                            <FormField
                                name="tiktok"
                                v-slot="{ componentField }"
                            >
                                <FormItem class="relative grid gap-2">
                                    <FormLabel
                                        for="tiktok"
                                        class="font-normal text-blue-950 data-[error=true]:text-blue-950"
                                    >
                                        Tiktok
                                    </FormLabel>

                                    <Input
                                        :tabindex="1"
                                        class="pl-10"
                                        id="tiktok"
                                        placeholder="URL de perfil de Tiktok"
                                        required
                                        type="url"
                                        v-bind="componentField"
                                    />

                                    <div
                                        class="absolute bottom-0 left-4 flex h-12 items-center"
                                    >
                                        <Cctv class="size-4 text-blue-600" />
                                    </div>
                                </FormItem>
                            </FormField>

                            <FormField
                                name="telegram"
                                v-slot="{ componentField }"
                            >
                                <FormItem class="relative grid gap-2">
                                    <FormLabel
                                        for="telegram"
                                        class="font-normal text-blue-950 data-[error=true]:text-blue-950"
                                    >
                                        Telegram
                                    </FormLabel>

                                    <Input
                                        :tabindex="2"
                                        class="pl-10"
                                        id="telegram"
                                        placeholder="Número de Telegram"
                                        required
                                        type="tel"
                                        v-bind="componentField"
                                    />

                                    <div
                                        class="absolute bottom-0 left-4 flex h-12 items-center"
                                    >
                                        <Send class="size-4 text-blue-600" />
                                    </div>
                                </FormItem>
                            </FormField>

                            <FormField
                                name="whatsapp"
                                v-slot="{ componentField }"
                            >
                                <FormItem class="relative grid gap-2">
                                    <FormLabel
                                        for="whatsapp"
                                        class="font-normal text-blue-950 data-[error=true]:text-blue-950"
                                    >
                                        Whatsapp
                                    </FormLabel>

                                    <Input
                                        :tabindex="2"
                                        class="pl-10"
                                        id="whatsapp"
                                        placeholder="Número de Whatsapp"
                                        required
                                        type="tel"
                                        v-bind="componentField"
                                    />

                                    <div
                                        class="absolute bottom-0 left-4 flex h-12 items-center text-blue-600"
                                    >
                                        <MessageCircle class="size-4" />
                                    </div>
                                </FormItem>
                            </FormField>

                            <FormField
                                name="correo"
                                v-slot="{ componentField }"
                            >
                                <FormItem class="relative grid gap-2">
                                    <FormLabel
                                        for="correo"
                                        class="font-normal text-blue-950 data-[error=true]:text-blue-950"
                                    >
                                        Correo
                                    </FormLabel>

                                    <Input
                                        :tabindex="2"
                                        class="pl-10"
                                        id="correo"
                                        placeholder="Correo electrónico"
                                        required
                                        type="email"
                                        v-bind="componentField"
                                    />

                                    <div
                                        class="absolute bottom-0 left-4 flex h-12 items-center text-blue-600"
                                    >
                                        <Mail class="size-4" />
                                    </div>
                                </FormItem>
                            </FormField>
                        </form>
                    </Form>

                    <Button
                        form="socialsForm"
                        size="xl"
                        type="submit"
                        class="flex-1"
                    >
                        <SaveAll class="size-4" />
                        Guardar información de contacto
                    </Button>
                </div>

                <div
                    class="flex flex-col justify-center gap-6 rounded-[16px] bg-gray-300 px-10 py-6"
                >
                    <h5 class="font-semibold text-blue-950">
                        Pregunta del día
                    </h5>

                    <Form
                        name="question"
                        :initial-values="{
                            question: configuration.question ?? '',
                            answer: configuration.answer ?? '',
                            explanation: configuration.explanation ?? '',
                        }"
                        v-slot="{ handleSubmit }"
                    >
                        <form
                            class="flex flex-col gap-4"
                            id="questionsForm"
                            @submit="
                                handleSubmit($event, onSubmitQuestionSection)
                            "
                        >
                            <FormField
                                name="question"
                                v-slot="{ componentField }"
                            >
                                <FormItem class="relative grid gap-2">
                                    <FormLabel
                                        for="question"
                                        class="font-normal text-gray-400 data-[error=true]:text-gray-400"
                                    >
                                        Pregunta:
                                    </FormLabel>

                                    <Textarea
                                        :tabindex="1"
                                        class="pl-10"
                                        id="question"
                                        maxlength="175"
                                        placeholder="Escribe tu pregunta"
                                        required
                                        type="text"
                                        v-bind="componentField"
                                    />

                                    <div
                                        class="absolute bottom-[15%] left-4 flex h-12 items-center"
                                    >
                                        <Cctv class="size-4 text-blue-600" />
                                    </div>
                                </FormItem>
                            </FormField>

                            <FormField
                                name="answer"
                                v-slot="{ componentField }"
                            >
                                <FormItem class="relative grid gap-2">
                                    <FormLabel
                                        for="answer"
                                        class="font-normal text-gray-400 data-[error=true]:text-gray-400"
                                    >
                                        Respuesta:
                                    </FormLabel>

                                    <Textarea
                                        :tabindex="2"
                                        class="pl-10"
                                        id="answer"
                                        maxlength="52"
                                        placeholder="Escribe tu respuesta"
                                        required
                                        type="text"
                                        v-bind="componentField"
                                    />

                                    <div
                                        class="absolute bottom-[15%] left-4 flex h-12 items-center"
                                    >
                                        <Send class="size-4 text-blue-600" />
                                    </div>
                                </FormItem>
                            </FormField>

                            <FormField
                                name="explanation"
                                v-slot="{ componentField }"
                            >
                                <FormItem class="relative grid gap-2">
                                    <FormLabel
                                        for="explanation"
                                        class="font-normal text-gray-400 data-[error=true]:text-gray-400"
                                    >
                                        Explicación:
                                    </FormLabel>

                                    <Textarea
                                        :tabindex="2"
                                        class="pl-10"
                                        id="explanation"
                                        maxlength="175"
                                        placeholder="Escribe tu explicación"
                                        required
                                        type="text"
                                        v-bind="componentField"
                                    />

                                    <div
                                        class="absolute bottom-[15%] left-4 flex h-12 items-center text-blue-600"
                                    >
                                        <MessageCircle class="size-4" />
                                    </div>
                                </FormItem>
                            </FormField>
                        </form>
                    </Form>

                    <Button
                        form="questionsForm"
                        size="xl"
                        type="submit"
                        class="flex-1"
                    >
                        <SaveAll class="size-4" />
                        Guardar pregunta del día
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
