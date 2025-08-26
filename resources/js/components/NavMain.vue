<script setup lang="ts">
import { type NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

// const page = usePage();
</script>

<template>
    <div></div>
    <!-- <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton v-if="!item.children?.length" as-child :is-active="item.href === page.url" :tooltip="item.title">
                    <Link :href="item.href" prefetch>
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>

                <Collapsible
                    v-else
                    :title="item.title"
                    :default-open="item.children.some((child) => child.href === page.url)"
                    class="group/collapsible"
                >
                    <CollapsibleTrigger as-child>
                        <SidebarMenuButton :tooltip="item.title">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                            <SidebarMenuBadge>{{ item.children.length }}</SidebarMenuBadge>
                        </SidebarMenuButton>
                    </CollapsibleTrigger>

                    <CollapsibleContent>
                        <SidebarMenuSub>
                            <SidebarMenuSubItem>
                                <SidebarMenuSubButton
                                    v-for="child in item.children"
                                    :key="child.title"
                                    :is-active="child.href === page.url"
                                    :tooltip="child.title"
                                    as-child
                                >
                                    <Link :href="child.href" prefetch>
                                        <component :is="child.icon" />
                                        <span>{{ child.title }}</span>
                                    </Link>
                                </SidebarMenuSubButton>
                            </SidebarMenuSubItem>
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </Collapsible>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup> -->
</template>
