<script setup lang="ts">
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Tooltip from '@/components/ui/tooltip/Tooltip.vue';
import TooltipContent from '@/components/ui/tooltip/TooltipContent.vue';
import TooltipProvider from '@/components/ui/tooltip/TooltipProvider.vue';
import TooltipTrigger from '@/components/ui/tooltip/TooltipTrigger.vue';
import { copyCode, middleEllipsis } from '@/lib/utils';
import { Course, CourseCode } from '@/types';
import {
    Eye,
    EyeOff,
    Files,
    FileText,
    Plus,
    RefreshCcw,
    Trash,
    X,
} from 'lucide-vue-next';
import { computed, PropType, watch } from 'vue';
import CourseCreation from './CourseCreation.vue';
import CourseDeletion from './CourseDeletion.vue';

const props = defineProps({
    selectedCourse: {
        type: Object as PropType<Course>,
        required: true,
    },
});

let permanentCode: CourseCode | null = null;
let temporaryCodes: CourseCode[] = [];

function setCodes() {
    temporaryCodes = [];

    props.selectedCourse.codes?.forEach((code) => {
        if (code.is_persistent) permanentCode = code;
        else temporaryCodes.push(code);
    });
}

setCodes();
watch(props.selectedCourse, setCodes);

const isVisible = computed(() => props.selectedCourse.is_visible);

const emit = defineEmits([
    'add:course-code',
    'add:course-file',
    'delete:course-code',
    'delete:course-file',
    'delete:course',
    'disable:course',
    'enable:course',
    'refresh:course-code',
    'update:course-file',
]);
</script>

