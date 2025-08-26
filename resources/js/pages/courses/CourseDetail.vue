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
import { copyCode } from '@/lib/utils';
import { Course, CourseCode } from '@/types';
import {
    Eye,
    EyeOff,
    Files,
    Plus,
    RefreshCcw,
    Trash,
    X,
} from 'lucide-vue-next';
import { PropType, watch } from 'vue';
import CourseCreation from './CourseCreation.vue';

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
        class="w-full min-w-[660px] self-start border-none bg-blue-950 shadow-none"
    >
        <CardHeader>
            <CardTitle class="flex items-center gap-2">
                <div class="flex-1 text-white">
                    {{ selectedCourse.name }}
                </div>

                <div
                    v-if="permanentCode"
                    class="flex items-center space-x-2 p-4"
                >
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <Button
                                    variant="ghost"
                                    class="text-blue-400 hover:bg-blue-100/20 hover:text-blue-400"
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

        <CardContent class="flex flex-col gap-8 text-gray-400">
            <div class="flex flex-col gap-4">
                <p class="text-sm">Códigos de acceso único</p>

                <div class="flex w-full flex-wrap gap-2">
                    <div
                        v-for="code in temporaryCodes"
                        :key="code.id"
                        class="flex items-center justify-between gap-2 rounded-lg bg-blue-50/10 py-2 pr-2 pl-4 text-white"
                    >
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger as-child>
                                    <span
                                        class="flex size-2 rounded-full"
                                        :class="{
                                            'bg-cyan-600':
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

                        <div class="flex items-center">
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <Button
                                            variant="ghost"
                                            class="text-blue-400 hover:bg-blue-100/20 hover:text-blue-400"
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
                                        <Button
                                            variant="ghost"
                                            class="text-gray-400 hover:bg-blue-100/20 hover:text-gray-400"
                                            @click="
                                                emit('delete:course-code', {
                                                    parent: selectedCourse.parent_id,
                                                    course: selectedCourse.id,
                                                    code: code.id,
                                                })
                                            "
                                        >
                                            <X class="size-4" />
                                        </Button>
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        <p>Eliminar</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                    </div>
                </div>

                <Button
                    class="self-start font-normal"
                    size="lg"
                    @click="
                        emit('add:course-code', {
                            parent: selectedCourse.parent_id,
                            course: selectedCourse.id,
                        })
                    "
                >
                    <Plus class="mr-2 size-4" /> Nuevo código
                </Button>
            </div>

            <div class="flex flex-col gap-4">
                <p class="text-sm">Archivos de la carpeta</p>

                <div class="flex w-full flex-wrap gap-2">
                    <div
                        v-for="file in selectedCourse.files"
                        :key="file.id"
                        class="flex items-center justify-between gap-2 rounded-lg bg-blue-400/10 py-2 pr-2 pl-4 whitespace-nowrap text-white/90"
                    >
                        <div class="flex-1 truncate text-sm">
                            {{ file.file_name }}
                        </div>

                        <div class="flex items-center">
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <CourseCreation
                                            :course="selectedCourse"
                                            :file="file"
                                            @save:course="
                                                emit(
                                                    'update:course-file',
                                                    $event,
                                                )
                                            "
                                        >
                                            <Button
                                                variant="ghost"
                                                class="text-blue-400 hover:bg-blue-100/20 hover:text-blue-400"
                                            >
                                                <RefreshCcw class="size-4" />
                                            </Button>
                                        </CourseCreation>
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        <p>Cargar otro archivo</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>

                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <Button
                                            variant="ghost"
                                            class="text-gray-400 hover:bg-blue-100/20 hover:text-gray-400"
                                            @click="
                                                emit('delete:course-file', {
                                                    parent: selectedCourse.parent_id,
                                                    course: selectedCourse.id,
                                                    file: file.id,
                                                })
                                            "
                                        >
                                            <X class="size-4" />
                                        </Button>
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        <p>Eliminar</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                    </div>
                </div>

                <CourseCreation
                    :course="selectedCourse"
                    @save:course="emit('add:course-file', $event)"
                >
                    <Button class="self-start font-normal" size="lg">
                        <Plus class="mr-2 size-4" /> Nuevo archivo
                    </Button>
                </CourseCreation>
            </div>
        </CardContent>

        <CardFooter class="gap-2">
            <Button
                class="h-[52px] flex-1"
                :variant="selectedCourse.is_visible ? 'default' : 'outline'"
                :disabled="selectedCourse.is_visible"
                :class="{ 'bg-cyan-600': selectedCourse.is_visible }"
                @click="
                    emit('enable:course', {
                        parent: selectedCourse.parent_id,
                        course: selectedCourse.id,
                    })
                "
            >
                <Eye class="mr-2 size-4" />
                {{ selectedCourse.is_visible ? 'Habilitado' : 'Habilitar' }}
            </Button>

            <Button
                class="h-[52px] flex-1"
                :variant="!selectedCourse.is_visible ? 'default' : 'outline'"
                :disabled="!selectedCourse.is_visible"
                @click="
                    emit('disable:course', {
                        parent: selectedCourse.parent_id,
                        course: selectedCourse.id,
                    })
                "
            >
                <EyeOff class="mr-2 size-4" />
                {{
                    !selectedCourse.is_visible
                        ? 'Deshabilitado'
                        : 'Deshabilitar'
                }}
            </Button>

            <Button
                variant="destructive"
                class="h-[52px] w-[52px]"
                @click="
                    emit('delete:course', {
                        parent: selectedCourse.parent_id,
                        course: selectedCourse.id,
                    })
                "
            >
                <Trash />
            </Button>
        </CardFooter>
    </Card>
</template>
