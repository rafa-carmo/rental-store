import { Head, Link, router } from '@inertiajs/react';
import { Edit, Plus, Trash2 } from 'lucide-react';
import {
    create,
    destroy,
    edit,
} from '@/actions/App/Http/Controllers/ItemController';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

type ItemType = {
    id: number;
    name: string;
    description: string | null;
    is_active: boolean;
};

type Item = {
    id: number;
    name: string;
    description: string | null;
    image: string | null;
    item_type_id: number;
    status: 'disponivel' | 'alugado' | 'indisponivel';
    created_at: string;
    updated_at: string;
    item_type: ItemType;
};

type Props = {
    items: Item[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Itens',
        href: '#',
    },
];

const statusConfig = {
    disponivel: {
        label: 'Disponível',
        className:
            'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400',
    },
    alugado: {
        label: 'Alugado',
        className:
            'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400',
    },
    indisponivel: {
        label: 'Indisponível',
        className:
            'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400',
    },
};

export default function Index({ items }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Tem certeza que deseja excluir este item?')) {
            router.delete(destroy.url(id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Itens" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Itens para Locação</CardTitle>
                            <CardDescription>
                                Gerencie os itens disponíveis para locação
                            </CardDescription>
                        </div>
                        <Button asChild>
                            <Link href={create().url}>
                                <Plus className="mr-2 h-4 w-4" />
                                Novo Item
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nome</TableHead>
                                    <TableHead>Tipo</TableHead>
                                    <TableHead>Descrição</TableHead>
                                    <TableHead className="w-[120px]">
                                        Status
                                    </TableHead>
                                    <TableHead className="w-[100px] text-right">
                                        Ações
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {items.length === 0 ? (
                                    <TableRow>
                                        <TableCell
                                            colSpan={5}
                                            className="text-center text-muted-foreground"
                                        >
                                            Nenhum item cadastrado
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    items.map((item) => (
                                        <TableRow key={item.id}>
                                            <TableCell className="font-medium">
                                                {item.name}
                                            </TableCell>
                                            <TableCell>
                                                {item.item_type.name}
                                            </TableCell>
                                            <TableCell>
                                                {item.description || '-'}
                                            </TableCell>
                                            <TableCell>
                                                <span
                                                    className={`inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ${statusConfig[item.status].className}`}
                                                >
                                                    {
                                                        statusConfig[
                                                            item.status
                                                        ].label
                                                    }
                                                </span>
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    <Button
                                                        variant="ghost"
                                                        size="icon"
                                                        asChild
                                                    >
                                                        <Link
                                                            href={edit.url(
                                                                item.id,
                                                            )}
                                                        >
                                                            <Edit className="h-4 w-4" />
                                                        </Link>
                                                    </Button>
                                                    <Button
                                                        variant="ghost"
                                                        size="icon"
                                                        onClick={() =>
                                                            handleDelete(
                                                                item.id,
                                                            )
                                                        }
                                                    >
                                                        <Trash2 className="h-4 w-4" />
                                                    </Button>
                                                </div>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                )}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
