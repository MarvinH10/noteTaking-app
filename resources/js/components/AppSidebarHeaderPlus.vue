<script setup lang="ts">
import { SidebarTrigger } from '@/components/ui/sidebar';
import Button from './ui/button/Button.vue';
import { FilePlus, BookPlus, Share2, Menu, X } from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const handleClickOutside = (event: MouseEvent) => {
    const target = event.target as HTMLElement;
    const menuButton = document.querySelector('[data-menu-button]') as HTMLElement;
    const menuDropdown = document.querySelector('[data-menu-dropdown]') as HTMLElement;

    if (isMenuOpen.value && menuButton && menuDropdown && !menuButton.contains(target) && !menuDropdown.contains(target)) {
        isMenuOpen.value = false;
    }
}

const handleAddPage = () => {
    console.log('Add Page');
};

const handleAddNotebook = () => {
    console.log('Add Notebook');
};

const handleShareLink = () => {
    console.log('Share Link');
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
})
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-4 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-6">
        <div class="flex items-center gap-2 w-full">
            <SidebarTrigger class="-ml-1" />
            <div class="flex items-center justify-between w-full gap-2">
                <div class="flex gap-2">
                    <Button variant="secondary" class="hidden sm:flex" @click="handleAddPage">
                        <FilePlus class="size-4" />
                        <span class="hidden md:inline">Add Page</span>
                    </Button>
                    <Button variant="secondary" class="hidden sm:flex" @click="handleAddNotebook">
                        <BookPlus class="size-4" />
                        <span class="hidden md:inline">Add Notebook</span>
                    </Button>
                </div>

                <div class="flex items-center gap-2">
                    <Button variant="ghost" @click="handleShareLink"
                        class="gap-2 px-3 py-1.5 rounded-full bg-muted hover:bg-muted/80 hidden sm:flex">
                        <Share2 class="size-4" />
                        <span class="text-sm hidden lg:inline">Share Link</span>
                        <div class="size-7 rounded-full bg-gray-400 border-2 border-background overflow-hidden">
                            <img src="https://img.freepik.com/free-vector/smiling-young-man-illustration_1308-174669.jpg?semt=ais_hybrid&w=740&q=80"
                                alt="User" class="w-full h-full object-cover" />
                        </div>
                    </Button>
                    <Button variant="ghost" size="icon"
                        class="gap-2 px-3 py-1.5 rounded-full bg-muted hover:bg-muted/80" @click="toggleMenu"
                        data-menu-button>
                        <Menu v-if="!isMenuOpen" class="size-4" />
                        <X v-else class="size-4" />
                    </Button>
                </div>
            </div>
        </div>

        <!-- Menu desplegable -->
        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
            <div v-if="isMenuOpen"
                class="absolute top-16 right-4 w-64 bg-background border border-sidebar-border rounded-lg shadow-lg p-4 z-50"
                data-menu-dropdown>
                <div class="flex flex-col gap-2">
                    <Button variant="secondary" class="w-full justify-center sm:hidden" @click="handleAddPage">
                        <FilePlus class="size-4" />
                        Add Page
                    </Button>
                    <Button variant="secondary" class="w-full justify-center sm:hidden" @click="handleAddNotebook">
                        <BookPlus class="size-4" />
                        Add Notebook
                    </Button>
                    <Button variant="secondary" class="w-full justify-center gap-2 sm:hidden" @click="handleShareLink">
                        <Share2 class="size-4" />
                        Share Link
                        <div class="size-7 rounded-full bg-gray-400 border-2 border-background overflow-hidden">
                            <img src="https://img.freepik.com/free-vector/smiling-young-man-illustration_1308-174669.jpg?semt=ais_hybrid&w=740&q=80"
                                alt="User" class="w-full h-full object-cover" />
                        </div>
                    </Button>
                </div>
            </div>
        </Transition>
    </header>
</template>
