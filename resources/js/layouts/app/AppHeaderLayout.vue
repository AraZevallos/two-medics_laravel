<script setup lang="ts">
import AppConfirmation from '@/components/AppConfirmation.vue';
import AppContent from '@/components/AppContent.vue';
import AppHeader from '@/components/AppHeader.vue';
import AppShell from '@/components/AppShell.vue';
import { useConfirmation } from '@/composables/useConfirmation';
import type { BreadcrumbItemType } from '@/types';
import { Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';

const { isVisible } = useConfirmation();

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell class="flex-col bg-blue-100/50">
        <AppHeader :breadcrumbs="breadcrumbs" class="bg-white" />
        <AppContent>
            <slot />
        </AppContent>

        <Toaster />

        <transition name="fade">
            <div
                v-if="isVisible"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            >
                <AppConfirmation />
            </div>
        </transition>
    </AppShell>
</template>
