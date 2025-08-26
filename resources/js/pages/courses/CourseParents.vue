<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Course } from '@/types';
import { FilePenLine, LucideIcon, Megaphone, MessageCircleQuestion, Rocket, SquarePlay } from 'lucide-vue-next';
import { PropType } from 'vue';

defineProps({
    parents: {
        type: Array as PropType<Array<Course>>,
        required: true,
    },
    selectedParent: {
        type: Object as PropType<Course>,
    },
});

const emit = defineEmits(['select:parent']);

const iconsMap: Record<string, LucideIcon> = {
    filepenline: FilePenLine,
    rocket: Rocket,
    messagecirclequestion: MessageCircleQuestion,
    megaphone: Megaphone,
    squareplay: SquarePlay,
};
</script>

<template>
    <div class="flex w-full gap-2">
        <Button
            v-for="parent in parents"
            :key="parent.id"
            :variant="parent.id === selectedParent?.id ? 'default' : 'ghost'"
            class="h-[42px] rounded-full"
            @click="emit('select:parent', { parent: parent.id })"
        >
            <component v-if="parent.icon" :is="iconsMap[parent.icon]" class="h-5 w-5" />
            <span>{{ parent.name }}</span>
        </Button>
    </div>
</template>
