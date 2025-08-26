<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import { Plus, SquareMousePointer } from 'lucide-vue-next';
import CourseCreation from './CourseCreation.vue';

const emit = defineEmits(['save:course']);
</script>

<template>
    <Card
        class="w-full min-w-[660px] self-start border-none bg-blue-950 shadow-none"
    >
        <CardContent class="flex flex-col items-center gap-4">
            <div
                class="flex h-[72px] w-[72px] items-center justify-center rounded-full bg-gray-200/60 text-white"
            >
                <SquareMousePointer class="h-6 w-6" />
            </div>

            <h5 class="font-semibold text-white">Selecciona un contenido</h5>

            <p class="text-center text-sm font-normal text-gray-300">
                Elige uno de los contenidos de la lista para ver y editar sus
                detalles.
            </p>
        </CardContent>

        <CardFooter class="flex items-center justify-center">
            <CourseCreation @save:course="emit('save:course', $event)">
                <Button class="bg-blue-400/10 hover:bg-blue-400/20" size="xl">
                    <Plus class="mr-2 size-4" />
                    <span class="text-sm text-gray-300">También puedes: </span>
                    Agregar un nuevo contenido
                </Button>
            </CourseCreation>
        </CardFooter>
    </Card>
</template>
