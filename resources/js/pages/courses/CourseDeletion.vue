<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import Separator from '@/components/ui/separator/Separator.vue';
import Tooltip from '@/components/ui/tooltip/Tooltip.vue';
import TooltipContent from '@/components/ui/tooltip/TooltipContent.vue';
import TooltipProvider from '@/components/ui/tooltip/TooltipProvider.vue';
import TooltipTrigger from '@/components/ui/tooltip/TooltipTrigger.vue';
import { middleEllipsis } from '@/lib/utils';
import { Course } from '@/types';
import { FileText } from 'lucide-vue-next';
import { PropType, ref } from 'vue';

defineProps({
    course: {
        type: Object as PropType<Course>,
        required: true,
    },
});

const isOpen = ref(false);

const emit = defineEmits(['delete:course']);
</script>

<template>
    <Dialog class="w-full max-w-[500px] min-w-[500px]" v-model:open="isOpen">
        <DialogTrigger>
            <slot />
        </DialogTrigger>

        <DialogContent class="flex flex-col gap-6">
            <DialogTitle>
                <h5 class="font-medium text-gray-600">
                    ¿Eliminar este contenido?
                </h5>
            </DialogTitle>

            <DialogDescription>
                <p class="text-gray-500">
                    Esta acción no se puede deshacer. El contenido será
                    eliminado permanentemente.
                </p>
            </DialogDescription>

            <div class="flex flex-col gap-2 rounded-[8px] bg-gray-300 p-4">
                <p class="font-semibold text-blue-950">
                    {{ course.name }}
                </p>

                <div class="flex flex-wrap gap-2">
                    <div
                        v-for="file in course.files"
                        :key="file.id"
                        class="flex h-[56px] items-center gap-2 rounded-[8px] px-4 text-blue-950"
                        style="background-color: rgba(1, 126, 255, 0.12)"
                    >
                        <FileText class="size-4" />

                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger as-child>
                                    <p>{{ middleEllipsis(file.file_name) }}</p>
                                </TooltipTrigger>

                                <TooltipContent>
                                    <p>{{ file.file_name }}</p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                    </div>
                </div>
            </div>

            <DialogFooter>
                <div class="flex w-full flex-col gap-4">
                    <Separator orientation="horizontal" class="bg-blue-100" />

                    <div class="flex justify-end gap-2">
                        <Button
                            variant="outline"
                            size="xl"
                            @click="isOpen = false"
                        >
                            No, volver al contenido
                        </Button>

                        <Button
                            size="xl"
                            variant="destructive"
                            @click="emit('delete:course')"
                        >
                            Sí, eliminar contenido
                        </Button>
                    </div>
                </div>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
