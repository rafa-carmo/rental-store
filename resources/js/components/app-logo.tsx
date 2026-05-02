import { usePage } from '@inertiajs/react';
import { Box } from 'lucide-react';


export default function AppLogo() {
    const { name } = usePage().props;
    return (
        <>
            <div className="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
                <Box className="h-5 w-5 text-primary-foreground" />
            </div>
            <div className="ml-1 grid flex-1 text-left text-sm">
                <span className="mb-0.5 truncate leading-tight font-semibold line-clamp-2">
                    {name}
                </span>
            </div>
        </>
    );
}
