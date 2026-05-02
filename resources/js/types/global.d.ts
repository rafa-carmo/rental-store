import type { PageProps as InertiaPageProps } from "@inertiajs/core"
import type { PageProps as AppPageProps } from "./"


declare module "@inertiajs/core" {
	interface PageProps extends InertiaPageProps, AppPageProps {
        name?: string;
        auth: {
            user: App.Models.User & { permissions: string[]; notifications: App.Models.Notification[] } | null;
        };
    }
}
