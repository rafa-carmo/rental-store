import { Head, router } from '@inertiajs/react';
import {
    BarChart3,
    Calendar,
    Package,
    TrendingUp,
    Undo2,
    Users,
} from 'lucide-react';

import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';

interface Stats {
    itemsCount: number;
    customersCount: number;
    rentalsCount: number;
    returnsCount: number;
    totalRevenue: number;
}

interface Props {
    stats: Stats;
    period: string;
}

const periodOptions = [
    { value: '1', label: 'Último mês' },
    { value: '3', label: 'Últimos 3 meses' },
    { value: '6', label: 'Últimos 6 meses' },
    { value: '12', label: 'Último ano' },
];

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    }).format(value);
};

export default function DashboardIndex({ stats, period }: Props) {
    const handlePeriodChange = (newPeriod: string) => {
        router.get(
            route('dashboard'),
            { period: newPeriod },
            {
                preserveState: true,
                preserveScroll: true,
            },
        );
    };

    return (
        <AppLayout>
            <Head title="Dashboard" />

            <div className="flex flex-col gap-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">
                            Dashboard
                        </h1>
                        <p className="text-muted-foreground">
                            Visão geral das métricas do sistema
                        </p>
                    </div>

                    <Select value={period} onValueChange={handlePeriodChange}>
                        <SelectTrigger className="w-[180px]">
                            <SelectValue placeholder="Selecione o período" />
                        </SelectTrigger>
                        <SelectContent>
                            {periodOptions.map((option) => (
                                <SelectItem
                                    key={option.value}
                                    value={option.value}
                                >
                                    {option.label}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Itens Cadastrados
                            </CardTitle>
                            <Package className="size-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {stats.itemsCount}
                            </div>
                            <p className="text-xs text-muted-foreground">
                                {
                                    periodOptions.find(
                                        (p) => p.value === period,
                                    )?.label
                                }
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Clientes Cadastrados
                            </CardTitle>
                            <Users className="size-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {stats.customersCount}
                            </div>
                            <p className="text-xs text-muted-foreground">
                                {
                                    periodOptions.find(
                                        (p) => p.value === period,
                                    )?.label
                                }
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Aluguéis
                            </CardTitle>
                            <Calendar className="size-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {stats.rentalsCount}
                            </div>
                            <p className="text-xs text-muted-foreground">
                                {
                                    periodOptions.find(
                                        (p) => p.value === period,
                                    )?.label
                                }
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Devoluções
                            </CardTitle>
                            <Undo2 className="size-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {stats.returnsCount}
                            </div>
                            <p className="text-xs text-muted-foreground">
                                {
                                    periodOptions.find(
                                        (p) => p.value === period,
                                    )?.label
                                }
                            </p>
                        </CardContent>
                    </Card>

                    <Card className="md:col-span-2">
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Valor Arrecadado
                            </CardTitle>
                            <TrendingUp className="size-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {formatCurrency(stats.totalRevenue)}
                            </div>
                            <p className="text-xs text-muted-foreground">
                                {
                                    periodOptions.find(
                                        (p) => p.value === period,
                                    )?.label
                                }
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Análise de Desempenho</CardTitle>
                        <CardDescription>
                            Resumo das atividades no período selecionado
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            <div className="flex items-center justify-between border-b pb-2">
                                <div className="flex items-center gap-2">
                                    <BarChart3 className="size-4 text-muted-foreground" />
                                    <span className="text-sm">
                                        Taxa de Devolução
                                    </span>
                                </div>
                                <span className="text-sm font-medium">
                                    {stats.rentalsCount > 0
                                        ? `${Math.round((stats.returnsCount / stats.rentalsCount) * 100)}%`
                                        : '0%'}
                                </span>
                            </div>

                            <div className="flex items-center justify-between border-b pb-2">
                                <div className="flex items-center gap-2">
                                    <BarChart3 className="size-4 text-muted-foreground" />
                                    <span className="text-sm">
                                        Valor Médio por Aluguel
                                    </span>
                                </div>
                                <span className="text-sm font-medium">
                                    {stats.rentalsCount > 0
                                        ? formatCurrency(
                                              stats.totalRevenue /
                                                  stats.rentalsCount,
                                          )
                                        : formatCurrency(0)}
                                </span>
                            </div>

                            <div className="flex items-center justify-between">
                                <div className="flex items-center gap-2">
                                    <BarChart3 className="size-4 text-muted-foreground" />
                                    <span className="text-sm">
                                        Aluguéis Pendentes
                                    </span>
                                </div>
                                <span className="text-sm font-medium">
                                    {stats.rentalsCount - stats.returnsCount}
                                </span>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
