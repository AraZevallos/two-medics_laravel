<script setup lang="ts">
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import { Link } from 'lucide-vue-next';
import { PropType } from 'vue';

defineProps({
    summary: {
        type: Object as PropType<{ parents: number; courses: number; visibles: number }>,
        required: true,
    },
});

function openLink() {
    window.open('https://twomedics.com', '_blank');
}
</script>

<template>
    <section class="flex w-full flex-1 gap-6 px-6">
        <Card class="br-24 relative flex w-full items-end gap-6 px-10 shadow-none">
            <Badge class="absolute top-6 right-6"> Modo Administrador </Badge>

            <CardContent class="flex">
                <img src="../../../imgs/img-bienvenida.png" style="width: 315px" />

                <div class="h100 flex w-full flex-col items-start justify-center gap-10 px-16 py-10">
                    <div class="flex w-full flex-col gap-4">
                        <div class="flex items-center gap-4">
                            <h2 class="text-secondary-first-hard font-semibold">¡Bienvenido!</h2>
                        </div>

                        <div class="flex flex-col justify-center">
                            <h5 class="text-neutral-base font-normal">
                                Elige una de las categorías y gestiona el contenido para el sitio web público de TwoMedics.
                            </h5>
                        </div>
                    </div>

                    <Button @click="openLink">
                        <Link class="mr-2 size-4" />
                        Ir a TwoMedics
                    </Button>
                </div>
            </CardContent>
        </Card>

        <aside class="flex w-[300px] flex-col gap-4">
            <Card class="h-[100%] shadow-none">
                <CardContent class="flex flex-col items-center gap-4">
                    <h5 class="font-semibold">{{ summary?.parents }}</h5>
                    <p>Categorías</p>
                </CardContent>
            </Card>

            <Card class="h-[100%] shadow-none">
                <CardContent class="flex flex-col items-center gap-4">
                    <h5 class="font-semibold">{{ summary.courses }}</h5>
                    <p>Contenidos</p>
                </CardContent>
            </Card>

            <Card class="h-[100%] shadow-none">
                <CardContent class="flex flex-col items-center gap-4">
                    <h5 class="font-semibold">{{ summary.visibles }}/{{ summary.courses }}</h5>
                    <p>Habilitados</p>
                </CardContent>
            </Card>
        </aside>
    </section>
</template>
