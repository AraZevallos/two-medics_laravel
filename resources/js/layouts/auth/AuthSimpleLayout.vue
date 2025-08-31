<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="relative flex min-h-svh items-center justify-center p-6 md:p-10"
        style="gap: 200px; background-image: url('/bg-login.webp')"
    >
        <div
            class="flex flex-col items-start gap-4"
            style="padding-bottom: 100px"
        >
            <div class="flex items-center justify-center gap-6">
                <Link
                    :href="route('courses.index')"
                    class="flex flex-col items-center gap-2 font-medium"
                >
                    <AppLogoIcon
                        class="size-[110px] rounded-[8px] object-contain"
                    />

                    <span class="sr-only">{{ title }}</span>
                </Link>

                <div class="flex flex-col text-[32px]">
                    <h2 class="font-semibold text-white">Two</h2>

                    <h2 class="font-semibold text-blue-600">Admins</h2>
                </div>
            </div>

            <h5 class="font-normal text-white">
                Sistema administrativo de TwoMedics
            </h5>
        </div>

        <div
            class="flex w-[420px] flex-col gap-10 rounded-[8px] p-10"
            style="
                background-color: rgba(1, 126, 255, 0.12);
                border: 2px solid rgba(250, 250, 250, 0.12);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            "
        >
            <div class="space-y-2 text-center">
                <h4 class="text-center text-[20px] font-semibold text-blue-300">
                    Inicia sesión
                </h4>
                <!-- 
                <p class="text-muted-foreground text-center text-sm">
                    {{ description }}
                </p> -->
            </div>

            <slot />
        </div>
        <!-- <div class="w-full max-w-sm">
            <div
                class="bg-[rgba(1, 126, 255, 0.12)] border-[rgba(250, 250, 250, 0.12)] box-border flex flex-col gap-8 rounded-[8px] border-2 p-8"
                style="
                    backdrop-filter: blur(20px);
                    -webkit-backdrop-filter: blur(20px);
                "
            >
                <div class="flex flex-col items-center gap-4">
                    <Link
                        :href="route('courses.index')"
                        class="flex flex-col items-center gap-2 font-medium"
                    >
                        <AppLogoIcon
                            class="mb-1 size-[110px] rounded-[8px] object-contain"
                        />

                        <span class="sr-only">{{ title }}</span>
                    </Link>

                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium text-blue-400">
                            {{ title }}
                        </h1>

                        <p class="text-muted-foreground text-center text-sm">
                            {{ description }}
                        </p>
                    </div>
                </div>

                <slot />
            </div>
        </div> -->

        <div
            class="absolute bottom-0 flex w-full flex-col items-center justify-center py-4"
            style="background-color: rgba(112, 127, 143, 0.12)"
        >
            <p class="font-normal" style="color: #babfc4">
                © 2025 TwoMedics. Todos los derechos reservados.
            </p>
        </div>
    </div>
</template>
