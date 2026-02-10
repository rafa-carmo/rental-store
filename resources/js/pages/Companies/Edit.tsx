import { Form, Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import {
    index,
    update,
} from '@/actions/App/Http/Controllers/CompanyController';
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
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

type Company = {
    id: number;
    name: string;
    email: string;
    phone: string;
    cep: string;
    street: string;
    number: string;
    city: string;
    state: string;
    country: string;
};

type Props = {
    company: Company;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Empresas',
        href: index().url,
    },
    {
        title: 'Editar Empresa',
        href: '#',
    },
];

export default function Edit({ company }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Empresa" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto p-4">
                <Card className="mx-auto w-full max-w-3xl">
                    <CardHeader>
                        <div className="flex items-center gap-4">
                            <Button variant="ghost" size="icon" asChild>
                                <Link href={index().url}>
                                    <ArrowLeft className="h-4 w-4" />
                                </Link>
                            </Button>
                            <div>
                                <CardTitle>Editar Empresa</CardTitle>
                                <CardDescription>
                                    Atualize as informações da empresa
                                </CardDescription>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Form {...update.form(company.id)} defaults={company}>
                            {({ errors, processing }) => (
                                <div className="space-y-6">
                                    <div className="space-y-4">
                                        <h3 className="text-lg font-medium">
                                            Informações Básicas
                                        </h3>
                                        <div className="grid gap-4 md:grid-cols-2">
                                            <div className="space-y-2 md:col-span-2">
                                                <Label htmlFor="name">
                                                    Nome *
                                                </Label>
                                                <Input
                                                    id="name"
                                                    name="name"
                                                    placeholder="Digite o nome da empresa"
                                                    defaultValue={company.name}
                                                    required
                                                />
                                                {errors.name && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.name}
                                                    </p>
                                                )}
                                            </div>

                                            <div className="space-y-2">
                                                <Label htmlFor="email">
                                                    Email *
                                                </Label>
                                                <Input
                                                    id="email"
                                                    name="email"
                                                    type="email"
                                                    placeholder="exemplo@empresa.com"
                                                    defaultValue={company.email}
                                                    required
                                                />
                                                {errors.email && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.email}
                                                    </p>
                                                )}
                                            </div>

                                            <div className="space-y-2">
                                                <Label htmlFor="phone">
                                                    Telefone *
                                                </Label>
                                                <Input
                                                    id="phone"
                                                    name="phone"
                                                    placeholder="(00) 00000-0000"
                                                    defaultValue={company.phone}
                                                    required
                                                />
                                                {errors.phone && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.phone}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    </div>

                                    <div className="space-y-4">
                                        <h3 className="text-lg font-medium">
                                            Endereço
                                        </h3>
                                        <div className="grid gap-4 md:grid-cols-6">
                                            <div className="space-y-2 md:col-span-2">
                                                <Label htmlFor="cep">
                                                    CEP *
                                                </Label>
                                                <Input
                                                    id="cep"
                                                    name="cep"
                                                    placeholder="00000-000"
                                                    defaultValue={company.cep}
                                                    required
                                                />
                                                {errors.cep && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.cep}
                                                    </p>
                                                )}
                                            </div>

                                            <div className="space-y-2 md:col-span-4">
                                                <Label htmlFor="street">
                                                    Logradouro *
                                                </Label>
                                                <Input
                                                    id="street"
                                                    name="street"
                                                    placeholder="Rua, Avenida, etc."
                                                    defaultValue={company.street}
                                                    required
                                                />
                                                {errors.street && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.street}
                                                    </p>
                                                )}
                                            </div>

                                            <div className="space-y-2 md:col-span-2">
                                                <Label htmlFor="number">
                                                    Número *
                                                </Label>
                                                <Input
                                                    id="number"
                                                    name="number"
                                                    placeholder="123"
                                                    defaultValue={company.number}
                                                    required
                                                />
                                                {errors.number && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.number}
                                                    </p>
                                                )}
                                            </div>

                                            <div className="space-y-2 md:col-span-4">
                                                <Label htmlFor="city">
                                                    Cidade *
                                                </Label>
                                                <Input
                                                    id="city"
                                                    name="city"
                                                    placeholder="Nome da cidade"
                                                    defaultValue={company.city}
                                                    required
                                                />
                                                {errors.city && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.city}
                                                    </p>
                                                )}
                                            </div>

                                            <div className="space-y-2 md:col-span-2">
                                                <Label htmlFor="state">
                                                    Estado *
                                                </Label>
                                                <Input
                                                    id="state"
                                                    name="state"
                                                    placeholder="UF"
                                                    maxLength={2}
                                                    defaultValue={company.state}
                                                    required
                                                />
                                                {errors.state && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.state}
                                                    </p>
                                                )}
                                            </div>

                                            <div className="space-y-2 md:col-span-6">
                                                <Label htmlFor="country">
                                                    País *
                                                </Label>
                                                <Input
                                                    id="country"
                                                    name="country"
                                                    placeholder="Digite o país"
                                                    defaultValue={company.country}
                                                    required
                                                />
                                                {errors.country && (
                                                    <p className="text-sm text-red-600 dark:text-red-400">
                                                        {errors.country}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
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
