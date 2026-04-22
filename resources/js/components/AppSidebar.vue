<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    BookUser,
    Contact,
    DollarSign,
    Folder,
    FolderCheck,
    FolderCheckIcon,
    FolderClock,
    FolderDot,
    FolderGit2,
    Hand,
    HandCoins,
    LayoutGrid,
    User,
    Users,
} from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    { title: 'Projets', href: '/admin/projets', icon: FolderCheck },
    { title: 'Equipe', href: '/admin/equipes', icon: Users },
    { title: 'Formations', href: '/admin/formations', icon: Folder },
    { title: 'Membres', href: '/admin/membres', icon: BookUser },
    { title: 'Participants', href: '/admin/participants', icon: Contact },
    { title: 'Tarifs', href: '/admin/tarifs', icon: DollarSign },
    { title: 'Echéanciers', href: '/admin/echeanciers', icon: FolderClock },
    { title: 'Versements', href: '/admin/versements', icon: HandCoins },
    { title: 'Users', href: '/admin/users', icon: User },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/Trolleybeats/utrail_limal',
        icon: FolderGit2,
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
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
