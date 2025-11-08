<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarGroup,
    SidebarMenuSub,
    SidebarMenuSubItem,
    SidebarMenuSubButton,
} from '@/components/ui/sidebar';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, PinIcon, ChevronRight, ChevronDown, Hash } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import AppLogo from './AppLogo.vue';

const getStorageState = (key: string, defaultValue: boolean) => {
    const storage = localStorage.getItem(key);
    return storage !== null ? JSON.parse(storage) : defaultValue;
}

const notebooks = ref([
    {
        title: 'Active Notebooks',
        icon: PinIcon,
        isOpen: getStorageState('activeNotebooks', true),
        items: [
            { title: 'Planning Trips', href: '/notebooks/active' },
            { title: 'Making Bread', href: '/notebooks/making-bread' },
            { title: 'Working Out', href: '/notebooks/working-out' },
            { title: 'Downloading Games', href: '/notebooks/downloading-games' },
        ]
    }
]);

watch(
    notebooks,
    (notebooks) => {
        localStorage.setItem('activeNotebooks', JSON.stringify(notebooks[0].isOpen));
    },
    { deep: true }
);

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="'/notebooks/active'">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <SidebarGroup>
                <SidebarMenu>
                    <Collapsible v-for="notebook in notebooks" :key="notebook.title" v-model:open="notebook.isOpen"
                        as-child>
                        <SidebarMenuItem>
                            <CollapsibleTrigger as-child>
                                <SidebarMenuButton class="w-full" :tooltip="notebook.title">
                                    <component :is="notebook.icon" class="size-4" />
                                    <span>{{ notebook.title }}</span>
                                    <ChevronDown v-if="notebook.isOpen" class="ml-auto size-4 transition-transform" />
                                    <ChevronRight v-else class="ml-auto size-4 transition-transform" />
                                </SidebarMenuButton>
                            </CollapsibleTrigger>

                            <CollapsibleContent>
                                <SidebarMenuSub>
                                    <SidebarMenuSubItem v-for="item in notebook.items" :key="item.title">
                                        <SidebarMenuSubButton as-child>
                                            <Link :href="item.href">
                                            <Hash class="size-3 mr-2 opacity-60" />
                                            <span>{{ item.title }}</span>
                                            </Link>
                                        </SidebarMenuSubButton>
                                    </SidebarMenuSubItem>
                                </SidebarMenuSub>
                            </CollapsibleContent>
                        </SidebarMenuItem>
                    </Collapsible>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
