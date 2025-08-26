<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
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
import { Course } from '@/types';
import {
    ChevronRight,
    CloudDownload,
    Eye,
    EyeOff,
    Files,
    Plus,
    RefreshCcw,
} from 'lucide-vue-next';
import { PropType } from 'vue';
import CourseCreation from './CourseCreation.vue';

const props = defineProps({
    selectedParent: {
        type: Object as PropType<Course>,
        required: true,
    },
    selectedCourse: {
        type: Object as PropType<Course>,
        default: null,
    },
});

const emit = defineEmits([
    'select:course',
    'refresh:parent-code',
    'save:course',
]);

const permanentCode = props.selectedParent.codes?.at(0)?.value ?? '';
</script>

<template>
    <Card class="w-full max-w-[700px] border-none shadow-none">
        <CardHeader>
            <CardTitle class="flex items-center gap-2 text-blue-950">
                <div class="flex-1">
                    {{ selectedParent.name }}
                </div>

                <Badge
                    v-if="selectedParent.children?.length"
                    class="h-8 rounded-full bg-blue-500/20 px-4 py-2 uppercase text-blue-950"
                >
                    {{ selectedParent.children?.length }} contenidos
                </Badge>
            </CardTitle>
        </CardHeader>

        <CardContent class="flex flex-col gap-4">
            <div
                class="flex items-center justify-center gap-4 rounded-md border px-4 py-2"
            >
                <div class="flex items-center">
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <Button
                                    class="w-10 text-blue-400 hover:text-blue-600"
                                    variant="ghost"
                                >
                                    <a
                                        :href="
                                            route(
                                                'courses.download-parent-zip',
                                                { parent: selectedParent.id },
                                            )
                                        "
                                    >
                                        <CloudDownload class="size-4" />
                                    </a>
                                </Button>
                            </TooltipTrigger>

                            <TooltipContent>
                                <p>Descargar todos los archivos</p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>

                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <Button
                                    class="text-blue-400 hover:text-blue-600"
                                    variant="ghost"
                                    @click="
                                        emit('refresh:parent-code', {
                                            parent: selectedParent.id,
                                            course: selectedCourse?.id,
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
                </div>

                <p class="space-x-1 text-sm text-gray-600">
                    Código: <span class="uppercase">{{ permanentCode }}</span>
                </p>

                <Button
                    variant="ghost"
                    class="text-blue-400 hover:text-blue-600"
                    @click="copyCode(permanentCode)"
                >
                    <Files class="size-4" /> Copiar
                </Button>
            </div>

            <div class="flex max-h-[420px] flex-col gap-4 overflow-y-auto">
                <div
                    v-for="course in selectedParent.children"
                    :key="course.id"
                    :class="[
                        'flex cursor-pointer items-center justify-between gap-2 rounded-[16px] p-4',
                        course.id === selectedCourse?.id
                            ? 'bg-blue-100'
                            : 'hover:bg-blue-100/40',
                    ]"
                    @click="
                        emit('select:course', {
                            parent: course.parent_id,
                            course: course.id,
                        })
                    "
                >
                    <ChevronRight class="size-4 text-blue-600" />

                    <div class="flex-1 text-blue-950">
                        {{ course.name }}
                    </div>

                    <div
                        class="flex size-10 items-center justify-center rounded-full bg-cyan-600/80 text-white"
                    >
                        <component
                            :is="course.is_visible ? Eye : EyeOff"
                            class="size-4"
                        />
                    </div>
                </div>
            </div>
        </CardContent>

        <CardFooter>
            <CourseCreation @save:course="emit('save:course', $event)">
                <Button class="h-[52px] w-full rounded-[8px]">
                    <Plus class="mr-2 size-4" /> Agregar contenido
                </Button>
            </CourseCreation>
        </CardFooter>
    </Card>
</template>
