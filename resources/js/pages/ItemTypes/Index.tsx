import { Head, Link, router } from '@inertiajs/react';
import { Edit, Plus, Trash2 } from 'lucide-react';
import {
    create,
    destroy,
    edit,
} from '@/actions/App/Http/Controllers/ItemTypeController';
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
    created_at: string;
    updated_at: string;
};

type Props = {
    itemTypes: ItemType[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tipos de Itens',
        href: '#',
    },
];

export default function Index({ itemTypes }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Tem certeza que deseja excluir este tipo de item?')) {
            router.delete(destroy.url(id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tipos de Itens" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Tipos de Itens</CardTitle>
                            <CardDescription>
                                Gerencie os tipos de itens disponíveis para
                                locação
                            </CardDescription>
                        </div>
                        <Button asChild>
                            <Link href={create().url}>
                                <Plus className="mr-2 h-4 w-4" />
                                Novo Tipo
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nome</TableHead>
                                    <TableHead>Descrição</TableHead>
                                    <TableHead className="w-[100px]">
                                        Status
                                    </TableHead>
                                    <TableHead className="w-[100px] text-right">
                                        Ações
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {itemTypes.length === 0 ? (
                                    <TableRow>
                                        <TableCell
                                            colSpan={4}
                                            className="text-center text-muted-foreground"
                                        >
                                            Nenhum tipo de item cadastrado
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    itemTypes.map((itemType) => (
                                        <TableRow key={itemType.id}>
                                            <TableCell className="font-medium">
                                                {itemType.name}
                                            </TableCell>
                                            <TableCell>
                                                {itemType.description || '-'}
                                            </TableCell>
                                            <TableCell>
                                                <span
                                                    className={`inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ${
                                                        itemType.is_active
                                                            ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400'
                                                            : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400'
                                                    }`}
                                                >
                                                    {itemType.is_active
                                                        ? 'Ativo'
                                                        : 'Inativo'}
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
                                                                itemType.id,
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
                                                                itemType.id,
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
