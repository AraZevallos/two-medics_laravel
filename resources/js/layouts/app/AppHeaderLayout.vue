<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppHeader from '@/components/AppHeader.vue';
import AppShell from '@/components/AppShell.vue';
import type { BreadcrumbItemType } from '@/types';
import { Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';

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
    </AppShell>
</template>
