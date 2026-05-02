import { Head, Link, router } from '@inertiajs/react';
import { Edit, Plus, Trash2 } from 'lucide-react';
import {
    create,
    destroy,
    edit,
} from '@/actions/App/Http/Controllers/CustomerController';
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

type Customer = {
    id: number;
    name: string;
    phone: string | null;
    email: string | null;
    cep: string | null;
    street: string | null;
    number: string | null;
    complement: string | null;
    state: string | null;
    city: string | null;
    created_at: string;
    updated_at: string;
};

type Props = {
    customers: Customer[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Clientes',
        href: '#',
    },
];

export default function Index({ customers }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Tem certeza que deseja excluir este cliente?')) {
            router.delete(destroy.url(id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clientes" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Clientes</CardTitle>
                            <CardDescription>
                                Gerencie os clientes cadastrados
                            </CardDescription>
                        </div>
                        <Button asChild>
                            <Link href={create().url}>
                                <Plus className="mr-2 h-4 w-4" />
                                Novo Cliente
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nome</TableHead>
                                    <TableHead>Telefone</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Cidade/Estado</TableHead>
                                    <TableHead className="w-[100px] text-right">
                                        Ações
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {customers.length === 0 ? (
                                    <TableRow>
                                        <TableCell
                                            colSpan={5}
                                            className="text-center text-muted-foreground"
                                        >
                                            Nenhum cliente cadastrado
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    customers.map((customer) => (
                                        <TableRow key={customer.id}>
                                            <TableCell className="font-medium">
                                                {customer.name}
                                            </TableCell>
                                            <TableCell>
                                                {customer.phone || '-'}
                                            </TableCell>
                                            <TableCell>
                                                {customer.email || '-'}
                                            </TableCell>
                                            <TableCell>
                                                {customer.city && customer.state
                                                    ? `${customer.city}/${customer.state}`
                                                    : customer.city ||
                                                      customer.state ||
                                                      '-'}
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
                                                                customer.id,
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
                                                                customer.id,
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