<template>
    <Card
        :class="
            'w-full min-w-[660px] self-start rounded-[16px] border-none shadow-none' +
            (isVisible ? ' bg-blue-950' : ' bg-gray-100')
        "
    >
        <CardHeader>
            <CardTitle class="flex items-center gap-2">
                <div
                    :class="[
                        'flex-1 text-[20px] font-semibold',
                        isVisible ? 'text-white' : 'text-blue-950',
                    ]"
                >
                    {{ selectedCourse.name }}
                </div>

                <div
                    v-if="permanentCode && isVisible"
                    class="flex items-center space-x-2 p-4"
                >
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <Button
                                    variant="ghost"
                                    class="text-blue-300 hover:bg-blue-100/20 hover:text-blue-300"
                                    @click="
                                        emit('refresh:course-code', {
                                            parent: selectedCourse.parent_id,
                                            course: selectedCourse.id,
                                        })
                                    "
                                >
                                    <RefreshCcw class="size-4" />
                                </Button>
                            </TooltipTrigger>

                            <TooltipContent>
                                <p>Generar un nuevo código</p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>

                    <p class="text-sm font-normal text-gray-400">
                        Código libre:
                        <span class="uppercase">{{ permanentCode.value }}</span>
                    </p>

                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <Button
                                    variant="ghost"
                                    class="text-blue-400 hover:bg-blue-100/20 hover:text-blue-400"
                                    @click="copyCode(permanentCode.value)"
                                >
                                    <Files class="size-4" />
                                </Button>
                            </TooltipTrigger>

                            <TooltipContent>
                                <p>Copiar</p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </div>
            </CardTitle>
        </CardHeader>

        <CardContent class="flex flex-col gap-8">
            <div v-if="isVisible" class="flex flex-col gap-4">
                <p class="text-sm text-gray-400">Códigos de acceso único</p>

                <div class="flex w-full flex-wrap items-center gap-2">
                    <div
                        v-for="code in temporaryCodes"
                        :key="code.id"
                        class="flex items-center justify-between gap-2 rounded-lg bg-gray-200 px-4 py-2 text-white"
                    >
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger as-child>
                                    <span
                                        class="flex size-2 rounded-full"
                                        :class="{
                                            'bg-cyan-400':
                                                !code.expiration_date,
                                            'bg-amber-600':
                                                code.expiration_date,
                                        }"
                                    >
                                    </span>
                                </TooltipTrigger>

                                <TooltipContent>
                                    <p>
                                        {{
                                            !code.expiration_date
                                                ? 'Activo'
                                                : 'Expirado'
                                        }}
                                    </p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>

                        <div class="flex-1 text-sm text-white/90 uppercase">
                            {{ code.value }}
                        </div>

                        <div class="flex items-center gap-2">
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <Button
                                            variant="ghost"
                                            class="size-10 text-blue-400 hover:bg-blue-100/20 hover:text-blue-400"
                                            @click="copyCode(code.value)"
                                        >
                                            <Files class="size-4" />
                                        </Button>
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        <p>Copiar</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>

                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <X
                                            class="size-4 cursor-pointer text-gray-400 hover:text-gray-500"
                                            @click="
                                                emit('delete:course-code', {
                                                    parent: selectedCourse.parent_id,
                                                    course: selectedCourse.id,
                                                    code: code.id,
                                                })
                                            "
                                        />
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        <p>Eliminar</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                    </div>

                    <Button
                        class="gap-2 font-normal"
                        size="xl"
                        @click="
                            emit('add:course-code', {
                                parent: selectedCourse.parent_id,
                                course: selectedCourse.id,
                            })
                        "
                    >
                        <Plus class="size-4" /> Nuevo código
                    </Button>
                </div>
            </div>

            <div
                v-else
                class="flex flex-col gap-4 rounded-[8px] bg-gray-300 px-10 py-4"
            >
                <p class="text-center text-sm text-gray-500">
                    Los códigos de acceso no están disponibles mientras el curso
                    esté deshabilitado
                </p>
            </div>

            <div class="flex flex-col gap-4">
                <p class="text-sm text-gray-400">Archivos de la carpeta</p>

                <div
                    v-if="!selectedCourse.files?.length"
                    class="flex flex-col gap-4"
                >
                    <p class="text-gray-500">
                        No hay archivos para este contenido
                    </p>

                    <CourseCreation
                        v-if="isVisible"
                        :course="selectedCourse"
                        classes="self-start"
                        @save:course="emit('add:course-file', $event)"
                    >
                        <Button class="gap-2 font-normal" size="xl">
                            <Plus class="size-4" /> Nuevo archivo
                        </Button>
                    </CourseCreation>
                </div>

                <div v-else class="flex w-full flex-wrap items-center gap-2">
                    <div
                        v-for="file in selectedCourse.files"
                        :key="file.id"
                        :class="[
                            'flex h-[56px] items-center justify-between gap-4 rounded-lg px-4 py-2 whitespace-nowrap',
                            isVisible
                                ? 'bg-gray-200 text-white'
                                : 'bg-gray-300 text-blue-950',
                        ]"
                    >
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger as-child>
                                    <div
                                        class="flex flex-1 items-center gap-2 text-sm"
                                    >
                                        <FileText class="size-4" />

                                        {{ middleEllipsis(file.file_name) }}
                                    </div>
                                </TooltipTrigger>

                                <TooltipContent>
                                    <p>{{ file.file_name }}</p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>

                        <div v-if="isVisible" class="flex items-center gap-2">
                            <CourseCreation
                                :course="selectedCourse"
                                :file="file"
                                @save:course="
                                    emit('update:course-file', $event)
                                "
                            >
                                <Button
                                    variant="ghost"
                                    class="size-10 text-blue-400 hover:bg-blue-100/20 hover:text-blue-400"
                                >
                                    <RefreshCcw class="size-4" />
                                </Button>
                            </CourseCreation>

                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <X
                                            class="size-4 cursor-pointer text-gray-400 hover:text-gray-500"
                                            @click="
                                                emit('delete:course-file', {
                                                    parent: selectedCourse.parent_id,
                                                    course: selectedCourse.id,
                                                    file: file.id,
                                                })
                                            "
                                        />
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        <p>Eliminar</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                    </div>

                    <CourseCreation
                        v-if="isVisible"
                        :course="selectedCourse"
                        @save:course="emit('add:course-file', $event)"
                    >
                        <Button class="gap-2 font-normal" size="xl">
                            <Plus class="size-4" /> Nuevo archivo
                        </Button>
                    </CourseCreation>
                </div>
            </div>
        </CardContent>

        <CardFooter class="gap-2">
            <Button
                class="h-[52px] flex-1 gap-2"
                :disabled="isVisible"
                :class="
                    isVisible
                        ? 'bg-cyan-400'
                        : 'bg-blue-950 hover:bg-blue-950/80'
                "
                @click="
                    emit('enable:course', {
                        parent: selectedCourse.parent_id,
                        course: selectedCourse.id,
                    })
                "
            >
                <Eye class="size-4" />
                {{ isVisible ? 'Habilitado' : 'Habilitar' }}
            </Button>

            <Button
                :disabled="!isVisible"
                :variant="!isVisible ? 'default' : 'outline'"
                :class="[
                    'h-[52px] flex-1 gap-2',
                    { 'bg-white text-blue-950': !isVisible },
                ]"
                @click="
                    emit('disable:course', {
                        parent: selectedCourse.parent_id,
                        course: selectedCourse.id,
                    })
                "
            >
                <EyeOff class="size-4" />
                {{ !isVisible ? 'Deshabilitado' : 'Deshabilitar' }}
            </Button>

            <CourseDeletion
                :course="selectedCourse"
                @delete:course="
                    emit('delete:course', {
                        parent: selectedCourse.parent_id,
                        course: selectedCourse.id,
                    })
                "
            >
                <Button variant="destructive" class="size-[52px]">
                    <Trash />
                </Button>
            </CourseDeletion>
        </CardFooter>
    </Card>
</template>
