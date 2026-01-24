import { Head, Link, usePage } from '@inertiajs/react';
import {
    ArrowRight,
    BarChart3,
    CheckCircle2,
    Clock,
    Package,
    ShieldCheck,
    TrendingUp,
    Users,
} from 'lucide-react';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { dashboard, login, register } from '@/routes';
import type { SharedData } from '@/types';

export default function Welcome({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth } = usePage<SharedData>().props;

    const features = [
        {
            icon: Package,
            title: 'Gestão de Inventário',
            description:
                'Controle completo de itens disponíveis para locação com categorização e status em tempo real.',
        },
        {
            icon: Users,
            title: 'Cadastro de Clientes',
            description:
                'Gerencie seus clientes com facilidade, mantendo histórico completo de locações.',
        },
        {
            icon: BarChart3,
            title: 'Dashboard Analítico',
            description:
                'Visualize métricas importantes como receita, devoluções e performance em períodos customizados.',
        },
        {
            icon: Clock,
            title: 'Controle de Prazos',
            description:
                'Monitore datas de retirada e entrega, com sistema de devoluções integrado.',
        },
        {
            icon: ShieldCheck,
            title: 'Segurança',
            description:
                'Sistema seguro com autenticação robusta e controle de permissões de usuários.',
        },
        {
            icon: TrendingUp,
            title: 'Relatórios',
            description:
                'Acompanhe o crescimento do seu negócio com relatórios detalhados e filtros avançados.',
        },
    ];

    return (
        <>
            <Head title="Sistema de Locação" />
            <div className="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-950 dark:to-gray-900">
                {/* Header */}
                <header className="border-b bg-white/50 backdrop-blur-sm dark:bg-gray-950/50">
                    <div className="container mx-auto flex h-16 items-center justify-between px-4">
                        <div className="flex items-center gap-2">
                            <Package className="h-8 w-8 text-primary" />
                            <span className="text-xl font-bold">
                                RentalStore
                            </span>
                        </div>
                        <nav className="flex items-center gap-4">
                            {auth.user ? (
                                <Button asChild>
                                    <Link href={dashboard()}>
                                        Dashboard
                                        <ArrowRight className="ml-2 h-4 w-4" />
                                    </Link>
                                </Button>
                            ) : (
                                <>
                                    <Button variant="ghost" asChild>
                                        <Link href={login()}>Entrar</Link>
                                    </Button>
                                    {canRegister && (
                                        <Button asChild>
                                            <Link href={register()}>
                                                Cadastrar
                                            </Link>
                                        </Button>
                                    )}
                                </>
                            )}
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="container mx-auto px-4 py-20 text-center lg:py-32">
                    <div className="mx-auto max-w-4xl space-y-8">
                        <div className="inline-flex items-center gap-2 rounded-full border bg-primary/10 px-4 py-2 text-sm font-medium text-primary">
                            <CheckCircle2 className="h-4 w-4" />
                            Sistema Completo de Gestão
                        </div>
                        <h1 className="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl">
                            Gerencie suas{' '}
                            <span className="bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-transparent">
                                locações
                            </span>
                            <br />
                            com facilidade
                        </h1>
                        <p className="mx-auto max-w-2xl text-lg text-muted-foreground sm:text-xl">
                            Sistema completo para gerenciamento de locações.
                            Controle inventário, clientes, aluguéis e acompanhe
                            suas métricas em tempo real.
                        </p>
                        <div className="flex flex-col items-center justify-center gap-4 sm:flex-row">
                            {auth.user ? (
                                <Button size="lg" asChild className="text-base">
                                    <Link href={dashboard()}>
                                        Ir para Dashboard
                                        <ArrowRight className="ml-2 h-5 w-5" />
                                    </Link>
                                </Button>
                            ) : (
                                <>
                                    <Button
                                        size="lg"
                                        asChild
                                        className="text-base"
                                    >
                                        <Link href={register()}>
                                            Começar Agora
                                            <ArrowRight className="ml-2 h-5 w-5" />
                                        </Link>
                                    </Button>
                                    <Button
                                        size="lg"
                                        variant="outline"
                                        asChild
                                        className="text-base"
                                    >
                                        <Link href={login()}>Fazer Login</Link>
                                    </Button>
                                </>
                            )}
                        </div>
                    </div>
                </section>

                {/* Features Section */}
                <section className="border-t bg-gray-50/50 py-20 dark:bg-gray-900/50">
                    <div className="container mx-auto px-4">
                        <div className="mb-16 text-center">
                            <h2 className="mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                                Recursos Principais
                            </h2>
                            <p className="mx-auto max-w-2xl text-lg text-muted-foreground">
                                Tudo que você precisa para gerenciar seu negócio
                                de locações em um só lugar
                            </p>
                        </div>
                        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            {features.map((feature, index) => (
                                <Card
                                    key={index}
                                    className="transition-all hover:shadow-lg"
                                >
                                    <CardHeader>
                                        <div className="mb-2 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                                            <feature.icon className="h-6 w-6 text-primary" />
                                        </div>
                                        <CardTitle>{feature.title}</CardTitle>
                                        <CardDescription>
                                            {feature.description}
                                        </CardDescription>
                                    </CardHeader>
                                </Card>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Stats Section */}
                <section className="py-20">
                    <div className="container mx-auto px-4">
                        <div className="rounded-2xl border bg-white p-8 shadow-sm sm:p-12 dark:bg-gray-950">
                            <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                                <div className="text-center">
                                    <div className="mb-2 text-4xl font-bold text-primary">
                                        100%
                                    </div>
                                    <div className="text-sm text-muted-foreground">
                                        Controle Total
                                    </div>
                                </div>
                                <div className="text-center">
                                    <div className="mb-2 text-4xl font-bold text-primary">
                                        24/7
                                    </div>
                                    <div className="text-sm text-muted-foreground">
                                        Acesso ao Sistema
                                    </div>
                                </div>
                                <div className="text-center">
                                    <div className="mb-2 text-4xl font-bold text-primary">
                                        Real-Time
                                    </div>
                                    <div className="text-sm text-muted-foreground">
                                        Dados em Tempo Real
                                    </div>
                                </div>
                                <div className="text-center">
                                    <div className="mb-2 text-4xl font-bold text-primary">
                                        Seguro
                                    </div>
                                    <div className="text-sm text-muted-foreground">
                                        Proteção de Dados
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                {!auth.user && (
                    <section className="border-t py-20">
                        <div className="container mx-auto px-4 text-center">
                            <div className="mx-auto max-w-3xl space-y-8">
                                <h2 className="text-3xl font-bold tracking-tight sm:text-4xl">
                                    Pronto para começar?
                                </h2>
                                <p className="text-lg text-muted-foreground">
                                    Cadastre-se agora e comece a gerenciar suas
                                    locações de forma profissional.
                                </p>
                                <div className="flex flex-col items-center justify-center gap-4 sm:flex-row">
                                    <Button
                                        size="lg"
                                        asChild
                                        className="text-base"
                                    >
                                        <Link href={register()}>
                                            Criar Conta Grátis
                                            <ArrowRight className="ml-2 h-5 w-5" />
                                        </Link>
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </section>
                )}

                {/* Footer */}
                <footer className="border-t py-8">
                    <div className="container mx-auto px-4 text-center text-sm text-muted-foreground">
                        <p>
                            © {new Date().getFullYear()} RentalStore. Sistema de
                            Gestão de Locações.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}
