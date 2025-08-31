<script setup lang="ts">
import { useConfirmation } from '@/composables/useConfirmation';
import { Check } from 'lucide-vue-next';
import Button from './ui/button/Button.vue';

const { message, close, isError } = useConfirmation();
</script>

<template>
    <div
        class="flex w-[300px] flex-col items-center gap-10 rounded-[8px] bg-white px-6 py-10 shadow-lg"
    >
        <div class="flex flex-col items-center gap-6">
            <div
                :class="isError ? 'bg-red-200' : 'bg-cyan-200'"
                class="flex flex-col items-center justify-center rounded-full p-6"
            >
                <Check
                    :class="isError ? 'text-destructive' : 'text-cyan-400'"
                    class="size-9"
                />
            </div>

            <div class="flex flex-col items-center gap-2 text-center">
                <h5 class="font-semibold text-gray-600">
                    ¡{{ isError ? 'Oops' : 'Listo' }}!
                </h5>

                <p class="text-gray-500">{{ message }}</p>
            </div>
        </div>

        <Button size="xl" class="self-center" @click="close">Entendido</Button>
    </div>
</template>
