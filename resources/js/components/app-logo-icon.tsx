import { Box } from 'lucide-react';
import type { SVGAttributes } from 'react';
import { cn } from '@/lib/utils';

export default function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <Box {...props} className={cn(["w-5 h-5 text-primary-foreground", props.className])} />
    );
}
