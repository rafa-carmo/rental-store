import {
    create,
    destroy,
    edit,
} from '@/actions/App/Http/Controllers/RentalController';
import { Badge } from '@/components/ui/badge';
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
import { Head, Link, router } from '@inertiajs/react';
import { CheckCircle, Edit, Plus, Trash2 } from 'lucide-react';

type Rental = {
    id: number;
    customer_id: number;
    item_id: number;
    value: string;
    pickup_date: string;
    return_date: string;
    returned_at: string | null;
    customer: {
        id: number;
        name: string;
    };
    item: {
        id: number;
        name: string;
    };
    created_at: string;
    updated_at: string;
};

type Props = {
    rentals: Rental[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Aluguéis',
        href: '#',
    },
];

export default function Index({ rentals }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Tem certeza que deseja excluir este aluguel?')) {
            router.delete(destroy.url(id));
        }
    };

    const handleMarkAsReturned = (id: number) => {
        if (confirm('Confirmar devolução do item?')) {
            router.patch(route('rentals.return', id));
        }
    };

    const formatCurrency = (value: string) => {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        }).format(parseFloat(value));
    };

    const formatDate = (date: string) => {
        return new Date(date + 'T00:00:00').toLocaleDateString('pt-BR');
    };

    const formatDateTime = (date: string) => {
        return new Date(date).toLocaleString('pt-BR');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Aluguéis" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Aluguéis</CardTitle>
                            <CardDescription>
                                Gerencie os aluguéis de itens
                            </CardDescription>
                        </div>
                        <Button asChild>
                            <Link href={create().url}>
                                <Plus className="mr-2 h-4 w-4" />
                                Novo Aluguel
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Cliente</TableHead>
                                    <TableHead>Item</TableHead>
                                    <TableHead>Valor</TableHead>
                                    <TableHead>Data Retirada</TableHead>
                                    <TableHead>Data Entrega</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead className="w-[150px] text-right">
                                        Ações
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {rentals.length === 0 ? (
                                    <TableRow>
                                        <TableCell
                                            colSpan={7}
                                            className="text-center text-muted-foreground"
                                        >
                                            Nenhum aluguel cadastrado
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    rentals.map((rental) => (
                                        <TableRow key={rental.id}>
                                            <TableCell className="font-medium">
                                                {rental.customer.name}
                                            </TableCell>
                                            <TableCell>
                                                {rental.item.name}
                                            </TableCell>
                                            <TableCell>
                                                {formatCurrency(rental.value)}
                                            </TableCell>
                                            <TableCell>
                                                {formatDate(rental.pickup_date)}
                                            </TableCell>
                                            <TableCell>
                                                {formatDate(rental.return_date)}
                                            </TableCell>
                                            <TableCell>
                                                {rental.returned_at ? (
                                                    <Badge variant="success">
                                                        Devolvido
                                                    </Badge>
                                                ) : (
                                                    <Badge variant="warning">
                                                        Pendente
                                                    </Badge>
                                                )}
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <div className="flex justify-end gap-2">
                                                    {!rental.returned_at && (
                                                        <Button
                                                            variant="ghost"
                                                            size="icon"
                                                            onClick={() =>
                                                                handleMarkAsReturned(
                                                                    rental.id,
                                                                )
                                                            }
                                                            title="Registrar Devolução"
                                                        >
                                                            <CheckCircle className="h-4 w-4" />
                                                        </Button>
                                                    )}
                                                    <Button
                                                        variant="ghost"
                                                        size="icon"
                                                        asChild
                                                    >
                                                        <Link
                                                            href={edit.url(
                                                                rental.id,
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
                                                                rental.id,
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
