import { Button } from '@/components/ui/button';
import {
    Card,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { dashboard, login, register } from '@/routes';
import type { SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import {
    ArrowRight,
    BarChart3,
    Building2,
    CheckCircle2,
    Clock,
    Globe,
    Package,
    ShieldCheck,
    Sparkles,
    TrendingUp,
    Users,
    Zap,
} from 'lucide-react';
import { useEffect, useState } from 'react';

export default function Welcome({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth } = usePage<SharedData>().props;
    const [isVisible, setIsVisible] = useState(false);
    const [count1, setCount1] = useState(0);
    const [count2, setCount2] = useState(0);
    const [count3, setCount3] = useState(0);

    useEffect(() => {
        setIsVisible(true);

        // Animated counters
        const duration = 2000;
        const steps = 60;
        const increment1 = 99 / steps;
        const increment2 = 24 / steps;
        const increment3 = 100 / steps;

        let currentStep = 0;
        const timer = setInterval(() => {
            currentStep++;
            setCount1(Math.min(Math.round(increment1 * currentStep), 99));
            setCount2(Math.min(Math.round(increment2 * currentStep), 24));
            setCount3(Math.min(Math.round(increment3 * currentStep), 100));

            if (currentStep >= steps) {
                clearInterval(timer);
            }
        }, duration / steps);

        return () => clearInterval(timer);
    }, []);

    const features = [
        {
            icon: Package,
            title: 'Gestão de Inventário',
            description:
                'Controle completo de itens disponíveis para locação com categorização e status em tempo real.',
            color: 'from-blue-500 to-cyan-500',
        },
        {
            icon: Users,
            title: 'Cadastro de Clientes',
            description:
                'Gerencie seus clientes com facilidade, mantendo histórico completo de locações.',
            color: 'from-purple-500 to-pink-500',
        },
        {
            icon: BarChart3,
            title: 'Dashboard Analítico',
            description:
                'Visualize métricas importantes como receita, devoluções e performance em períodos customizados.',
            color: 'from-orange-500 to-red-500',
        },
        {
            icon: Clock,
            title: 'Controle de Prazos',
            description:
                'Monitore datas de retirada e entrega, com sistema de devoluções integrado.',
            color: 'from-green-500 to-emerald-500',
        },
        {
            icon: ShieldCheck,
            title: 'Segurança',
            description:
                'Sistema seguro com autenticação robusta e controle de permissões de usuários.',
            color: 'from-indigo-500 to-blue-500',
        },
        {
            icon: TrendingUp,
            title: 'Relatórios',
            description:
                'Acompanhe o crescimento do seu negócio com relatórios detalhados e filtros avançados.',
            color: 'from-yellow-500 to-orange-500',
        },
        {
            icon: Building2,
            title: 'Multi-Tenancy',
            description:
                'Suporte completo para múltiplos tenants com isolamento de dados e personalização.',
            color: 'from-teal-500 to-cyan-500',
        },
        {
            icon: Zap,
            title: 'Performance',
            description:
                'Sistema otimizado para alto desempenho, garantindo rapidez em todas as operações.',
            color: 'from-pink-500 to-rose-500',
        },
        {
            icon: Globe,
            title: 'Acesso Global',
            description:
                'Acesse seu sistema de qualquer lugar, a qualquer momento, de forma segura.',
            color: 'from-violet-500 to-purple-500',
        },
    ];

    return (
        <>
            <Head title="Sistema de Locação" />
            <div className="relative min-h-screen overflow-hidden bg-gradient-to-b from-gray-50 via-white to-gray-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950">
                {/* Animated background */}
                <div className="pointer-events-none absolute inset-0 overflow-hidden">
                    <div className="absolute -top-1/4 -left-1/4 h-96 w-96 animate-pulse rounded-full bg-primary/5 blur-3xl" />
                    <div className="absolute top-1/4 -right-1/4 h-96 w-96 animate-pulse rounded-full bg-purple-500/5 blur-3xl delay-1000" />
                    <div className="absolute -bottom-1/4 left-1/2 h-96 w-96 animate-pulse rounded-full bg-blue-500/5 blur-3xl delay-2000" />
                </div>

                {/* Header */}
                <header className="relative border-b bg-white/50 backdrop-blur-md dark:bg-gray-950/50">
                    <div className="container mx-auto flex h-16 items-center justify-between px-4">
                        <div className="flex items-center gap-2">
                            <div className="relative">
                                <Package className="h-8 w-8 text-primary" />
                                <Sparkles className="absolute -top-1 -right-1 h-4 w-4 animate-pulse text-yellow-500" />
                            </div>
                            <span className="bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-xl font-bold text-transparent">
                                RentalStore
                            </span>
                        </div>
                        <nav className="flex items-center gap-4">
                            {auth.user ? (
                                <Button asChild className="group">
                                    <Link href={dashboard()}>
                                        Dashboard
                                        <ArrowRight className="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
                                    </Link>
                                </Button>
                            ) : (
                                <>
                                    <Button variant="ghost" asChild>
                                        <Link href={login()}>Entrar</Link>
                                    </Button>
                                    {canRegister && (
                                        <Button asChild className="group">
                                            <Link href={register()}>
                                                Cadastrar
                                                <Sparkles className="ml-2 h-4 w-4 transition-transform group-hover:rotate-180" />
                                            </Link>
                                        </Button>
                                    )}
                                </>
                            )}
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="relative container mx-auto px-4 py-20 text-center lg:py-32">
                    <div
                        className={`mx-auto max-w-5xl space-y-8 transition-all duration-1000 ${
                            isVisible
                                ? 'translate-y-0 opacity-100'
                                : 'translate-y-10 opacity-0'
                        }`}
                    >
                        <div className="inline-flex animate-bounce items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-sm font-medium text-primary backdrop-blur-sm">
                            <Sparkles className="h-4 w-4 animate-pulse" />
                            Sistema Completo de Gestão Multi-Tenant
                            <Sparkles className="h-4 w-4 animate-pulse" />
                        </div>
                        <h1 className="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl lg:text-7xl leading-24">
                            Gerencie suas{' '}
                            <span className="relative">
                                <span className="animate-gradient bg-gradient-to-r from-primary via-purple-500 to-primary bg-clip-text text-transparent">
                                    locações
                                </span>
                                <span className="absolute -bottom-2 left-0 h-1 w-full animate-pulse rounded-full bg-gradient-to-r from-primary via-purple-500 to-primary" />
                            </span>
                            <br />
                            com{' '}
                            <span className="bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">
                                facilidade
                            </span>{' '}
                            e{' '}
                            <span className="bg-gradient-to-r from-blue-500 to-cyan-500 bg-clip-text text-transparent">
                                eficiência
                            </span>
                        </h1>
                        <p className="mx-auto max-w-2xl text-lg text-muted-foreground sm:text-xl">
                            Sistema completo e moderno para gerenciamento de
                            locações. Controle inventário, clientes, aluguéis e
                            acompanhe suas métricas em tempo real com interface
                            intuitiva e recursos avançados.
                        </p>
                        <div className="flex flex-col items-center justify-center gap-4 sm:flex-row">
                            {auth.user ? (
                                <Button
                                    size="lg"
                                    asChild
                                    className="group text-base shadow-lg shadow-primary/25 transition-all hover:shadow-xl hover:shadow-primary/40"
                                >
                                    <Link href={dashboard()}>
                                        Ir para Dashboard
                                        <ArrowRight className="ml-2 h-5 w-5 transition-transform group-hover:translate-x-2" />
                                    </Link>
                                </Button>
                            ) : (
                                <>
                                    <Button
                                        size="lg"
                                        asChild
                                        className="group text-base shadow-lg shadow-primary/25 transition-all hover:shadow-xl hover:shadow-primary/40"
                                    >
                                        <Link href={register()}>
                                            <Sparkles className="mr-2 h-5 w-5 animate-pulse" />
                                            Começar Agora
                                            <ArrowRight className="ml-2 h-5 w-5 transition-transform group-hover:translate-x-2" />
                                        </Link>
                                    </Button>
                                    <Button
                                        size="lg"
                                        variant="outline"
                                        asChild
                                        className="group text-base backdrop-blur-sm transition-all hover:scale-105"
                                    >
                                        <Link href={login()}>
                                            Fazer Login
                                            <ArrowRight className="ml-2 h-4 w-4 opacity-0 transition-all group-hover:translate-x-1 group-hover:opacity-100" />
                                        </Link>
                                    </Button>
                                </>
                            )}
                        </div>

                        {/* Floating elements */}
                        <div className="relative mx-auto mt-16 max-w-4xl">
                            <div className="grid gap-4 sm:grid-cols-3">
                                <div className="group animate-float rounded-xl border bg-white/50 p-6 backdrop-blur-sm transition-all hover:scale-105 hover:shadow-lg dark:bg-gray-950/50">
                                    <div className="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 transition-transform group-hover:rotate-12">
                                        <Package className="h-6 w-6 text-white" />
                                    </div>
                                    <div className="text-2xl font-bold">
                                        Ilimitado
                                    </div>
                                    <div className="text-sm text-muted-foreground">
                                        Itens cadastrados
                                    </div>
                                </div>
                                <div className="group animate-float rounded-xl border bg-white/50 p-6 backdrop-blur-sm transition-all delay-100 hover:scale-105 hover:shadow-lg dark:bg-gray-950/50">
                                    <div className="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-pink-500 transition-transform group-hover:rotate-12">
                                        <Users className="h-6 w-6 text-white" />
                                    </div>
                                    <div className="text-2xl font-bold">
                                        Multi-User
                                    </div>
                                    <div className="text-sm text-muted-foreground">
                                        Gestão colaborativa
                                    </div>
                                </div>
                                <div className="group animate-float rounded-xl border bg-white/50 p-6 backdrop-blur-sm transition-all delay-200 hover:scale-105 hover:shadow-lg dark:bg-gray-950/50">
                                    <div className="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-orange-500 to-red-500 transition-transform group-hover:rotate-12">
                                        <Zap className="h-6 w-6 text-white" />
                                    </div>
                                    <div className="text-2xl font-bold">
                                        Real-Time
                                    </div>
                                    <div className="text-sm text-muted-foreground">
                                        Dados ao vivo
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Features Section */}
                <section className="relative border-t bg-gradient-to-b from-gray-50/50 to-white py-20 dark:from-gray-900/50 dark:to-gray-950">
                    <div className="container mx-auto px-4">
                        <div
                            className={`mb-16 text-center transition-all delay-300 duration-1000 ${
                                isVisible
                                    ? 'translate-y-0 opacity-100'
                                    : 'translate-y-10 opacity-0'
                            }`}
                        >
                            <div className="mb-4 inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-4 py-1 text-sm font-medium text-primary">
                                <Zap className="h-3 w-3 animate-pulse" />
                                Recursos Poderosos
                            </div>
                            <h2 className="mb-4 text-3xl font-bold tracking-tight sm:text-4xl md:text-5xl">
                                Tudo que você precisa,{' '}
                                <span className="bg-gradient-to-r from-primary to-purple-500 bg-clip-text text-transparent">
                                    em um só lugar
                                </span>
                            </h2>
                            <p className="mx-auto max-w-2xl text-lg text-muted-foreground">
                                Recursos avançados pensados para tornar seu
                                negócio mais eficiente e lucrativo
                            </p>
                        </div>
                        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            {features.map((feature, index) => (
                                <Card
                                    key={index}
                                    className={`group relative overflow-hidden border-2 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl ${
                                        isVisible
                                            ? 'translate-y-0 opacity-100'
                                            : 'translate-y-10 opacity-0'
                                    }`}
                                >
                                    <div
                                        className={`absolute inset-0 bg-gradient-to-br ${feature.color} opacity-0 transition-opacity duration-500 group-hover:opacity-10`}
                                    />
                                    <CardHeader className="relative">
                                        <div
                                            className={`mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br ${feature.color} shadow-lg transition-all duration-500 group-hover:scale-110 group-hover:rotate-6`}
                                        >
                                            <feature.icon className="h-7 w-7 text-white" />
                                        </div>
                                        <CardTitle className="text-xl transition-colors group-hover:text-primary">
                                            {feature.title}
                                        </CardTitle>
                                        <CardDescription className="text-base">
                                            {feature.description}
                                        </CardDescription>
                                        <div
                                            className={`absolute -bottom-4 left-0 h-1 w-0 rounded-full bg-gradient-to-r ${feature.color} transition-all duration-500 group-hover:w-full`}
                                        />
                                    </CardHeader>
                                </Card>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Stats Section */}
                <section className="relative py-20">
                    <div className="container mx-auto px-4">
                        <div className="relative overflow-hidden rounded-3xl border-2 bg-gradient-to-br from-primary/5 via-purple-500/5 to-blue-500/5 p-8 shadow-2xl backdrop-blur-sm sm:p-12">
                            <div className="absolute -top-20 -right-20 h-40 w-40 rounded-full bg-primary/10 blur-3xl" />
                            <div className="absolute -bottom-20 -left-20 h-40 w-40 rounded-full bg-purple-500/10 blur-3xl" />

                            <div className="relative grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                                <div className="group text-center transition-transform hover:scale-110">
                                    <div className="mb-2 bg-gradient-to-r from-primary to-purple-500 bg-clip-text text-5xl font-bold text-transparent transition-all">
                                        {count3}%
                                    </div>
                                    <div className="text-sm font-medium text-muted-foreground">
                                        Controle Total
                                    </div>
                                    <div className="mx-auto mt-2 h-1 w-0 rounded-full bg-gradient-to-r from-primary to-purple-500 transition-all duration-500 group-hover:w-full" />
                                </div>
                                <div className="group text-center transition-transform hover:scale-110">
                                    <div className="mb-2 bg-gradient-to-r from-blue-500 to-cyan-500 bg-clip-text text-5xl font-bold text-transparent transition-all">
                                        {count2}/7
                                    </div>
                                    <div className="text-sm font-medium text-muted-foreground">
                                        Acesso ao Sistema
                                    </div>
                                    <div className="mx-auto mt-2 h-1 w-0 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 transition-all duration-500 group-hover:w-full" />
                                </div>
                                <div className="group text-center transition-transform hover:scale-110">
                                    <div className="mb-2 flex items-center justify-center gap-2 text-5xl font-bold">
                                        <Zap className="h-10 w-10 animate-pulse text-orange-500" />
                                        <span className="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">
                                            Fast
                                        </span>
                                    </div>
                                    <div className="text-sm font-medium text-muted-foreground">
                                        Dados em Tempo Real
                                    </div>
                                    <div className="mx-auto mt-2 h-1 w-0 rounded-full bg-gradient-to-r from-orange-500 to-red-500 transition-all duration-500 group-hover:w-full" />
                                </div>
                                <div className="group text-center transition-transform hover:scale-110">
                                    <div className="mb-2 flex items-center justify-center gap-2 text-5xl font-bold">
                                        <ShieldCheck className="h-10 w-10 animate-pulse text-green-500" />
                                        <span className="bg-gradient-to-r from-green-500 to-emerald-500 bg-clip-text text-transparent">
                                            100%
                                        </span>
                                    </div>
                                    <div className="text-sm font-medium text-muted-foreground">
                                        Proteção de Dados
                                    </div>
                                    <div className="mx-auto mt-2 h-1 w-0 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 transition-all duration-500 group-hover:w-full" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                {!auth.user && (
                    <section className="relative border-t py-20">
                        <div className="container mx-auto px-4 text-center">
                            <div className="mx-auto max-w-3xl space-y-8">
                                <div className="inline-flex animate-bounce items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-4 py-2 text-sm font-medium text-primary">
                                    <Sparkles className="h-4 w-4 animate-spin" />
                                    Comece Hoje
                                </div>
                                <h2 className="text-3xl font-bold tracking-tight sm:text-4xl md:text-5xl">
                                    Pronto para{' '}
                                    <span className="bg-gradient-to-r from-primary via-purple-500 to-pink-500 bg-clip-text text-transparent">
                                        transformar
                                    </span>
                                    <br />
                                    seu negócio?
                                </h2>
                                <p className="text-lg text-muted-foreground sm:text-xl">
                                    Cadastre-se agora e comece a gerenciar suas
                                    locações de forma profissional e eficiente.
                                </p>
                                <div className="flex flex-col items-center justify-center gap-4 sm:flex-row">
                                    <Button
                                        size="lg"
                                        asChild
                                        className="group relative overflow-hidden text-base shadow-lg shadow-primary/25 transition-all hover:shadow-xl hover:shadow-primary/40"
                                    >
                                        <Link href={register()}>
                                            <span className="absolute inset-0 bg-gradient-to-r from-primary via-purple-500 to-primary opacity-0 transition-opacity group-hover:opacity-100" />
                                            <span className="relative flex items-center">
                                                <Sparkles className="mr-2 h-5 w-5 animate-pulse" />
                                                Criar Conta Grátis
                                                <ArrowRight className="ml-2 h-5 w-5 transition-transform group-hover:translate-x-2" />
                                            </span>
                                        </Link>
                                    </Button>
                                    <Button
                                        size="lg"
                                        variant="outline"
                                        asChild
                                        className="group text-base backdrop-blur-sm transition-all hover:scale-105"
                                    >
                                        <Link href={login()}>
                                            Já tenho uma conta
                                            <ArrowRight className="ml-2 h-4 w-4 opacity-0 transition-all group-hover:translate-x-1 group-hover:opacity-100" />
                                        </Link>
                                    </Button>
                                </div>
                                <div className="pt-8">
                                    <div className="flex flex-wrap items-center justify-center gap-8 text-sm text-muted-foreground">
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="h-4 w-4 text-green-500" />
                                            Sem cartão de crédito
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="h-4 w-4 text-green-500" />
                                            Configuração em minutos
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <CheckCircle2 className="h-4 w-4 text-green-500" />
                                            Suporte dedicado
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                )}

                {/* Footer */}
                <footer className="border-t bg-gradient-to-b from-transparent to-gray-50/50 py-12 dark:to-gray-950/50">
                    <div className="container mx-auto px-4">
                        <div className="flex flex-col items-center gap-6">
                            <div className="flex items-center gap-2">
                                <Package className="h-6 w-6 text-primary" />
                                <span className="bg-gradient-to-r from-primary to-primary/60 bg-clip-text text-lg font-bold text-transparent">
                                    RentalStore
                                </span>
                            </div>
                            <div className="flex flex-wrap items-center justify-center gap-6 text-sm text-muted-foreground">
                                <span className="flex items-center gap-2">
                                    <ShieldCheck className="h-4 w-4" />
                                    Sistema Seguro
                                </span>
                                <span className="flex items-center gap-2">
                                    <Zap className="h-4 w-4" />
                                    Alta Performance
                                </span>
                                <span className="flex items-center gap-2">
                                    <Globe className="h-4 w-4" />
                                    Acesso Global
                                </span>
                            </div>
                            <div className="text-center text-sm text-muted-foreground">
                                <p>
                                    © {new Date().getFullYear()} RentalStore.
                                    Sistema de Gestão de Locações Multi-Tenant.
                                </p>
                                <p className="mt-1">
                                    Desenvolvido com{' '}
                                    <span className="animate-pulse text-red-500">
                                        ♥
                                    </span>{' '}
                                    usando Laravel + React
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}
