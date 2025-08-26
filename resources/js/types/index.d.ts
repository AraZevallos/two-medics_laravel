import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export type NavItem = {
    title: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
    href: string;
};

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export type BreadcrumbItemType = BreadcrumbItem;

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    avatar?: string;
    created_at: string;
    updated_at: string;
}

export interface CourseCode {
    id: number;
    course_id: number;
    is_enabled: boolean;
    is_persistent: boolean;
    expiration_date?: string | null;
    value: string;
}

export interface CourseFile {
    id: number;
    course_id: number;
    file_name: string;
    file_type: string;
    file_path: string;
}

export interface Course {
    id: number;
    name: string;
    parent_id?: number | null;
    icon?: string | null;
    is_visible: boolean;

    // Relaciones
    children?: Course[];
    codes?: CourseCode[];
    files?: CourseFile[];
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};

// types/models.ts
