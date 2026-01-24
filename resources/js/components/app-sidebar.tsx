import { index as adminUsersIndex } from '@/actions/App/Http/Controllers/AdminUserController';
import { index as customersIndex } from '@/actions/App/Http/Controllers/CustomerController';
import { index as itemsIndex } from '@/actions/App/Http/Controllers/ItemController';
import { index as itemTypesIndex } from '@/actions/App/Http/Controllers/ItemTypeController';
import { index as rentalsIndex } from '@/actions/App/Http/Controllers/RentalController';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
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
import { Link } from '@inertiajs/react';
import {
    BookOpen,
    Box,
    FileText,
    Folder,
    LayoutGrid,
    Package,
    UserCog,
    Users,
} from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Tipos de Itens',
        href: itemTypesIndex(),
        icon: Package,
    },
    {
        title: 'Itens',
        href: itemsIndex(),
        icon: Box,
    },
    {
        title: 'Clientes',
        href: customersIndex(),
        icon: Users,
    },
    {
        title: 'Aluguéis',
        href: rentalsIndex(),
        icon: FileText,
    },
    {
        title: 'Usuários',
        href: adminUsersIndex(),
        icon: UserCog,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
