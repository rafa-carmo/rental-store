import { Form, Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import {
    index,
    store,
} from '@/actions/App/Http/Controllers/AdminUserController';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Usuários',
        href: index().url,
    },
    {
        title: 'Novo Usuário',
        href: '#',
    },
];

export default function Create() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Novo Usuário" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card className="mx-auto w-full max-w-2xl">
                    <CardHeader>
                        <div className="flex items-center gap-4">
                            <Button variant="ghost" size="icon" asChild>
                                <Link href={index().url}>
                                    <ArrowLeft className="h-4 w-4" />
                                </Link>
                            </Button>
                            <div>
                                <CardTitle>Novo Usuário</CardTitle>
                                <CardDescription>
                                    Cadastre um novo usuário do sistema
                                </CardDescription>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Form {...store.form()}>
                            {({ errors, processing, data, setData }) => (
                                <div className="space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="name">Nome *</Label>
                                        <Input
                                            id="name"
                                            name="name"
                                            placeholder="Digite o nome completo"
                                            required
                                        />
                                        {errors.name && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.name}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="email">Email *</Label>
                                        <Input
                                            id="email"
                                            name="email"
                                            type="email"
                                            placeholder="usuario@email.com"
                                            required
                                        />
                                        {errors.email && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.email}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="password">
                                            Senha *
                                        </Label>
                                        <Input
                                            id="password"
                                            name="password"
                                            type="password"
                                            placeholder="Digite a senha"
                                            required
                                        />
                                        {errors.password && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.password}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="password_confirmation">
                                            Confirmar Senha *
                                        </Label>
                                        <Input
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            type="password"
                                            placeholder="Digite a senha novamente"
                                            required
                                        />
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="role">
                                            Permissão *
                                        </Label>
                                        <Select
                                            name="role"
                                            value={data.role}
                                            onValueChange={(value) =>
                                                setData('role', value)
                                            }
                                            required
                                        >
                                            <SelectTrigger>
                                                <SelectValue placeholder="Selecione a permissão" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="user">
                                                    Usuário
                                                </SelectItem>
                                                <SelectItem value="admin">
                                                    Admin
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                        {errors.role && (
                                            <p className="text-sm text-red-600 dark:text-red-400">
                                                {errors.role}
                                            </p>
                                        )}
                                    </div>

                                    <div className="flex justify-end gap-4">
                                        <Button variant="outline" asChild>
                                            <Link href={index().url}>
                                                Cancelar
                                            </Link>
                                        </Button>
                                        <Button
                                            type="submit"
                                            disabled={processing}
                                        >
                                            {processing
                                                ? 'Salvando...'
                                                : 'Salvar'}
                                        </Button>
                                    </div>
                                </div>
                            )}
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
