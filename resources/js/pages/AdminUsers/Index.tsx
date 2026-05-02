import { Head, Link, router } from '@inertiajs/react';
import { Edit, Plus, Trash2 } from 'lucide-react';
import {
    create,
    destroy,
    edit,
} from '@/actions/App/Http/Controllers/AdminUserController';
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

type User = {
    id: number;
    name: string;
    email: string;
    role: string;
    created_at: string;
    updated_at: string;
};

type Props = {
    users: User[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Usuários',
        href: '#',
    },
];

export default function Index({ users }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Tem certeza que deseja excluir este usuário?')) {
            router.delete(destroy.url(id));
        }
    };

    const getRoleBadge = (role: string) => {
        if (role === 'admin') {
            return (
                <Badge variant="default" className="bg-blue-600">
                    Admin
                </Badge>
            );
        }
        return <Badge variant="secondary">Usuário</Badge>;
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Usuários Admin" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Usuários</CardTitle>
                            <CardDescription>
                                Gerencie os usuários do sistema
                            </CardDescription>
                        </div>
                        <Button asChild>
                            <Link href={create().url}>
                                <Plus className="mr-2 h-4 w-4" />
                                Novo Usuário
                            </Link>
                        </Button>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nome</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Permissão</TableHead>
                                    <TableHead className="w-[100px] text-right">
                                        Ações
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {users.length === 0 ? (
                                    <TableRow>
                                        <TableCell
                                            colSpan={4}
                                            className="text-center text-muted-foreground"
                                        >
                                            Nenhum usuário cadastrado
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    users.map((user) => (
                                        <TableRow key={user.id}>
                                            <TableCell className="font-medium">
                                                {user.name}
                                            </TableCell>
                                            <TableCell>{user.email}</TableCell>
                                            <TableCell>
                                                {getRoleBadge(user.role)}
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
                                                                user.id,
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
                                                                user.id,
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
