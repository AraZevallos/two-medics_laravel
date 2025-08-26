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
    <Card class="w-full min-w-[660px] self-start shadow-none">
        <CardContent class="flex flex-col items-center gap-4">
            <div class="flex h-[72px] w-[72px] items-center justify-center rounded-full bg-secondary text-secondary-foreground">
                <SquareMousePointer class="h-6 w-6" />
            </div>

            <h5 class="font-normal">Selecciona un contenido</h5>

            <p class="text-center text-sm font-normal text-neutral-500">Elige uno de los contenidos de la lista para ver y editar sus detalles.</p>
        </CardContent>

        <CardFooter class="flex items-center justify-center">
            <CourseCreation @save:course="emit('save:course', $event)">
                <Button>
                    <Plus class="mr-2 size-4" />
                    <span class="text-sm text-neutral-500">También puedes: </span>
                    Agregar un nuevo contenido
                </Button>
            </CourseCreation>
        </CardFooter>
    </Card>
</template>
