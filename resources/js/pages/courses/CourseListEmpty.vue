<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import { Info, Link } from 'lucide-vue-next';
import { PropType } from 'vue';

defineProps({
    summary: {
        type: Object as PropType<{
            parents: number;
            courses: number;
            visibles: number;
        }>,
        required: true,
    },
});

function openLink() {
    window.open('https://google.com', '_blank');
}
</script>

<template>
    <section class="flex w-full flex-1 gap-6">
        <Card
            class="relative m-0 flex w-full rounded-[24px] border-none p-0 shadow-none"
        >
            <div
                class="absolute top-6 right-6 flex items-center gap-2 rounded-[24px] bg-cyan-400 px-4 py-2 text-white"
            >
                <Info class="size-4" />
                Modo Administrador
            </div>

            <CardContent class="flex items-end gap-6 px-10 py-0">
                <img
                    src="../../../imgs/img-bienvenida.png"
                    style="width: 315px"
                />

                <div
                    class="h100 flex w-full flex-col items-start justify-center gap-10 px-16 py-10"
                >
                    <div class="flex w-full flex-col gap-4">
                        <div class="flex items-center gap-4">
                            <h2 class="text-3xl font-semibold text-blue-950">
                                ¡Bienvenido!
                            </h2>
                        </div>

                        <div class="flex flex-col justify-center">
                            <h5 class="text-neutral-base font-normal">
                                Elige una de las categorías y gestiona el
                                contenido para el sitio web público de
                                TwoMedics.
                            </h5>
                        </div>
                    </div>

                    <Button size="lg" class="gap-2" @click="openLink">
                        Ir a TwoMedics
                        <Link class="size-4" />
                    </Button>
                </div>
            </CardContent>
        </Card>

        <aside class="flex w-[300px] flex-col gap-4">
            <div
                class="flex h-full flex-col items-center justify-center gap-2 rounded-[8px] bg-blue-950 text-white uppercase"
            >
                <h5 class="text-2xl font-semibold">
                    {{ summary?.parents }}
                </h5>
                <p>Categorías</p>
            </div>

            <div
                class="flex h-full flex-col items-center justify-center gap-2 rounded-[8px] text-white uppercase"
                style="background-color: #4bb8ec"
            >
                <h5 class="text-2xl font-semibold">
                    {{ summary.courses }}
                </h5>
                <p>Contenidos</p>
            </div>

            <div
                class="flex h-full flex-col items-center justify-center gap-2 rounded-[8px] bg-blue-500 text-white uppercase"
            >
                <h5 class="text-2xl font-semibold">
                    {{ summary.visibles }}/{{ summary.courses }}
                </h5>
                <p>Habilitados</p>
            </div>
        </aside>
    </section>
</template>
